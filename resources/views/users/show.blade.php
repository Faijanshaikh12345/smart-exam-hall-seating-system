@extends('layouts.app')

@section('title', 'User Details')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 font-weight-bold">User Details</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Users</a></li>
                    <li class="breadcrumb-item active">{{ $user->name }}</li>
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
                            <img class="profile-user-img img-fluid img-circle" src="{{ asset('dist/img/man.png') }}" alt="User profile picture">
                        </div>

                        <h3 class="profile-username text-center font-weight-bold">{{ $user->name }}</h3>
                        <p class="text-muted text-center">{{ $user->email }}</p>

                        <div class="text-center mb-3">
                            @if($user->role === 'admin')
                                <span class="badge badge-danger px-3 py-2">Administrator</span>
                            @elseif($user->role === 'staff')
                                <span class="badge badge-info px-3 py-2">Staff Member</span>
                            @else
                                <span class="badge badge-success px-3 py-2">Student</span>
                            @endif
                        </div>

                        <ul class="list-group list-group-unbordered mb-3">
                            <li class="list-group-item">
                                <b>Student Profile</b> 
                                <span class="float-right">
                                    @if($user->student)
                                        <a href="{{ route('students.show', $user->student) }}">{{ $user->student->student_code }}</a>
                                    @else
                                        <span class="text-muted">None</span>
                                    @endif
                                </span>
                            </li>
                            <li class="list-group-item">
                                <b>Staff Profile</b> 
                                <span class="float-right">
                                    @if($user->staff)
                                        <a href="{{ route('staff.show', $user->staff) }}">{{ $user->staff->staff_code }}</a>
                                    @else
                                        <span class="text-muted">None</span>
                                    @endif
                                </span>
                            </li>
                            <li class="list-group-item">
                                <b>Joined</b> <span class="float-right text-muted">{{ $user->created_at->format('M d, Y h:i A') }}</span>
                            </li>
                        </ul>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('users.index') }}" class="btn btn-secondary btn-sm">
                                <i class="fas fa-arrow-left mr-1"></i> Back
                            </a>
                            <a href="{{ route('users.edit', $user) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit mr-1"></i> Edit User
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
