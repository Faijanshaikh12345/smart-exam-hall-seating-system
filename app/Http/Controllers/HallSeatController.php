<?php

namespace App\Http\Controllers;

use App\Models\ExamHall;
use App\Models\HallSeat;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class HallSeatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $seats = HallSeat::with('examHall')->latest()->paginate(15);

        return view('hall_seats.index', compact('seats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $examHalls = ExamHall::all();

        return view('hall_seats.create', compact('examHalls'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'exam_hall_id' => ['required', 'exists:exam_halls,id'],
            'seat_number' => [
                'required',
                'string',
                'max:50',
                Rule::unique('hall_seats')->where(function ($query) use ($request) {
                    return $query->where('exam_hall_id', $request->exam_hall_id);
                }),
            ],
            'row_number' => ['nullable', 'integer', 'min:1'],
            'column_number' => ['nullable', 'integer', 'min:1'],
            'status' => ['nullable', 'string', 'in:available,occupied,blocked'],
        ]);

        HallSeat::create($validated);

        return redirect()->route('hall-seats.index')
            ->with('success', 'Hall seat created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(HallSeat $hallSeat)
    {
        $hallSeat->load(['examHall', 'seatingArrangements']);

        return view('hall_seats.show', compact('hallSeat'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(HallSeat $hallSeat)
    {
        $examHalls = ExamHall::all();

        return view('hall_seats.edit', compact('hallSeat', 'examHalls'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, HallSeat $hallSeat)
    {
        $validated = $request->validate([
            'exam_hall_id' => ['required', 'exists:exam_halls,id'],
            'seat_number' => [
                'required',
                'string',
                'max:50',
                Rule::unique('hall_seats')
                    ->ignore($hallSeat->id)
                    ->where(function ($query) use ($request) {
                        return $query->where('exam_hall_id', $request->exam_hall_id);
                    }),
            ],
            'row_number' => ['nullable', 'integer', 'min:1'],
            'column_number' => ['nullable', 'integer', 'min:1'],
            'status' => ['nullable', 'string', 'in:available,occupied,blocked'],
        ]);

        $hallSeat->update($validated);

        return redirect()->route('hall-seats.index')
            ->with('success', 'Hall seat updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(HallSeat $hallSeat)
    {
        $hallSeat->delete();

        return redirect()->route('hall-seats.index')
            ->with('success', 'Hall seat deleted successfully.');
    }
}
