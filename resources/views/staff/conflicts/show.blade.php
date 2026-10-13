@extends('layouts.app')

@section('title', 'Conflict Details')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 font-weight-bold">Conflict Details</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('staff.conflicts.index') }}">Conflicts</a></li>
                    <li class="breadcrumb-item active">#{{ $conflict->id }}</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="card card-danger card-outline shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <h4 class="text-danger font-weight-bold mb-0">{{ $conflict->conflict_type }}</h4>
                            @if($conflict->status === 'open')
                                <span class="badge badge-danger">Open</span>
                            @elseif($conflict->status === 'investigating')
                                <span class="badge badge-warning">Investigating</span>
                            @elseif($conflict->status === 'resolved')
                                <span class="badge badge-success">Resolved</span>
                            @else
                                <span class="badge badge-secondary">{{ ucfirst($conflict->status) }}</span>
                            @endif
                        </div>

                        <p class="text-muted mb-4">{{ $conflict->description }}</p>

                        <ul class="list-group list-group-unbordered mb-3">
                            <li class="list-group-item">
                                <b>Exam</b> <span class="float-right">{{ $conflict->exam->name ?? '—' }}</span>
                            </li>
                            <li class="list-group-item">
                                <b>Student</b>
                                <span class="float-right">{{ $conflict->student->user->name ?? $conflict->student->student_code ?? '—' }}</span>
                            </li>
                            <li class="list-group-item">
                                <b>Severity</b> <span class="float-right">{{ ucfirst($conflict->severity) }}</span>
                            </li>
                            @if($conflict->seatingArrangement)
                                <li class="list-group-item">
                                    <b>Seat</b>
                                    <span class="float-right">
                                        {{ $conflict->seatingArrangement->examHall->name ?? '' }}
                                        #{{ $conflict->seatingArrangement->hallSeat->seat_number ?? '?' }}
                                    </span>
                                </li>
                            @endif
                            <li class="list-group-item">
                                <b>Reported</b> <span class="float-right">{{ $conflict->created_at->format('M d, Y h:i A') }}</span>
                            </li>
                            @if($conflict->status === 'resolved')
                                <li class="list-group-item">
                                    <b>Resolved By</b> <span class="float-right">{{ $conflict->resolvedBy->name ?? '—' }}</span>
                                </li>
                                <li class="list-group-item">
                                    <b>Resolution Notes</b>
                                    <p class="mb-0 mt-2 text-muted">{{ $conflict->resolution_notes ?: '—' }}</p>
                                </li>
                            @endif
                        </ul>

                        <a href="{{ route('staff.conflicts.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left mr-1"></i> Back to list
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
