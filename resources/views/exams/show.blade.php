@extends('layouts.app')

@section('title', 'Exam Details')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 font-weight-bold">Exam Details</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('exams.index') }}">Exams</a></li>
                    <li class="breadcrumb-item active">{{ $exam->exam_code }}</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4">
                <div class="card card-primary card-outline shadow-sm">
                    <div class="card-body box-profile">
                        <div class="text-center mb-3">
                            <span class="badge badge-info px-3 py-2 font-size-lg">{{ $exam->exam_code }}</span>
                        </div>

                        <h3 class="profile-username text-center font-weight-bold">{{ $exam->name }}</h3>
                        <p class="text-muted text-center">{{ $exam->exam_type ?: 'Examination' }}</p>

                        <div class="text-center mb-3">
                            <span class="badge badge-success px-3 py-1">{{ ucfirst($exam->status) }}</span>
                        </div>

                        <ul class="list-group list-group-unbordered mb-3">
                            <li class="list-group-item">
                                <b>Date</b> <span class="float-right font-weight-bold">{{ \Carbon\Carbon::parse($exam->exam_date)->format('M d, Y') }}</span>
                            </li>
                            <li class="list-group-item">
                                <b>Time</b> <span class="float-right text-muted">{{ $exam->start_time }} - {{ $exam->end_time }}</span>
                            </li>
                            <li class="list-group-item">
                                <b>Academic Year</b> <span class="float-right">{{ $exam->academic_year ?: '-' }}</span>
                            </li>
                            <li class="list-group-item">
                                <b>Registrations</b> <span class="float-right badge badge-primary">{{ $exam->registrations->count() }}</span>
                            </li>
                            <li class="list-group-item">
                                <b>Assigned Seats</b> <span class="float-right badge badge-success">{{ $exam->seatingArrangements->count() }}</span>
                            </li>
                        </ul>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('exams.index') }}" class="btn btn-secondary btn-sm">
                                <i class="fas fa-arrow-left mr-1"></i> Back
                            </a>
                            <a href="{{ route('exams.edit', $exam) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit mr-1"></i> Edit Exam
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header p-2">
                        <ul class="nav nav-pills">
                            <li class="nav-item"><a class="nav-link active" href="#registrations" data-toggle="tab">Registered Students ({{ $exam->registrations->count() }})</a></li>
                            <li class="nav-item"><a class="nav-link" href="#seating" data-toggle="tab">Seating Layout ({{ $exam->seatingArrangements->count() }})</a></li>
                        </ul>
                    </div>
                    <div class="card-body p-0">
                        <div class="tab-content">
                            <div class="active tab-pane p-3" id="registrations">
                                <table class="table table-sm table-striped">
                                    <thead>
                                        <tr>
                                            <th>Student Code</th>
                                            <th>Student Name</th>
                                            <th>Subject</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($exam->registrations as $reg)
                                            <tr>
                                                <td><span class="badge badge-secondary">{{ $reg->student->student_code ?? '-' }}</span></td>
                                                <td>{{ $reg->student->user->name ?? $reg->student->full_name ?? '-' }}</td>
                                                <td>{{ $reg->subject->name ?? '-' }} ({{ $reg->subject->code ?? '-' }})</td>
                                                <td><span class="badge badge-info">{{ ucfirst($reg->status) }}</span></td>
                                            </tr>
                                        @empty
                                            <tr><td colspan="4" class="text-center text-muted">No students registered yet.</td></tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <div class="tab-pane p-3" id="seating">
                                <table class="table table-sm table-striped">
                                    <thead>
                                        <tr>
                                            <th>Hall</th>
                                            <th>Seat No.</th>
                                            <th>Student</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($exam->seatingArrangements as $seat)
                                            <tr>
                                                <td>{{ $seat->examHall->name ?? '-' }}</td>
                                                <td><span class="badge badge-primary">{{ $seat->hallSeat->seat_number ?? '-' }}</span></td>
                                                <td>{{ $seat->student->user->name ?? $seat->student->student_code ?? '-' }}</td>
                                            </tr>
                                        @empty
                                            <tr><td colspan="3" class="text-center text-muted">No seating arrangements generated yet.</td></tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
