<?php

namespace App\Http\Controllers;

use App\Models\Conflict;
use App\Models\Exam;
use App\Models\SeatingArrangement;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConflictController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $conflicts = Conflict::with(['exam', 'student.user', 'seatingArrangement', 'resolvedBy'])
            ->latest()
            ->paginate(10);

        return view('conflicts.index', compact('conflicts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $exams = Exam::all();
        $students = Student::with('user')->get();
        $seatingArrangements = SeatingArrangement::all();

        return view('conflicts.create', compact('exams', 'students', 'seatingArrangements'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'exam_id' => ['nullable', 'exists:exams,id'],
            'student_id' => ['nullable', 'exists:students,id'],
            'seating_arrangement_id' => ['nullable', 'exists:seating_arrangements,id'],
            'conflict_type' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'severity' => ['nullable', 'string', 'in:low,medium,high,critical'],
            'status' => ['nullable', 'string', 'in:open,investigating,resolved,dismissed'],
        ]);

        Conflict::create($validated);

        return redirect()->route('conflicts.index')
            ->with('success', 'Conflict reported successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Conflict $conflict)
    {
        $conflict->load(['exam', 'student.user', 'seatingArrangement', 'resolvedBy']);

        return view('conflicts.show', compact('conflict'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Conflict $conflict)
    {
        $exams = Exam::all();
        $students = Student::with('user')->get();
        $seatingArrangements = SeatingArrangement::all();
        $users = User::all();

        return view('conflicts.edit', compact('conflict', 'exams', 'students', 'seatingArrangements', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Conflict $conflict)
    {
        $validated = $request->validate([
            'exam_id' => ['nullable', 'exists:exams,id'],
            'student_id' => ['nullable', 'exists:students,id'],
            'seating_arrangement_id' => ['nullable', 'exists:seating_arrangements,id'],
            'conflict_type' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'severity' => ['nullable', 'string', 'in:low,medium,high,critical'],
            'status' => ['nullable', 'string', 'in:open,investigating,resolved,dismissed'],
            'resolution_notes' => ['nullable', 'string'],
            'resolved_by' => ['nullable', 'exists:users,id'],
            'resolved_at' => ['nullable', 'date'],
        ]);

        if (isset($validated['status']) && $validated['status'] === 'resolved') {
            $validated['resolved_by'] = $validated['resolved_by'] ?? Auth::id();
            $validated['resolved_at'] = $validated['resolved_at'] ?? now();
        }

        $conflict->update($validated);

        return redirect()->route('conflicts.index')
            ->with('success', 'Conflict updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Conflict $conflict)
    {
        $conflict->delete();

        return redirect()->route('conflicts.index')
            ->with('success', 'Conflict deleted successfully.');
    }
}
