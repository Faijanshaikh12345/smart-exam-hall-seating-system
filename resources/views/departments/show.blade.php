@extends('layouts.app')

@section('title', 'Department Details')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 font-weight-bold">Department Details</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('departments.index') }}">Departments</a></li>
                    <li class="breadcrumb-item active">{{ $department->code }}</li>
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
                            <span class="badge badge-primary px-3 py-2 font-size-lg">{{ $department->code }}</span>
                        </div>
                        <h3 class="profile-username text-center font-weight-bold">{{ $department->name }}</h3>
                        <p class="text-muted text-center">{{ $department->description ?: 'No description provided.' }}</p>

                        <ul class="list-group list-group-unbordered mb-3">
                            <li class="list-group-item">
                                <b>Registered Students</b> <a class="float-right">{{ $department->students->count() }}</a>
                            </li>
                            <li class="list-group-item">
                                <b>Associated Subjects</b> <a class="float-right">{{ $department->subjects->count() }}</a>
                            </li>
                            <li class="list-group-item">
                                <b>Created At</b> <span class="float-right text-muted">{{ $department->created_at->format('M d, Y') }}</span>
                            </li>
                        </ul>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('departments.index') }}" class="btn btn-secondary btn-sm">
                                <i class="fas fa-arrow-left mr-1"></i> Back
                            </a>
                            <a href="{{ route('departments.edit', $department) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit mr-1"></i> Edit
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header p-2">
                        <ul class="nav nav-pills">
                            <li class="nav-item"><a class="nav-link active" href="#subjects" data-toggle="tab">Subjects ({{ $department->subjects->count() }})</a></li>
                            <li class="nav-item"><a class="nav-link" href="#students" data-toggle="tab">Students ({{ $department->students->count() }})</a></li>
                        </ul>
                    </div>
                    <div class="card-body p-0">
                        <div class="tab-content">
                            <div class="active tab-pane p-3" id="subjects">
                                <table class="table table-sm table-striped">
                                    <thead>
                                        <tr>
                                            <th>Code</th>
                                            <th>Name</th>
                                            <th>Credits</th>
                                            <th>Semester</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($department->subjects as $subject)
                                            <tr>
                                                <td><span class="badge badge-info">{{ $subject->code }}</span></td>
                                                <td>{{ $subject->name }}</td>
                                                <td>{{ $subject->credits }}</td>
                                                <td>{{ $subject->semester ?: '-' }}</td>
                                            </tr>
                                        @empty
                                            <tr><td colspan="4" class="text-center text-muted">No subjects assigned yet.</td></tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <div class="tab-pane p-3" id="students">
                                <table class="table table-sm table-striped">
                                    <thead>
                                        <tr>
                                            <th>Student Code</th>
                                            <th>User / Name</th>
                                            <th>Semester</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($department->students as $student)
                                            <tr>
                                                <td><span class="badge badge-secondary">{{ $student->student_code }}</span></td>
                                                <td>{{ $student->user->name ?? $student->full_name ?? '-' }}</td>
                                                <td>{{ $student->semester ?: '-' }}</td>
                                                <td><span class="badge badge-success">{{ ucfirst($student->status) }}</span></td>
                                            </tr>
                                        @empty
                                            <tr><td colspan="4" class="text-center text-muted">No students in this department yet.</td></tr>
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
