@extends('layouts.app')

@section('title', 'Subject Details')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 font-weight-bold">Subject Details</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('subjects.index') }}">Subjects</a></li>
                    <li class="breadcrumb-item active">{{ $subject->code }}</li>
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
                            <span class="badge badge-info px-3 py-2 font-size-lg">{{ $subject->code }}</span>
                        </div>

                        <h3 class="profile-username text-center font-weight-bold">{{ $subject->name }}</h3>
                        <p class="text-muted text-center">{{ $subject->department->name ?? 'General Department' }}</p>

                        <ul class="list-group list-group-unbordered mb-3">
                            <li class="list-group-item">
                                <b>Credits</b> <span class="float-right font-weight-bold">{{ $subject->credits }}</span>
                            </li>
                            <li class="list-group-item">
                                <b>Semester</b> <span class="float-right">{{ $subject->semester ?: '-' }}</span>
                            </li>
                            <li class="list-group-item">
                                <b>Exam Registrations</b> <span class="float-right badge badge-primary">{{ $subject->registrations->count() }}</span>
                            </li>
                            <li class="list-group-item">
                                <b>Description</b> <p class="text-muted mb-0 mt-1">{{ $subject->description ?: 'No description provided.' }}</p>
                            </li>
                        </ul>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('subjects.index') }}" class="btn btn-secondary btn-sm">
                                <i class="fas fa-arrow-left mr-1"></i> Back
                            </a>
                            <a href="{{ route('subjects.edit', $subject) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit mr-1"></i> Edit Subject
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
