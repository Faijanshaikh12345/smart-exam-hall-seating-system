@extends('layouts.app')

@section('title', 'Exam Halls')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 font-weight-bold">Exam Halls</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Exam Halls</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="card card-outline card-primary shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title"><i class="fas fa-building mr-1"></i> Exam Venues & Halls</h3>
                <div class="card-tools ml-auto">
                    <a href="{{ route('exam-halls.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus mr-1"></i> Add Hall
                    </a>
                </div>
            </div>
            <div class="card-body p-0 table-responsive">
                <table class="table table-hover table-striped mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th style="width: 60px;">#</th>
                            <th>Hall Code</th>
                            <th>Hall Name</th>
                            <th>Building</th>
                            <th>Floor</th>
                            <th class="text-center">Capacity</th>
                            <th class="text-center">Generated Seats</th>
                            <th>Status</th>
                            <th style="width: 170px;" class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($examHalls as $hall)
                            <tr>
                                <td>{{ $loop->iteration + ($examHalls->currentPage() - 1) * $examHalls->perPage() }}</td>
                                <td><span class="badge badge-info">{{ $hall->hall_code }}</span></td>
                                <td class="font-weight-bold">{{ $hall->name }}</td>
                                <td>{{ $hall->building ?: '-' }}</td>
                                <td>{{ $hall->floor ?: '-' }}</td>
                                <td class="text-center font-weight-bold">{{ $hall->capacity }}</td>
                                <td class="text-center"><span class="badge badge-secondary">{{ $hall->seats_count }}</span></td>
                                <td>
                                    @if($hall->status === 'available')
                                        <span class="badge badge-success">Available</span>
                                    @elseif($hall->status === 'occupied')
                                        <span class="badge badge-warning">Occupied</span>
                                    @else
                                        <span class="badge badge-danger">Maintenance</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('exam-halls.show', $hall) }}" class="btn btn-info btn-xs mr-1" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('exam-halls.edit', $hall) }}" class="btn btn-warning btn-xs mr-1" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('exam-halls.destroy', $hall) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this hall?');">
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
                                    <i class="fas fa-door-closed fa-2x mb-2 d-block"></i> No exam halls found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($examHalls->hasPages())
                <div class="card-footer clearfix">
                    {{ $examHalls->links('pagination::bootstrap-4') }}
                </div>
            @endif
        </div>
    </div>
</section>
@endsection
