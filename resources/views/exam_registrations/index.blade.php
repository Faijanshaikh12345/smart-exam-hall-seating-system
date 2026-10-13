@extends('layouts.app')

@section('title', 'Exam Registrations')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 font-weight-bold">Exam Registrations</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Exam Registrations</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="card card-outline card-primary shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title"><i class="fas fa-clipboard-check mr-1"></i> Student Registrations</h3>
                <div class="card-tools ml-auto">
                    <a href="{{ route('exam-registrations.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus mr-1"></i> Register Student
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
                            <th>Subject</th>
                            <th>Status</th>
                            <th>Registered On</th>
                            <th style="width: 170px;" class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($registrations as $reg)
                            <tr>
                                <td>{{ $loop->iteration + ($registrations->currentPage() - 1) * $registrations->perPage() }}</td>
                                <td class="font-weight-bold">{{ $reg->exam->name ?? '-' }} ({{ $reg->exam->exam_code ?? '-' }})</td>
                                <td>
                                    {{ $reg->student->user->name ?? $reg->student->student_code ?? '-' }}
                                    <span class="badge badge-light border ml-1">{{ $reg->student->student_code ?? '' }}</span>
                                </td>
                                <td>{{ $reg->subject->name ?? '-' }} ({{ $reg->subject->code ?? '-' }})</td>
                                <td>
                                    @if($reg->status === 'registered')
                                        <span class="badge badge-info">Registered</span>
                                    @elseif($reg->status === 'confirmed')
                                        <span class="badge badge-success">Confirmed</span>
                                    @else
                                        <span class="badge badge-danger">Cancelled</span>
                                    @endif
                                </td>
                                <td>{{ $reg->created_at->format('M d, Y') }}</td>
                                <td class="text-center">
                                    <a href="{{ route('exam-registrations.show', $reg) }}" class="btn btn-info btn-xs mr-1" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('exam-registrations.edit', $reg) }}" class="btn btn-warning btn-xs mr-1" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('exam-registrations.destroy', $reg) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this registration?');">
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
                                <td colspan="7" class="text-center text-muted py-4">
                                    <i class="fas fa-clipboard-list fa-2x mb-2 d-block"></i> No registrations found.
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
    </div>
</section>
@endsection
