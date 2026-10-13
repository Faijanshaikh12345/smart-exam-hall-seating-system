@extends('layouts.app')

@section('title', 'Staff Member Details')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 font-weight-bold">Staff Member Profile</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('staff.index') }}">Staff</a></li>
                    <li class="breadcrumb-item active">{{ $staff->staff_code }}</li>
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

                        <h3 class="profile-username text-center font-weight-bold">{{ $staff->user->name ?? 'Staff Member' }}</h3>
                        <p class="text-muted text-center">{{ $staff->designation ?: 'Staff Member' }}</p>

                        @php
                            $statusClass = match($staff->status) {
                                'active' => 'badge-success',
                                'on_leave' => 'badge-warning',
                                'suspended' => 'badge-danger',
                                default => 'badge-secondary',
                            };
                        @endphp

                        <div class="text-center mb-3">
                            <span class="badge badge-info px-3 py-1">{{ $staff->staff_code }}</span>
                            <span class="badge {{ $statusClass }} px-3 py-1 ml-2">{{ ucwords(str_replace('_', ' ', $staff->status)) }}</span>
                        </div>

                        <ul class="list-group list-group-unbordered mb-3">
                            <li class="list-group-item">
                                <b>Email</b> <span class="float-right text-muted">{{ $staff->user->email ?? '-' }}</span>
                            </li>
                            <li class="list-group-item">
                                <b>Phone</b> <span class="float-right text-muted">{{ $staff->phone ?: '-' }}</span>
                            </li>
                            <li class="list-group-item">
                                <b>Designation</b> <span class="float-right">{{ $staff->designation ?: '-' }}</span>
                            </li>
                            <li class="list-group-item">
                                <b>Added Date</b> <span class="float-right text-muted">{{ $staff->created_at->format('M d, Y') }}</span>
                            </li>
                        </ul>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('staff.index') }}" class="btn btn-secondary btn-sm">
                                <i class="fas fa-arrow-left mr-1"></i> Back
                            </a>
                            <a href="{{ route('staff.edit', $staff) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit mr-1"></i> Edit Staff
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection