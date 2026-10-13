<?php

namespace App\Http\Controllers;

use App\Models\Conflict;
use App\Models\Exam;
use App\Models\SeatingArrangement;
use App\Models\Staff;
use App\Models\Student;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StaffPortalController extends Controller
{
    public function examDuties(Request $request): View
    {
        $staff = $this->resolveStaff($request);

        $exams = Exam::withCount(['registrations', 'seatingArrangements'])
            ->where('exam_date', '>=', now()->toDateString())
            ->whereIn('status', ['scheduled', 'in_progress'])
            ->orderBy('exam_date')
            ->orderBy('start_time')
            ->paginate(10);

        return view('staff.exam_duties', compact('staff', 'exams'));
    }

    public function showExam(Request $request, Exam $exam): View
    {
        $this->resolveStaff($request);

        $exam->load([
            'registrations.student.user',
            'registrations.subject',
            'seatingArrangements.student.user',
            'seatingArrangements.examHall',
            'seatingArrangements.hallSeat',
            'seatingArrangements.subject',
        ]);

        return view('staff.exam_show', compact('exam'));
    }

    public function seating(Request $request): View
    {
        $staff = $this->resolveStaff($request);

        $exams = Exam::where('exam_date', '>=', now()->toDateString())
            ->whereIn('status', ['scheduled', 'in_progress'])
            ->orderBy('exam_date')
            ->get(['id', 'name', 'exam_code']);

        $query = SeatingArrangement::with(['exam', 'student.user', 'examHall', 'hallSeat', 'subject'])
            ->latest('assigned_at');

        if ($request->filled('exam_id')) {
            $query->where('exam_id', $request->integer('exam_id'));
        }

        $arrangements = $query->paginate(15)->withQueryString();

        return view('staff.seating', compact('staff', 'arrangements', 'exams'));
    }

    public function conflicts(Request $request): View
    {
        $staff = $this->resolveStaff($request);

        $conflicts = Conflict::with(['exam', 'student.user', 'resolvedBy'])
            ->latest()
            ->paginate(10);

        return view('staff.conflicts.index', compact('staff', 'conflicts'));
    }

    public function createConflict(Request $request): View
    {
        $staff = $this->resolveStaff($request);

        $exams = Exam::orderByDesc('exam_date')->get();
        $students = Student::with('user')->orderBy('student_code')->get();
        $seatingArrangements = SeatingArrangement::with(['exam', 'student.user', 'examHall', 'hallSeat'])
            ->latest('assigned_at')
            ->limit(200)
            ->get();

        return view('staff.conflicts.create', compact('staff', 'exams', 'students', 'seatingArrangements'));
    }

    public function storeConflict(Request $request): RedirectResponse
    {
        $this->resolveStaff($request);

        $validated = $request->validate([
            'exam_id' => ['nullable', 'exists:exams,id'],
            'student_id' => ['nullable', 'exists:students,id'],
            'seating_arrangement_id' => ['nullable', 'exists:seating_arrangements,id'],
            'conflict_type' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'severity' => ['nullable', 'string', 'in:low,medium,high,critical'],
        ]);

        Conflict::create([
            ...$validated,
            'severity' => $validated['severity'] ?? 'medium',
            'status' => 'open',
        ]);

        return redirect()->route('staff.conflicts.index')
            ->with('success', 'Conflict reported successfully. The admin team will review it.');
    }

    public function showConflict(Request $request, Conflict $conflict): View
    {
        $this->resolveStaff($request);

        $conflict->load(['exam', 'student.user', 'seatingArrangement.examHall', 'seatingArrangement.hallSeat', 'resolvedBy']);

        return view('staff.conflicts.show', compact('conflict'));
    }

    public function profile(Request $request): View
    {
        $staff = $this->resolveStaff($request);

        if ($staff) {
            $staff->load('user');
        }

        return view('staff.profile', compact('staff'));
    }

    protected function resolveStaff(Request $request): ?Staff
    {
        if ($request->user()->role !== 'staff') {
            abort(403, 'You do not have permission to access this page.');
        }

        return $request->user()->staff;
    }
}
