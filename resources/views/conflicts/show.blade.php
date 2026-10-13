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
                    <li class="breadcrumb-item"><a href="{{ route('conflicts.index') }}">Conflicts</a></li>
                    <li class="breadcrumb-item active">#{{ $conflict->id }}</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-7 mx-auto">
                <div class="card card-danger card-outline shadow-sm">
                    <div class="card-header">
                        <h3 class="card-title font-weight-bold"><i class="fas fa-exclamation-triangle text-danger mr-1"></i> {{ $conflict->conflict_type }}</h3>
                        <div class="card-tools">
                            @if($conflict->status === 'resolved')
                                <span class="badge badge-success px-2 py-1">Resolved</span>
                            @else
                                <span class="badge badge-danger px-2 py-1">{{ ucfirst($conflict->status) }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-sm-6">
                                <small class="text-muted d-block">Severity</small>
                                <span class="badge badge-warning px-2 py-1">{{ ucfirst($conflict->severity) }}</span>
                            </div>
                            <div class="col-sm-6">
                                <small class="text-muted d-block">Reported Date</small>
                                <strong>{{ $conflict->created_at->format('M d, Y h:i A') }}</strong>
                            </div>
                        </div>

                        <div class="mb-3">
                            <small class="text-muted d-block">Exam Affected</small>
                            <strong>{{ $conflict->exam->name ?? 'None' }} {{ $conflict->exam ? '(' . $conflict->exam->exam_code . ')' : '' }}</strong>
                        </div>

                        <div class="mb-3">
                            <small class="text-muted d-block">Student Affected</small>
                            <strong>{{ $conflict->student->user->name ?? $conflict->student->student_code ?? 'None' }}</strong>
                        </div>

                        <div class="mb-3">
                            <small class="text-muted d-block">Description</small>
                            <div class="p-3 bg-light rounded border">
                                {{ $conflict->description }}
                            </div>
                        </div>

                        @if($conflict->resolution_notes)
                            <div class="mb-3">
                                <small class="text-muted d-block">Resolution Notes</small>
                                <div class="p-3 bg-light rounded border border-success">
                                    {{ $conflict->resolution_notes }}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <small class="text-muted d-block">Resolved By</small>
                                    <strong>{{ $conflict->resolvedBy->name ?? 'Admin' }}</strong>
                                </div>
                                <div class="col-sm-6">
                                    <small class="text-muted d-block">Resolved At</small>
                                    <strong>{{ $conflict->resolved_at ? \Carbon\Carbon::parse($conflict->resolved_at)->format('M d, Y h:i A') : '-' }}</strong>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="card-footer d-flex justify-content-between">
                        <a href="{{ route('conflicts.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left mr-1"></i> Back
                        </a>
                        <a href="{{ route('conflicts.edit', $conflict) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit mr-1"></i> Update / Resolve
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
