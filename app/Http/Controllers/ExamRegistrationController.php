<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\ExamRegistration;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ExamRegistrationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $registrations = ExamRegistration::with(['exam', 'student.user', 'subject'])
            ->latest()
            ->paginate(10);

        return view('exam_registrations.index', compact('registrations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $exams = Exam::all();
        $students = Student::with('user')->get();
        $subjects = Subject::all();

        return view('exam_registrations.create', compact('exams', 'students', 'subjects'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'exam_id' => ['required', 'exists:exams,id'],
            'student_id' => ['required', 'exists:students,id'],
            'subject_id' => [
                'required',
                'exists:subjects,id',
                Rule::unique('exam_registrations')->where(function ($query) use ($request) {
                    return $query->where('exam_id', $request->exam_id)
                        ->where('student_id', $request->student_id);
                }),
            ],
            'status' => ['nullable', 'string', 'in:registered,confirmed,cancelled'],
        ]);

        ExamRegistration::create($validated);

        return redirect()->route('exam-registrations.index')
            ->with('success', 'Exam registration created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ExamRegistration $examRegistration)
    {
        $examRegistration->load(['exam', 'student.user', 'subject']);

        return view('exam_registrations.show', compact('examRegistration'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ExamRegistration $examRegistration)
    {
        $exams = Exam::all();
        $students = Student::with('user')->get();
        $subjects = Subject::all();

        return view('exam_registrations.edit', compact('examRegistration', 'exams', 'students', 'subjects'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ExamRegistration $examRegistration)
    {
        $validated = $request->validate([
            'exam_id' => ['required', 'exists:exams,id'],
            'student_id' => ['required', 'exists:students,id'],
            'subject_id' => [
                'required',
                'exists:subjects,id',
                Rule::unique('exam_registrations')
                    ->ignore($examRegistration->id)
                    ->where(function ($query) use ($request) {
                        return $query->where('exam_id', $request->exam_id)
                            ->where('student_id', $request->student_id);
                    }),
            ],
            'status' => ['nullable', 'string', 'in:registered,confirmed,cancelled'],
        ]);

        $examRegistration->update($validated);

        return redirect()->route('exam-registrations.index')
            ->with('success', 'Exam registration updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ExamRegistration $examRegistration)
    {
        $examRegistration->delete();

        return redirect()->route('exam-registrations.index')
            ->with('success', 'Exam registration deleted successfully.');
    }
}
