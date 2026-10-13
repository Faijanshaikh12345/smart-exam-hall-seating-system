@extends('layouts.app')

@section('title', 'Exam Registration Details')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 font-weight-bold">Registration Details</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('exam-registrations.index') }}">Registrations</a></li>
                    <li class="breadcrumb-item active">#{{ $examRegistration->id }}</li>
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
                            <span class="badge badge-info px-3 py-1 font-size-lg">Registration #{{ $examRegistration->id }}</span>
                        </div>

                        <h3 class="profile-username text-center font-weight-bold">{{ $examRegistration->student->user->name ?? $examRegistration->student->student_code ?? 'Student' }}</h3>
                        <p class="text-muted text-center">{{ $examRegistration->exam->name ?? '-' }}</p>

                        <ul class="list-group list-group-unbordered mb-3">
                            <li class="list-group-item">
                                <b>Student ID</b> <span class="float-right font-weight-bold">{{ $examRegistration->student->student_code ?? '-' }}</span>
                            </li>
                            <li class="list-group-item">
                                <b>Subject</b> <span class="float-right">{{ $examRegistration->subject->name ?? '-' }} ({{ $examRegistration->subject->code ?? '-' }})</span>
                            </li>
                            <li class="list-group-item">
                                <b>Exam Date</b> <span class="float-right font-weight-bold">{{ $examRegistration->exam->exam_date ? \Carbon\Carbon::parse($examRegistration->exam->exam_date)->format('M d, Y') : '-' }}</span>
                            </li>
                            <li class="list-group-item">
                                <b>Timing</b> <span class="float-right text-muted">{{ $examRegistration->exam->start_time ?? '-' }} - {{ $examRegistration->exam->end_time ?? '-' }}</span>
                            </li>
                            <li class="list-group-item">
                                <b>Status</b> <span class="float-right badge badge-success">{{ ucfirst($examRegistration->status) }}</span>
                            </li>
                            <li class="list-group-item">
                                <b>Registered Date</b> <span class="float-right text-muted">{{ $examRegistration->created_at->format('M d, Y h:i A') }}</span>
                            </li>
                        </ul>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('exam-registrations.index') }}" class="btn btn-secondary btn-sm">
                                <i class="fas fa-arrow-left mr-1"></i> Back
                            </a>
                            <a href="{{ route('exam-registrations.edit', $examRegistration) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit mr-1"></i> Edit Registration
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
