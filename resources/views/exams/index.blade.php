@extends('layouts.app')

@section('title', 'Exams Management')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 font-weight-bold">Examinations</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Exams</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="card card-outline card-primary shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title"><i class="fas fa-file-signature mr-1"></i> Scheduled Exams</h3>
                <div class="card-tools ml-auto">
                    <a href="{{ route('exams.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus mr-1"></i> Schedule Exam
                    </a>
                </div>
            </div>
            <div class="card-body p-0 table-responsive">
                <table class="table table-hover table-striped mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th style="width: 60px;">#</th>
                            <th>Code</th>
                            <th>Exam Title</th>
                            <th>Date</th>
                            <th>Timing</th>
                            <th class="text-center">Registrations</th>
                            <th class="text-center">Seated</th>
                            <th>Status</th>
                            <th style="width: 170px;" class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($exams as $exam)
                            <tr>
                                <td>{{ $loop->iteration + ($exams->currentPage() - 1) * $exams->perPage() }}</td>
                                <td><span class="badge badge-info">{{ $exam->exam_code }}</span></td>
                                <td class="font-weight-bold">{{ $exam->name }}</td>
                                <td>{{ \Carbon\Carbon::parse($exam->exam_date)->format('M d, Y') }}</td>
                                <td>{{ $exam->start_time }} - {{ $exam->end_time }}</td>
                                <td class="text-center"><span class="badge badge-secondary">{{ $exam->registrations_count }}</span></td>
                                <td class="text-center"><span class="badge badge-primary">{{ $exam->seating_arrangements_count }}</span></td>
                                <td>
                                    @if($exam->status === 'scheduled')
                                        <span class="badge badge-info">Scheduled</span>
                                    @elseif($exam->status === 'in_progress')
                                        <span class="badge badge-warning">In Progress</span>
                                    @elseif($exam->status === 'completed')
                                        <span class="badge badge-success">Completed</span>
                                    @else
                                        <span class="badge badge-danger">Cancelled</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('exams.show', $exam) }}" class="btn btn-info btn-xs mr-1" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('exams.edit', $exam) }}" class="btn btn-warning btn-xs mr-1" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('exams.destroy', $exam) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this exam?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-xs" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center text-muted py-4">
                                    <i class="fas fa-calendar-times fa-2x mb-2 d-block"></i> No exams scheduled yet.
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
    </div>
</section>
@endsection
