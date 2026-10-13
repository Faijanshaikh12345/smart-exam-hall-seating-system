@extends('layouts.app')

@section('title', 'Conflict Management')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 font-weight-bold">Exam Conflicts</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Conflicts</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="card card-outline card-danger shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title"><i class="fas fa-exclamation-triangle mr-1"></i> Reported Conflicts</h3>
                <div class="card-tools ml-auto">
                    <a href="{{ route('conflicts.create') }}" class="btn btn-danger btn-sm">
                        <i class="fas fa-plus mr-1"></i> Report Conflict
                    </a>
                </div>
            </div>
            <div class="card-body p-0 table-responsive">
                <table class="table table-hover table-striped mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th style="width: 60px;">#</th>
                            <th>Type</th>
                            <th>Exam</th>
                            <th>Student</th>
                            <th>Severity</th>
                            <th>Status</th>
                            <th>Resolved By</th>
                            <th style="width: 170px;" class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($conflicts as $conflict)
                            <tr>
                                <td>{{ $loop->iteration + ($conflicts->currentPage() - 1) * $conflicts->perPage() }}</td>
                                <td class="font-weight-bold text-danger">{{ $conflict->conflict_type }}</td>
                                <td>{{ $conflict->exam->name ?? '-' }}</td>
                                <td>{{ $conflict->student->user->name ?? $conflict->student->student_code ?? '-' }}</td>
                                <td>
                                    @if($conflict->severity === 'critical')
                                        <span class="badge badge-danger">Critical</span>
                                    @elseif($conflict->severity === 'high')
                                        <span class="badge badge-warning">High</span>
                                    @elseif($conflict->severity === 'medium')
                                        <span class="badge badge-info">Medium</span>
                                    @else
                                        <span class="badge badge-secondary">Low</span>
                                    @endif
                                </td>
                                <td>
                                    @if($conflict->status === 'open')
                                        <span class="badge badge-danger">Open</span>
                                    @elseif($conflict->status === 'investigating')
                                        <span class="badge badge-warning">Investigating</span>
                                    @elseif($conflict->status === 'resolved')
                                        <span class="badge badge-success">Resolved</span>
                                    @else
                                        <span class="badge badge-secondary">Dismissed</span>
                                    @endif
                                </td>
                                <td>{{ $conflict->resolvedBy->name ?? '-' }}</td>
                                <td class="text-center">
                                    <a href="{{ route('conflicts.show', $conflict) }}" class="btn btn-info btn-xs mr-1" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('conflicts.edit', $conflict) }}" class="btn btn-warning btn-xs mr-1" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('conflicts.destroy', $conflict) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this conflict?');">
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
                                    <i class="fas fa-check-circle fa-2x mb-2 text-success d-block"></i> No unresolved conflicts found!
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($conflicts->hasPages())
                <div class="card-footer clearfix">
                    {{ $conflicts->links('pagination::bootstrap-4') }}
                </div>
            @endif
        </div>
    </div>
</section>
@endsection
