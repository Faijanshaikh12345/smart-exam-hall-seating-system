<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $students = Student::with(['user', 'department'])
            ->latest()
            ->paginate(10);

        return view('students.index', compact('students'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $departments = Department::all();

        return view('students.create', compact('departments'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            // Main user information
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['nullable', 'string', 'min:6'],

            // Student profile information
            'department_id' => ['nullable', 'exists:departments,id'],
            'student_code' => ['required', 'string', 'max:50', 'unique:students,student_code'],
            'phone' => ['nullable', 'string', 'max:20'],
            'semester' => ['nullable', 'string', 'max:20'],
            'academic_year' => ['nullable', 'string', 'max:20'],
            'status' => ['nullable', 'string', 'in:active,inactive,graduated,suspended'],
        ]);

        DB::transaction(function () use ($validated) {
            // 1. Create User account with role 'student' by default
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => !empty($validated['password']) ? $validated['password'] : 'password123',
                'role' => 'student',
            ]);

            // 2. Create Student profile referencing the new User ID
            Student::create([
                'user_id' => $user->id,
                'department_id' => $validated['department_id'] ?? null,
                'student_code' => $validated['student_code'],
                'phone' => $validated['phone'] ?? null,
                'semester' => $validated['semester'] ?? null,
                'academic_year' => $validated['academic_year'] ?? null,
                'status' => $validated['status'] ?? 'active',
            ]);
        });

        return redirect()->route('students.index')
            ->with('success', 'Student created successfully with default student account.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Student $student)
    {
        $student->load(['user', 'department', 'registrations.exam', 'registrations.subject', 'seatingArrangements']);

        return view('students.show', compact('student'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Student $student)
    {
        $student->load(['user', 'department']);
        $departments = Department::all();

        return view('students.edit', compact('student', 'departments'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Student $student)
    {
        $validated = $request->validate([
            // Main user information
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $student->user_id],
            'password' => ['nullable', 'string', 'min:6'],

            // Student profile information
            'department_id' => ['nullable', 'exists:departments,id'],
            'student_code' => ['required', 'string', 'max:50', 'unique:students,student_code,' . $student->id],
            'phone' => ['nullable', 'string', 'max:20'],
            'semester' => ['nullable', 'string', 'max:20'],
            'academic_year' => ['nullable', 'string', 'max:20'],
            'status' => ['nullable', 'string', 'in:active,inactive,graduated,suspended'],
        ]);

        DB::transaction(function () use ($student, $validated) {
            // 1. Update user main information
            $userData = [
                'name' => $validated['name'],
                'email' => $validated['email'],
                'role' => 'student',
            ];

            if (!empty($validated['password'])) {
                $userData['password'] = $validated['password'];
            }

            if ($student->user) {
                $student->user->update($userData);
            }

            // 2. Update student profile
            $student->update([
                'department_id' => $validated['department_id'] ?? null,
                'student_code' => $validated['student_code'],
                'phone' => $validated['phone'] ?? null,
                'semester' => $validated['semester'] ?? null,
                'academic_year' => $validated['academic_year'] ?? null,
                'status' => $validated['status'] ?? 'active',
            ]);
        });

        return redirect()->route('students.index')
            ->with('success', 'Student profile updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student)
    {
        DB::transaction(function () use ($student) {
            $user = $student->user;
            $student->delete();
            if ($user) {
                $user->delete();
            }
        });

        return redirect()->route('students.index')
            ->with('success', 'Student and associated user account removed successfully.');
    }
}
