@extends('layouts.app')

@section('title', 'Departments')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 font-weight-bold">Departments</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Departments</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="card card-outline card-primary shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title"><i class="fas fa-building mr-1"></i> Department List</h3>
                <div class="card-tools ml-auto">
                    <a href="{{ route('departments.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus mr-1"></i> Add Department
                    </a>
                </div>
            </div>
            <div class="card-body p-0 table-responsive">
                <table class="table table-hover table-striped mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th style="width: 60px;">#</th>
                            <th>Code</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th class="text-center">Students</th>
                            <th class="text-center">Subjects</th>
                            <th style="width: 170px;" class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($departments as $dept)
                            <tr>
                                <td>{{ $loop->iteration + ($departments->currentPage() - 1) * $departments->perPage() }}</td>
                                <td><span class="badge badge-info">{{ $dept->code }}</span></td>
                                <td class="font-weight-bold">{{ $dept->name }}</td>
                                <td>{{ Str::limit($dept->description, 50) ?: '-' }}</td>
                                <td class="text-center"><span class="badge badge-secondary">{{ $dept->students_count }}</span></td>
                                <td class="text-center"><span class="badge badge-secondary">{{ $dept->subjects_count }}</span></td>
                                <td class="text-center">
                                    <a href="{{ route('departments.show', $dept) }}" class="btn btn-info btn-xs mr-1" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('departments.edit', $dept) }}" class="btn btn-warning btn-xs mr-1" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('departments.destroy', $dept) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this department?');">
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
                                    <i class="fas fa-folder-open fa-2x mb-2 d-block"></i> No departments found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($departments->hasPages())
                <div class="card-footer clearfix">
                    {{ $departments->links('pagination::bootstrap-4') }}
                </div>
            @endif
        </div>
    </div>
</section>
@endsection
