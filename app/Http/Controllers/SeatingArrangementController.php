<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\ExamHall;
use App\Models\HallSeat;
use App\Models\SeatingArrangement;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SeatingArrangementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $arrangements = SeatingArrangement::with([
            'exam',
            'student.user',
            'examHall',
            'hallSeat',
            'subject',
        ])->latest()->paginate(15);

        return view('seating_arrangements.index', compact('arrangements'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $exams = Exam::all();
        $students = Student::with('user')->get();
        $examHalls = ExamHall::all();
        $hallSeats = HallSeat::all();
        $subjects = Subject::all();

        return view('seating_arrangements.create', compact('exams', 'students', 'examHalls', 'hallSeats', 'subjects'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'exam_id' => ['required', 'exists:exams,id'],
            'student_id' => [
                'required',
                'exists:students,id',
                Rule::unique('seating_arrangements')->where(function ($query) use ($request) {
                    return $query->where('exam_id', $request->exam_id);
                }),
            ],
            'exam_hall_id' => ['required', 'exists:exam_halls,id'],
            'hall_seat_id' => [
                'required',
                'exists:hall_seats,id',
                Rule::unique('seating_arrangements')->where(function ($query) use ($request) {
                    return $query->where('exam_id', $request->exam_id);
                }),
            ],
            'subject_id' => ['nullable', 'exists:subjects,id'],
            'assigned_at' => ['nullable', 'date'],
        ]);

        if (empty($validated['assigned_at'])) {
            $validated['assigned_at'] = now();
        }

        SeatingArrangement::create($validated);

        return redirect()->route('seating-arrangements.index')
            ->with('success', 'Seating arrangement assigned successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(SeatingArrangement $seatingArrangement)
    {
        $seatingArrangement->load([
            'exam',
            'student.user',
            'examHall',
            'hallSeat',
            'subject',
            'conflicts',
        ]);

        return view('seating_arrangements.show', compact('seatingArrangement'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SeatingArrangement $seatingArrangement)
    {
        $exams = Exam::all();
        $students = Student::with('user')->get();
        $examHalls = ExamHall::all();
        $hallSeats = HallSeat::where('exam_hall_id', $seatingArrangement->exam_hall_id)->get();
        $subjects = Subject::all();

        return view('seating_arrangements.edit', compact(
            'seatingArrangement',
            'exams',
            'students',
            'examHalls',
            'hallSeats',
            'subjects'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SeatingArrangement $seatingArrangement)
    {
        $validated = $request->validate([
            'exam_id' => ['required', 'exists:exams,id'],
            'student_id' => [
                'required',
                'exists:students,id',
                Rule::unique('seating_arrangements')
                    ->ignore($seatingArrangement->id)
                    ->where(function ($query) use ($request) {
                        return $query->where('exam_id', $request->exam_id);
                    }),
            ],
            'exam_hall_id' => ['required', 'exists:exam_halls,id'],
            'hall_seat_id' => [
                'required',
                'exists:hall_seats,id',
                Rule::unique('seating_arrangements')
                    ->ignore($seatingArrangement->id)
                    ->where(function ($query) use ($request) {
                        return $query->where('exam_id', $request->exam_id);
                    }),
            ],
            'subject_id' => ['nullable', 'exists:subjects,id'],
            'assigned_at' => ['nullable', 'date'],
        ]);

        $seatingArrangement->update($validated);

        return redirect()->route('seating-arrangements.index')
            ->with('success', 'Seating arrangement updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SeatingArrangement $seatingArrangement)
    {
        $seatingArrangement->delete();

        return redirect()->route('seating-arrangements.index')
            ->with('success', 'Seating arrangement removed successfully.');
    }
}
