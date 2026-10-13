<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Exam;
use App\Models\ExamHall;
use App\Models\Conflict;
use App\Models\SeatingArrangement;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->role === 'student') {
            $student = $user->student;

            return view('dashboard', [
                'student' => $student,
                'upcomingExamsCount' => $student
                    ? $student->registrations()->whereHas('exam', fn ($q) => $q->where('exam_date', '>=', now()->toDateString()))->count()
                    : 0,
                'registeredExamsCount' => $student ? $student->registrations()->count() : 0,
                'seatingCount' => $student ? $student->seatingArrangements()->count() : 0,
                'recentRegistrations' => $student
                    ? $student->registrations()->with(['exam', 'subject'])->latest()->take(5)->get()
                    : collect(),
            ]);
        }

        if ($user->role === 'staff') {
            $staff = $user->staff;

            $upcomingExamsQuery = Exam::where('exam_date', '>=', now()->toDateString())
                ->whereIn('status', ['scheduled', 'in_progress']);

            return view('dashboard', [
                'staff' => $staff,
                'upcomingDutiesCount' => $upcomingExamsQuery->count(),
                'openConflictsCount' => Conflict::whereIn('status', ['open', 'investigating'])->count(),
                'seatingAllocationsCount' => SeatingArrangement::whereHas(
                    'exam',
                    fn ($q) => $q->where('exam_date', '>=', now()->toDateString())
                )->count(),
                'upcomingExams' => (clone $upcomingExamsQuery)
                    ->orderBy('exam_date')
                    ->orderBy('start_time')
                    ->take(5)
                    ->get(),
            ]);
        }

        return view('dashboard', [
            'totalStudents' => Student::count(),
            'totalExams' => Exam::count(),
            'totalHalls' => ExamHall::count(),
            'openConflicts' => Conflict::where('status', 'open')->count(),
        ]);
    }
}
