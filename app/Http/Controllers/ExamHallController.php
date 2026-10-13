<?php

namespace App\Http\Controllers;

use App\Models\ExamHall;
use Illuminate\Http\Request;

class ExamHallController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $examHalls = ExamHall::withCount('seats')->latest()->paginate(10);

        return view('exam_halls.index', compact('examHalls'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('exam_halls.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'hall_code' => ['required', 'string', 'max:50', 'unique:exam_halls,hall_code'],
            'building' => ['nullable', 'string', 'max:100'],
            'floor' => ['nullable', 'string', 'max:50'],
            'capacity' => ['required', 'integer', 'min:1'],
            'status' => ['nullable', 'string', 'in:available,occupied,maintenance'],
            'description' => ['nullable', 'string'],
        ]);

        ExamHall::create($validated);

        return redirect()->route('exam-halls.index')
            ->with('success', 'Exam hall created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ExamHall $examHall)
    {
        $examHall->load(['seats', 'seatingArrangements.exam']);

        return view('exam_halls.show', compact('examHall'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ExamHall $examHall)
    {
        return view('exam_halls.edit', compact('examHall'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ExamHall $examHall)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'hall_code' => ['required', 'string', 'max:50', 'unique:exam_halls,hall_code,' . $examHall->id],
            'building' => ['nullable', 'string', 'max:100'],
            'floor' => ['nullable', 'string', 'max:50'],
            'capacity' => ['required', 'integer', 'min:1'],
            'status' => ['nullable', 'string', 'in:available,occupied,maintenance'],
            'description' => ['nullable', 'string'],
        ]);

        $examHall->update($validated);

        return redirect()->route('exam-halls.index')
            ->with('success', 'Exam hall updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ExamHall $examHall)
    {
        $examHall->delete();

        return redirect()->route('exam-halls.index')
            ->with('success', 'Exam hall deleted successfully.');
    }
}
