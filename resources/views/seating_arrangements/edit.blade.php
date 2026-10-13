@extends('layouts.app')

@section('title', 'Edit Seating Arrangement')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 font-weight-bold">Edit Seating Arrangement</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('seating-arrangements.index') }}">Seating Arrangements</a></li>
                    <li class="breadcrumb-item active">Edit</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-9 mx-auto">
                <div class="card card-warning shadow-sm">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-edit mr-1"></i> Edit Assignment #{{ $seatingArrangement->id }}</h3>
                    </div>
                    <form action="{{ route('seating-arrangements.update', $seatingArrangement) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exam_id">Select Examination <span class="text-danger">*</span></label>
                                        <select name="exam_id" id="exam_id" class="form-control @error('exam_id') is-invalid @enderror" required>
                                            @foreach($exams as $exam)
                                                <option value="{{ $exam->id }}" {{ old('exam_id', $seatingArrangement->exam_id) == $exam->id ? 'selected' : '' }}>
                                                    {{ $exam->name }} ({{ $exam->exam_code }})
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('exam_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="student_id">Select Student <span class="text-danger">*</span></label>
                                        <select name="student_id" id="student_id" class="form-control @error('student_id') is-invalid @enderror" required>
                                            @foreach($students as $student)
                                                <option value="{{ $student->id }}" {{ old('student_id', $seatingArrangement->student_id) == $student->id ? 'selected' : '' }}>
                                                    {{ $student->student_code }} - {{ $student->user->name ?? $student->full_name ?? 'Student' }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('student_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exam_hall_id">Exam Hall <span class="text-danger">*</span></label>
                                        <select name="exam_hall_id" id="exam_hall_id" class="form-control @error('exam_hall_id') is-invalid @enderror" required>
                                            @foreach($examHalls as $hall)
                                                <option value="{{ $hall->id }}" {{ old('exam_hall_id', $seatingArrangement->exam_hall_id) == $hall->id ? 'selected' : '' }}>
                                                    {{ $hall->name }} ({{ $hall->hall_code }})
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('exam_hall_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="hall_seat_id">Seat Number <span class="text-danger">*</span></label>
                                        <select name="hall_seat_id" id="hall_seat_id" class="form-control @error('hall_seat_id') is-invalid @enderror" required>
                                            @foreach($hallSeats as $seat)
                                                <option value="{{ $seat->id }}" {{ old('hall_seat_id', $seatingArrangement->hall_seat_id) == $seat->id ? 'selected' : '' }}>
                                                    Seat {{ $seat->seat_number }} (Row {{ $seat->row_number ?: '-' }}, Col {{ $seat->column_number ?: '-' }})
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('hall_seat_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="subject_id">Subject (Optional)</label>
                                        <select name="subject_id" id="subject_id" class="form-control @error('subject_id') is-invalid @enderror">
                                            <option value="">-- None / General --</option>
                                            @foreach($subjects as $subj)
                                                <option value="{{ $subj->id }}" {{ old('subject_id', $seatingArrangement->subject_id) == $subj->id ? 'selected' : '' }}>
                                                    {{ $subj->code }} - {{ $subj->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('subject_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="assigned_at">Assigned Date & Time</label>
                                        <input type="datetime-local" name="assigned_at" id="assigned_at" class="form-control @error('assigned_at') is-invalid @enderror" value="{{ old('assigned_at', $seatingArrangement->assigned_at ? $seatingArrangement->assigned_at->format('Y-m-d\TH:i') : '') }}">
                                        @error('assigned_at')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer d-flex justify-content-between">
                            <a href="{{ route('seating-arrangements.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left mr-1"></i> Cancel
                            </a>
                            <button type="submit" class="btn btn-warning">
                                <i class="fas fa-save mr-1"></i> Update Arrangement
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
