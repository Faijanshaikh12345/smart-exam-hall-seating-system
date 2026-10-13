<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StudentPortalController extends Controller
{
    public function exams(Request $request): View
    {
        $student = $this->resolveStudent($request);

        $registrations = collect();

        if ($student) {
            $registrations = $student->registrations()
                ->with(['exam', 'subject'])
                ->latest()
                ->paginate(10);
        }

        return view('student.exams', compact('student', 'registrations'));
    }

    public function seating(Request $request): View
    {
        $student = $this->resolveStudent($request);

        $arrangements = collect();

        if ($student) {
            $arrangements = $student->seatingArrangements()
                ->with(['exam', 'examHall', 'hallSeat', 'subject'])
                ->latest('assigned_at')
                ->paginate(10);
        }

        return view('student.seating', compact('student', 'arrangements'));
    }

    public function profile(Request $request): View
    {
        $student = $this->resolveStudent($request);

        if ($student) {
            $student->load(['user', 'department']);
        }

        return view('student.profile', compact('student'));
    }

    protected function resolveStudent(Request $request): ?Student
    {
        if ($request->user()->role !== 'student') {
            abort(403, 'You do not have permission to access this page.');
        }

        return $request->user()->student;
    }
}
