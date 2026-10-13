@extends('layouts.app')

@section('title', 'Exam Duties')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 font-weight-bold">Exam Duties</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Exam Duties</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">

        @unless($staff)
            <div class="alert alert-warning">
                <i class="fas fa-exclamation-triangle mr-1"></i>
                Your login is not linked to a staff profile. Please contact the administrator.
            </div>
        @else
            <div class="card card-outline card-primary shadow-sm">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-clipboard-list mr-1"></i> Upcoming Exam Sessions</h3>
                </div>
                <div class="card-body p-0 table-responsive">
                    <table class="table table-hover table-striped mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th style="width: 60px;">#</th>
                                <th>Code</th>
                                <th>Exam</th>
                                <th>Date</th>
                                <th>Time</th>
                                <th class="text-center">Students</th>
                                <th class="text-center">Seated</th>
                                <th>Status</th>
                                <th style="width: 80px;" class="text-center">View</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($exams as $exam)
                                <tr>
                                    <td>{{ $loop->iteration + ($exams->currentPage() - 1) * $exams->perPage() }}</td>
                                    <td><span class="badge badge-info">{{ $exam->exam_code }}</span></td>
                                    <td class="font-weight-bold">{{ $exam->name }}</td>
                                    <td>{{ $exam->exam_date->format('M d, Y') }}</td>
                                    <td class="text-muted">{{ $exam->start_time }} – {{ $exam->end_time }}</td>
                                    <td class="text-center"><span class="badge badge-secondary">{{ $exam->registrations_count }}</span></td>
                                    <td class="text-center"><span class="badge badge-primary">{{ $exam->seating_arrangements_count }}</span></td>
                                    <td>
                                        @if($exam->status === 'in_progress')
                                            <span class="badge badge-warning">In Progress</span>
                                        @else
                                            <span class="badge badge-info">Scheduled</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('staff.exam-duties.show', $exam) }}" class="btn btn-info btn-xs" title="Details">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center text-muted py-4">
                                        <i class="fas fa-calendar-check fa-2x mb-2 d-block"></i>
                                        No upcoming exam duties at the moment.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($exams->hasPages())
                    <div class="card-footer clearfix">
                        {{ $exams->links('pagination::bootstrap-4') }}
                    </div>
                @endif
            </div>
        @endunless

    </div>
</section>
@endsection
