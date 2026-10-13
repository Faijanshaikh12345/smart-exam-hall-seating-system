@extends('layouts.app')

@section('title', 'Student Details')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 font-weight-bold">Student Profile</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('students.index') }}">Students</a></li>
                    <li class="breadcrumb-item active">{{ $student->student_code }}</li>
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
                            <img class="profile-user-img img-fluid img-circle" src="{{ asset('dist/img/man.png') }}" alt="User profile picture">
                        </div>

                        <h3 class="profile-username text-center font-weight-bold">{{ $student->user->name ?? $student->full_name ?? 'Student' }}</h3>
                        <p class="text-muted text-center">{{ $student->student_code }}</p>

                        <div class="text-center mb-3">
                            <span class="badge badge-success px-3 py-1">{{ ucfirst($student->status) }}</span>
                        </div>

                        <ul class="list-group list-group-unbordered mb-3">
                            <li class="list-group-item">
                                <b>Email</b> <span class="float-right text-muted">{{ $student->user->email ?? $student->email ?? '-' }}</span>
                            </li>
                            <li class="list-group-item">
                                <b>Phone</b> <span class="float-right text-muted">{{ $student->phone ?: '-' }}</span>
                            </li>
                            <li class="list-group-item">
                                <b>Department</b> <span class="float-right font-weight-bold">{{ $student->department->name ?? '-' }}</span>
                            </li>
                            <li class="list-group-item">
                                <b>Semester</b> <span class="float-right">{{ $student->semester ?: '-' }}</span>
                            </li>
                            <li class="list-group-item">
                                <b>Academic Year</b> <span class="float-right">{{ $student->academic_year ?: '-' }}</span>
                            </li>
                        </ul>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('students.index') }}" class="btn btn-secondary btn-sm">
                                <i class="fas fa-arrow-left mr-1"></i> Back
                            </a>
                            <a href="{{ route('students.edit', $student) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit mr-1"></i> Edit Profile
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header p-2">
                        <ul class="nav nav-pills">
                            <li class="nav-item"><a class="nav-link active" href="#registrations" data-toggle="tab">Registered Exams ({{ $student->registrations->count() }})</a></li>
                            <li class="nav-item"><a class="nav-link" href="#seating" data-toggle="tab">Seating Allocations ({{ $student->seatingArrangements->count() }})</a></li>
                        </ul>
                    </div>
                    <div class="card-body p-0">
                        <div class="tab-content">
                            <div class="active tab-pane p-3" id="registrations">
                                <table class="table table-sm table-striped">
                                    <thead>
                                        <tr>
                                            <th>Exam</th>
                                            <th>Subject</th>
                                            <th>Date</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($student->registrations as $reg)
                                            <tr>
                                                <td class="font-weight-bold">{{ $reg->exam->name ?? '-' }}</td>
                                                <td>{{ $reg->subject->name ?? '-' }} ({{ $reg->subject->code ?? '-' }})</td>
                                                <td>{{ $reg->exam->exam_date ? \Carbon\Carbon::parse($reg->exam->exam_date)->format('M d, Y') : '-' }}</td>
                                                <td><span class="badge badge-info">{{ ucfirst($reg->status) }}</span></td>
                                            </tr>
                                        @empty
                                            <tr><td colspan="4" class="text-center text-muted">No exams registered.</td></tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <div class="tab-pane p-3" id="seating">
                                <table class="table table-sm table-striped">
                                    <thead>
                                        <tr>
                                            <th>Exam</th>
                                            <th>Hall</th>
                                            <th>Seat No.</th>
                                            <th>Assigned Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($student->seatingArrangements as $seat)
                                            <tr>
                                                <td>{{ $seat->exam->name ?? '-' }}</td>
                                                <td>{{ $seat->examHall->name ?? '-' }}</td>
                                                <td><span class="badge badge-primary">{{ $seat->hallSeat->seat_number ?? '-' }}</span></td>
                                                <td>{{ $seat->assigned_at ? $seat->assigned_at->format('M d, Y h:i A') : '-' }}</td>
                                            </tr>
                                        @empty
                                            <tr><td colspan="4" class="text-center text-muted">No seating arrangements assigned.</td></tr>
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
