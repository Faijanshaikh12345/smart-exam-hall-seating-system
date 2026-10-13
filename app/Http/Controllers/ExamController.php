<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $exams = Exam::withCount(['registrations', 'seatingArrangements', 'conflicts'])
            ->latest('exam_date')
            ->paginate(10);

        return view('exams.index', compact('exams'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('exams.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'exam_code' => ['required', 'string', 'max:50', 'unique:exams,exam_code'],
            'exam_date' => ['required', 'date'],
            'start_time' => ['required'],
            'end_time' => ['required', 'after:start_time'],
            'exam_type' => ['nullable', 'string', 'max:50'],
            'academic_year' => ['nullable', 'string', 'max:20'],
            'status' => ['nullable', 'string', 'in:scheduled,in_progress,completed,cancelled'],
            'description' => ['nullable', 'string'],
        ]);

        Exam::create($validated);

        return redirect()->route('exams.index')
            ->with('success', 'Exam scheduled successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Exam $exam)
    {
        $exam->load([
            'registrations.student.user',
            'registrations.subject',
            'seatingArrangements.examHall',
            'seatingArrangements.hallSeat',
            'conflicts',
        ]);

        return view('exams.show', compact('exam'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Exam $exam)
    {
        return view('exams.edit', compact('exam'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Exam $exam)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'exam_code' => ['required', 'string', 'max:50', 'unique:exams,exam_code,' . $exam->id],
            'exam_date' => ['required', 'date'],
            'start_time' => ['required'],
            'end_time' => ['required', 'after:start_time'],
            'exam_type' => ['nullable', 'string', 'max:50'],
            'academic_year' => ['nullable', 'string', 'max:20'],
            'status' => ['nullable', 'string', 'in:scheduled,in_progress,completed,cancelled'],
            'description' => ['nullable', 'string'],
        ]);

        $exam->update($validated);

        return redirect()->route('exams.index')
            ->with('success', 'Exam updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Exam $exam)
    {
        $exam->delete();

        return redirect()->route('exams.index')
            ->with('success', 'Exam deleted successfully.');
    }
}
