@extends('layouts.app')

@section('title', 'My Profile')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 font-weight-bold">My Profile</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">My Profile</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6 mx-auto">

                @unless($student)
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle mr-1"></i>
                        Your login is not linked to a student profile yet. Please contact the exam office.
                    </div>
                @else
                    <div class="card card-primary card-outline shadow-sm">
                        <div class="card-body box-profile">
                            <div class="text-center mb-3">
                                <img class="profile-user-img img-fluid img-circle" src="{{ asset('dist/img/man.png') }}" alt="Profile">
                            </div>

                            <h3 class="profile-username text-center font-weight-bold">{{ $student->user->name ?? 'Student' }}</h3>
                            <p class="text-muted text-center">{{ $student->student_code }}</p>

                            <div class="text-center mb-3">
                                <span class="badge badge-success px-3 py-1">{{ ucfirst($student->status) }}</span>
                            </div>

                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">
                                    <b>Email</b>
                                    <span class="float-right text-muted">{{ $student->user->email ?? '-' }}</span>
                                </li>
                                <li class="list-group-item">
                                    <b>Phone</b>
                                    <span class="float-right text-muted">{{ $student->phone ?: '-' }}</span>
                                </li>
                                <li class="list-group-item">
                                    <b>Department</b>
                                    <span class="float-right font-weight-bold">{{ $student->department->name ?? '-' }}</span>
                                </li>
                                <li class="list-group-item">
                                    <b>Semester</b>
                                    <span class="float-right">{{ $student->semester ?: '-' }}</span>
                                </li>
                                <li class="list-group-item">
                                    <b>Academic Year</b>
                                    <span class="float-right">{{ $student->academic_year ?: '-' }}</span>
                                </li>
                            </ul>

                            <div class="d-flex justify-content-between">
                                <a href="{{ route('dashboard') }}" class="btn btn-secondary btn-sm">
                                    <i class="fas fa-arrow-left mr-1"></i> Dashboard
                                </a>
                                <a href="{{ route('student.exams') }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-calendar-alt mr-1"></i> My Exams
                                </a>
                            </div>
                        </div>
                    </div>
                @endunless

            </div>
        </div>
    </div>
</section>
@endsection
