@extends('layouts.app')

@section('title', 'Reported Conflicts')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 font-weight-bold">Reported Conflicts</h1>
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

        @if(session('success'))
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                {{ session('success') }}
            </div>
        @endif

        @unless($staff)
            <div class="alert alert-warning">
                <i class="fas fa-exclamation-triangle mr-1"></i>
                Your login is not linked to a staff profile. Please contact the administrator.
            </div>
        @else
            <div class="card card-outline card-danger shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title"><i class="fas fa-exclamation-triangle mr-1"></i> Conflict Reports</h3>
                    <a href="{{ route('staff.conflicts.create') }}" class="btn btn-danger btn-sm">
                        <i class="fas fa-plus mr-1"></i> Report Conflict
                    </a>
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
                                <th>Reported</th>
                                <th style="width: 70px;" class="text-center">View</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($conflicts as $conflict)
                                <tr>
                                    <td>{{ $loop->iteration + ($conflicts->currentPage() - 1) * $conflicts->perPage() }}</td>
                                    <td class="font-weight-bold text-danger">{{ $conflict->conflict_type }}</td>
                                    <td>{{ $conflict->exam->name ?? '—' }}</td>
                                    <td>{{ $conflict->student->user->name ?? $conflict->student->student_code ?? '—' }}</td>
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
                                            <span class="badge badge-secondary">{{ ucfirst($conflict->status) }}</span>
                                        @endif
                                    </td>
                                    <td>{{ $conflict->created_at->format('M d, Y') }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('staff.conflicts.show', $conflict) }}" class="btn btn-info btn-xs">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted py-4">
                                        No conflicts reported yet.
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
        @endunless

    </div>
</section>
@endsection
