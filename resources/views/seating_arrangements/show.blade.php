@extends('layouts.app')

@section('title', 'Seating Arrangement Details')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 font-weight-bold">Seating Allocation Details</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('seating-arrangements.index') }}">Seating Arrangements</a></li>
                    <li class="breadcrumb-item active">#{{ $seatingArrangement->id }}</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6 mx-auto">
                <div class="card card-primary card-outline shadow-sm">
                    <div class="card-body box-profile">
                        <div class="text-center mb-3">
                            <span class="badge badge-primary px-4 py-2 font-size-lg">Seat {{ $seatingArrangement->hallSeat->seat_number ?? '-' }}</span>
                        </div>

                        <h3 class="profile-username text-center font-weight-bold">{{ $seatingArrangement->student->user->name ?? $seatingArrangement->student->student_code ?? 'Student' }}</h3>
                        <p class="text-muted text-center">{{ $seatingArrangement->exam->name ?? '-' }} ({{ $seatingArrangement->exam->exam_code ?? '' }})</p>

                        <ul class="list-group list-group-unbordered mb-3">
                            <li class="list-group-item">
                                <b>Student Code</b> <span class="float-right font-weight-bold">{{ $seatingArrangement->student->student_code ?? '-' }}</span>
                            </li>
                            <li class="list-group-item">
                                <b>Exam Hall</b> <span class="float-right font-weight-bold text-primary">{{ $seatingArrangement->examHall->name ?? '-' }} ({{ $seatingArrangement->examHall->hall_code ?? '' }})</span>
                            </li>
                            <li class="list-group-item">
                                <b>Hall Location</b> <span class="float-right text-muted">{{ $seatingArrangement->examHall->building ?? '-' }} - Floor: {{ $seatingArrangement->examHall->floor ?? '-' }}</span>
                            </li>
                            <li class="list-group-item">
                                <b>Subject</b> <span class="float-right">{{ $seatingArrangement->subject ? $seatingArrangement->subject->name . ' (' . $seatingArrangement->subject->code . ')' : 'General' }}</span>
                            </li>
                            <li class="list-group-item">
                                <b>Assigned Timestamp</b> <span class="float-right text-muted">{{ $seatingArrangement->assigned_at ? $seatingArrangement->assigned_at->format('M d, Y h:i A') : '-' }}</span>
                            </li>
                        </ul>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('seating-arrangements.index') }}" class="btn btn-secondary btn-sm">
                                <i class="fas fa-arrow-left mr-1"></i> Back
                            </a>
                            <a href="{{ route('seating-arrangements.edit', $seatingArrangement) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit mr-1"></i> Edit Allocation
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
