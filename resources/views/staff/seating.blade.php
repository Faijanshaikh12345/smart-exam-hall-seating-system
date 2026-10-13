@extends('layouts.app')

@section('title', 'Seating Arrangements')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 font-weight-bold">Seating Arrangements</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Seating</li>
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
                <div class="card-header d-flex flex-wrap align-items-center justify-content-between">
                    <h3 class="card-title mb-2 mb-md-0"><i class="fas fa-chair mr-1"></i> Hall Seat Allocations</h3>
                    <form method="GET" action="{{ route('staff.seating') }}" class="form-inline">
                        <label for="exam_id" class="mr-2 small text-muted">Filter by exam:</label>
                        <select name="exam_id" id="exam_id" class="form-control form-control-sm mr-2" onchange="this.form.submit()">
                            <option value="">All upcoming exams</option>
                            @foreach($exams as $exam)
                                <option value="{{ $exam->id }}" {{ (string) request('exam_id') === (string) $exam->id ? 'selected' : '' }}>
                                    {{ $exam->exam_code }} — {{ $exam->name }}
                                </option>
                            @endforeach
                        </select>
                        @if(request('exam_id'))
                            <a href="{{ route('staff.seating') }}" class="btn btn-outline-secondary btn-sm">Clear</a>
                        @endif
                    </form>
                </div>
                <div class="card-body p-0 table-responsive">
                    <table class="table table-hover table-striped mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th style="width: 60px;">#</th>
                                <th>Exam</th>
                                <th>Student</th>
                                <th>Hall</th>
                                <th>Seat</th>
                                <th>Subject</th>
                                <th>Assigned At</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($arrangements as $arrangement)
                                <tr>
                                    <td>{{ $loop->iteration + ($arrangements->currentPage() - 1) * $arrangements->perPage() }}</td>
                                    <td class="font-weight-bold">
                                        {{ $arrangement->exam->name ?? '-' }}
                                        <span class="text-muted">({{ $arrangement->exam->exam_code ?? '-' }})</span>
                                    </td>
                                    <td>
                                        {{ $arrangement->student->user->name ?? $arrangement->student->student_code ?? '-' }}
                                        <span class="badge badge-light border ml-1">{{ $arrangement->student->student_code ?? '' }}</span>
                                    </td>
                                    <td>{{ $arrangement->examHall->name ?? '-' }}</td>
                                    <td><span class="badge badge-primary font-weight-bold">{{ $arrangement->hallSeat->seat_number ?? '-' }}</span></td>
                                    <td>{{ $arrangement->subject->code ?? '-' }}</td>
                                    <td>{{ $arrangement->assigned_at ? $arrangement->assigned_at->format('M d, Y h:i A') : '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-4">
                                        <i class="fas fa-chair fa-2x mb-2 d-block"></i>
                                        No seating records found for this filter.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($arrangements->hasPages())
                    <div class="card-footer clearfix">
                        {{ $arrangements->links('pagination::bootstrap-4') }}
                    </div>
                @endif
            </div>
        @endunless

    </div>
</section>
@endsection
