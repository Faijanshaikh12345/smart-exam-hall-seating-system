@extends('layouts.app')

@section('title', 'Exam Duty Details')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 font-weight-bold">Exam Duty Details</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('staff.exam-duties') }}">Exam Duties</a></li>
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
                            <span class="badge badge-info px-3 py-2">{{ $exam->exam_code }}</span>
                        </div>
                        <h3 class="profile-username text-center font-weight-bold">{{ $exam->name }}</h3>
                        <p class="text-muted text-center">{{ $exam->exam_type ?: 'Examination' }}</p>
                        <ul class="list-group list-group-unbordered mb-3">
                            <li class="list-group-item">
                                <b>Date</b>
                                <span class="float-right font-weight-bold">{{ $exam->exam_date->format('M d, Y') }}</span>
                            </li>
                            <li class="list-group-item">
                                <b>Time</b>
                                <span class="float-right text-muted">{{ $exam->start_time }} – {{ $exam->end_time }}</span>
                            </li>
                            <li class="list-group-item">
                                <b>Registrations</b>
                                <span class="float-right badge badge-primary">{{ $exam->registrations->count() }}</span>
                            </li>
                            <li class="list-group-item">
                                <b>Seated</b>
                                <span class="float-right badge badge-success">{{ $exam->seatingArrangements->count() }}</span>
                            </li>
                        </ul>
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('staff.exam-duties') }}" class="btn btn-secondary btn-sm">
                                <i class="fas fa-arrow-left mr-1"></i> Back
                            </a>
                            <a href="{{ route('staff.seating', ['exam_id' => $exam->id]) }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-chair mr-1"></i> View Seating
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header p-2">
                        <ul class="nav nav-pills">
                            <li class="nav-item"><a class="nav-link active" href="#registrations" data-toggle="tab">Registered Students</a></li>
                            <li class="nav-item"><a class="nav-link" href="#seating" data-toggle="tab">Seat Allocations</a></li>
                        </ul>
                    </div>
                    <div class="card-body p-0">
                        <div class="tab-content">
                            <div class="active tab-pane p-0" id="registrations">
                                <table class="table table-sm table-striped mb-0">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Student</th>
                                            <th>Subject</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($exam->registrations as $reg)
                                            <tr>
                                                <td>{{ $reg->student->user->name ?? $reg->student->student_code }}</td>
                                                <td>{{ $reg->subject->code ?? '-' }}</td>
                                                <td><span class="badge badge-info">{{ ucfirst($reg->status) }}</span></td>
                                            </tr>
                                        @empty
                                            <tr><td colspan="3" class="text-center text-muted py-3">No registrations.</td></tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <div class="tab-pane p-0" id="seating">
                                <table class="table table-sm table-striped mb-0">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Student</th>
                                            <th>Hall</th>
                                            <th>Seat</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($exam->seatingArrangements as $arr)
                                            <tr>
                                                <td>{{ $arr->student->user->name ?? $arr->student->student_code }}</td>
                                                <td>{{ $arr->examHall->name ?? '-' }}</td>
                                                <td><span class="badge badge-primary">{{ $arr->hallSeat->seat_number ?? '-' }}</span></td>
                                            </tr>
                                        @empty
                                            <tr><td colspan="3" class="text-center text-muted py-3">No seats assigned yet.</td></tr>
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
