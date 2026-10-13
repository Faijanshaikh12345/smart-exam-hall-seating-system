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
                    <li class="breadcrumb-item active">Seating Arrangements</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="card card-outline card-primary shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title"><i class="fas fa-chair mr-1"></i> Allocated Exam Seats</h3>
                <div class="card-tools ml-auto">
                    <a href="{{ route('seating-arrangements.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus mr-1"></i> Assign Seat
                    </a>
                </div>
            </div>
            <div class="card-body p-0 table-responsive">
                <table class="table table-hover table-striped mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th style="width: 60px;">#</th>
                            <th>Exam</th>
                            <th>Student</th>
                            <th>Hall</th>
                            <th>Seat Number</th>
                            <th>Subject</th>
                            <th>Assigned At</th>
                            <th style="width: 170px;" class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($arrangements as $arrangement)
                            <tr>
                                <td>{{ $loop->iteration + ($arrangements->currentPage() - 1) * $arrangements->perPage() }}</td>
                                <td class="font-weight-bold">{{ $arrangement->exam->name ?? '-' }} ({{ $arrangement->exam->exam_code ?? '-' }})</td>
                                <td>
                                    {{ $arrangement->student->user->name ?? $arrangement->student->student_code ?? '-' }}
                                    <span class="badge badge-light border ml-1">{{ $arrangement->student->student_code ?? '' }}</span>
                                </td>
                                <td>{{ $arrangement->examHall->name ?? '-' }}</td>
                                <td><span class="badge badge-primary font-weight-bold">{{ $arrangement->hallSeat->seat_number ?? '-' }}</span></td>
                                <td>{{ $arrangement->subject->code ?? '-' }}</td>
                                <td>{{ $arrangement->assigned_at ? $arrangement->assigned_at->format('M d, Y h:i A') : '-' }}</td>
                                <td class="text-center">
                                    <a href="{{ route('seating-arrangements.show', $arrangement) }}" class="btn btn-info btn-xs mr-1" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('seating-arrangements.edit', $arrangement) }}" class="btn btn-warning btn-xs mr-1" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('seating-arrangements.destroy', $arrangement) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to remove this seat arrangement?');">
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
                                <td colspan="8" class="text-center text-muted py-4">
                                    <i class="fas fa-chair fa-2x mb-2 d-block"></i> No seating arrangements created yet.
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
    </div>
</section>
@endsection
