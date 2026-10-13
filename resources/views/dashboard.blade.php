
@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Dashboard</h1>
                <p class="text-muted mb-0">
                    Welcome, {{ Auth::user()->name }}!
                </p>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">Home</li>
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">

        @if(Auth::user()->role === 'admin')

            <div class="row">

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ $totalStudents ?? 0 }}</h3>
                            <p>Total Students</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-user-graduate"></i>
                        </div>
                        <a href="{{ route('students.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ $totalExams ?? 0 }}</h3>
                            <p>Total Exams</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-file-alt"></i>
                        </div>
                        <a href="{{ route('exams.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ $totalHalls ?? 0 }}</h3>
                            <p>Exam Halls</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-building"></i>
                        </div>
                        <a href="{{ route('exam-halls.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>{{ $openConflicts ?? 0 }}</h3>
                            <p>Open Conflicts</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                        <a href="{{ route('conflicts.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

            </div>

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">System Overview</h3>
                </div>
                <div class="card-body">
                    Welcome to the Smart Exam Seating System.
                    Manage academics, exams, halls, seating arrangements,
                    conflicts, and reports from the sidebar.
                </div>
            </div>

        @elseif(Auth::user()->role === 'staff')

            @unless($staff ?? null)
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle mr-1"></i>
                    Your account is not linked to a staff record. Contact the administrator to access exam duties.
                </div>
            @else
                <div class="row">
                    <div class="col-lg-4 col-6">
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{ $upcomingDutiesCount ?? 0 }}</h3>
                                <p>Upcoming Exam Duties</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-clipboard-list"></i>
                            </div>
                            <a href="{{ route('staff.exam-duties') }}" class="small-box-footer">View schedule <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>

                    <div class="col-lg-4 col-6">
                        <div class="small-box bg-primary">
                            <div class="inner">
                                <h3>{{ $seatingAllocationsCount ?? 0 }}</h3>
                                <p>Seat Allocations (upcoming)</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-chair"></i>
                            </div>
                            <a href="{{ route('staff.seating') }}" class="small-box-footer">View seating <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>

                    <div class="col-lg-4 col-6">
                        <div class="small-box bg-danger">
                            <div class="inner">
                                <h3>{{ $openConflictsCount ?? 0 }}</h3>
                                <p>Open Conflicts</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-exclamation-triangle"></i>
                            </div>
                            <a href="{{ route('staff.conflicts.index') }}" class="small-box-footer">View / report <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                </div>

                <div class="card card-outline card-primary shadow-sm">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="card-title mb-0"><i class="fas fa-calendar-alt mr-1"></i> Next Exam Sessions</h3>
                        <a href="{{ route('staff.profile') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="fas fa-user mr-1"></i> My Profile
                        </a>
                    </div>
                    <div class="card-body p-0 table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th>Exam</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Status</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($upcomingExams ?? [] as $exam)
                                    <tr>
                                        <td class="font-weight-bold">{{ $exam->name }} <span class="text-muted">({{ $exam->exam_code }})</span></td>
                                        <td>{{ $exam->exam_date->format('M d, Y') }}</td>
                                        <td class="text-muted">{{ $exam->start_time }} – {{ $exam->end_time }}</td>
                                        <td><span class="badge badge-info">{{ ucfirst(str_replace('_', ' ', $exam->status)) }}</span></td>
                                        <td class="text-right">
                                            <a href="{{ route('staff.exam-duties.show', $exam) }}" class="btn btn-xs btn-outline-primary">Details</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted py-3">No upcoming exams scheduled.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            @endunless

        @elseif(Auth::user()->role === 'student')

            @unless($student ?? null)
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle mr-1"></i>
                    Your account is not linked to a student record. Contact the exam office to access your exams and seating.
                </div>
            @else
                <div class="row">
                    <div class="col-lg-4 col-6">
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{ $registeredExamsCount ?? 0 }}</h3>
                                <p>Registered Exams</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-clipboard-check"></i>
                            </div>
                            <a href="{{ route('student.exams') }}" class="small-box-footer">View all <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>

                    <div class="col-lg-4 col-6">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ $upcomingExamsCount ?? 0 }}</h3>
                                <p>Upcoming Exams</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-calendar-alt"></i>
                            </div>
                            <a href="{{ route('student.exams') }}" class="small-box-footer">View schedule <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>

                    <div class="col-lg-4 col-6">
                        <div class="small-box bg-primary">
                            <div class="inner">
                                <h3>{{ $seatingCount ?? 0 }}</h3>
                                <p>Seat Assignments</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-chair"></i>
                            </div>
                            <a href="{{ route('student.seating') }}" class="small-box-footer">View seating <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                </div>

                <div class="card card-outline card-primary shadow-sm">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="card-title mb-0"><i class="fas fa-history mr-1"></i> Recent Exam Registrations</h3>
                        <a href="{{ route('student.profile') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="fas fa-user mr-1"></i> My Profile
                        </a>
                    </div>
                    <div class="card-body p-0 table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th>Exam</th>
                                    <th>Subject</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentRegistrations ?? [] as $reg)
                                    <tr>
                                        <td class="font-weight-bold">{{ $reg->exam->name ?? '-' }}</td>
                                        <td>{{ $reg->subject->code ?? '-' }}</td>
                                        <td>{{ $reg->exam && $reg->exam->exam_date ? $reg->exam->exam_date->format('M d, Y') : '-' }}</td>
                                        <td><span class="badge badge-info">{{ ucfirst($reg->status) }}</span></td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted py-3">No registrations yet.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            @endunless

        @endif

    </div>
</section>

@endsection
