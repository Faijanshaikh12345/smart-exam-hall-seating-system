@extends('layouts.app')

@section('title', 'My Seating Arrangement')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 font-weight-bold">My Seating Arrangement</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">My Seating</li>
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
                    <h3 class="card-title"><i class="fas fa-chair mr-1"></i> Your Seat Allocations</h3>
                </div>
                <div class="card-body p-0 table-responsive">
                    <table class="table table-hover table-striped mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th style="width: 60px;">#</th>
                                <th>Exam</th>
                                <th>Hall</th>
                                <th>Seat</th>
                                <th>Subject</th>
                                <th>Exam Date</th>
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
                                        {{ $arrangement->examHall->name ?? '-' }}
                                        @if($arrangement->examHall && ($arrangement->examHall->building || $arrangement->examHall->floor))
                                            <br>
                                            <small class="text-muted">
                                                {{ $arrangement->examHall->building ?? '' }}
                                                @if($arrangement->examHall->floor)
                                                    · Floor {{ $arrangement->examHall->floor }}
                                                @endif
                                            </small>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge badge-primary font-weight-bold px-3">
                                            {{ $arrangement->hallSeat->seat_number ?? '-' }}
                                        </span>
                                    </td>
                                    <td>{{ $arrangement->subject->code ?? ($arrangement->subject->name ?? '-') }}</td>
                                    <td>
                                        {{ $arrangement->exam && $arrangement->exam->exam_date ? $arrangement->exam->exam_date->format('M d, Y') : '-' }}
                                    </td>
                                    <td>{{ $arrangement->assigned_at ? $arrangement->assigned_at->format('M d, Y h:i A') : '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-4">
                                        <i class="fas fa-chair fa-2x mb-2 d-block"></i>
                                        No seat has been assigned to you yet. Check back after seating is published.
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
