@extends('layouts.app')

@section('title', 'My Exams')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 font-weight-bold">My Exams</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">My Exams</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">

        @unless($student)
            <div class="alert alert-warning">
                <i class="fas fa-exclamation-triangle mr-1"></i>
                Your login is not linked to a student profile yet. Please contact the exam office.
            </div>
        @else
            <div class="card card-outline card-primary shadow-sm">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-calendar-alt mr-1"></i> Registered Exams</h3>
                </div>
                <div class="card-body p-0 table-responsive">
                    <table class="table table-hover table-striped mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th style="width: 60px;">#</th>
                                <th>Exam</th>
                                <th>Subject</th>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Status</th>
                                <th>Registered On</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($registrations as $reg)
                                <tr>
                                    <td>{{ $loop->iteration + ($registrations->currentPage() - 1) * $registrations->perPage() }}</td>
                                    <td class="font-weight-bold">
                                        {{ $reg->exam->name ?? '-' }}
                                        <span class="text-muted">({{ $reg->exam->exam_code ?? '-' }})</span>
                                    </td>
                                    <td>{{ $reg->subject->name ?? '-' }} ({{ $reg->subject->code ?? '-' }})</td>
                                    <td>
                                        {{ $reg->exam && $reg->exam->exam_date ? $reg->exam->exam_date->format('M d, Y') : '-' }}
                                    </td>
                                    <td class="text-muted">
                                        {{ $reg->exam->start_time ?? '-' }} – {{ $reg->exam->end_time ?? '-' }}
                                    </td>
                                    <td>
                                        @if($reg->status === 'registered')
                                            <span class="badge badge-info">Registered</span>
                                        @elseif($reg->status === 'confirmed')
                                            <span class="badge badge-success">Confirmed</span>
                                        @else
                                            <span class="badge badge-danger">{{ ucfirst($reg->status) }}</span>
                                        @endif
                                    </td>
                                    <td>{{ $reg->created_at->format('M d, Y') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-4">
                                        <i class="fas fa-calendar-times fa-2x mb-2 d-block"></i>
                                        You are not registered for any exams yet.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($registrations->hasPages())
                    <div class="card-footer clearfix">
                        {{ $registrations->links('pagination::bootstrap-4') }}
                    </div>
                @endif
            </div>
        @endunless

    </div>
</section>
@endsection
