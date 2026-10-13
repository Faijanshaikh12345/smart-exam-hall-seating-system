@extends('layouts.app')

@section('title', 'Edit Hall Seat')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 font-weight-bold">Edit Hall Seat</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('hall-seats.index') }}">Hall Seats</a></li>
                    <li class="breadcrumb-item active">Edit</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="card card-warning shadow-sm">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-edit mr-1"></i> Edit Seat: {{ $hallSeat->seat_number }}</h3>
                    </div>
                    <form action="{{ route('hall-seats.update', $hallSeat) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="form-group">
                                <label for="exam_hall_id">Exam Hall <span class="text-danger">*</span></label>
                                <select name="exam_hall_id" id="exam_hall_id" class="form-control @error('exam_hall_id') is-invalid @enderror" required>
                                    @foreach($examHalls as $hall)
                                        <option value="{{ $hall->id }}" {{ old('exam_hall_id', $hallSeat->exam_hall_id) == $hall->id ? 'selected' : '' }}>
                                            {{ $hall->name }} ({{ $hall->hall_code }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('exam_hall_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="seat_number">Seat Number / Code <span class="text-danger">*</span></label>
                                <input type="text" name="seat_number" id="seat_number" class="form-control @error('seat_number') is-invalid @enderror" value="{{ old('seat_number', $hallSeat->seat_number) }}" required>
                                @error('seat_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="row_number">Row Number</label>
                                        <input type="number" min="1" name="row_number" id="row_number" class="form-control @error('row_number') is-invalid @enderror" value="{{ old('row_number', $hallSeat->row_number) }}">
                                        @error('row_number')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="column_number">Column Number</label>
                                        <input type="number" min="1" name="column_number" id="column_number" class="form-control @error('column_number') is-invalid @enderror" value="{{ old('column_number', $hallSeat->column_number) }}">
                                        @error('column_number')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="status">Seat Status</label>
                                        <select name="status" id="status" class="form-control @error('status') is-invalid @enderror">
                                            <option value="available" {{ old('status', $hallSeat->status) === 'available' ? 'selected' : '' }}>Available</option>
                                            <option value="occupied" {{ old('status', $hallSeat->status) === 'occupied' ? 'selected' : '' }}>Occupied</option>
                                            <option value="blocked" {{ old('status', $hallSeat->status) === 'blocked' ? 'selected' : '' }}>Blocked</option>
                                        </select>
                                        @error('status')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer d-flex justify-content-between">
                            <a href="{{ route('hall-seats.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left mr-1"></i> Cancel
                            </a>
                            <button type="submit" class="btn btn-warning">
                                <i class="fas fa-save mr-1"></i> Update Seat
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
