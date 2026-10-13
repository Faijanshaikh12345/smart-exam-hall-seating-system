@extends('layouts.app')

@section('title', 'Staff Management')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 font-weight-bold">Staff Members</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Staff</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="card card-outline card-primary shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title"><i class="fas fa-user-tie mr-1"></i> Staff Directory</h3>
                <div class="card-tools ml-auto">
                    <a href="{{ route('staff.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus mr-1"></i> Add Staff
                    </a>
                </div>
            </div>
            <div class="card-body p-0 table-responsive">
                <table class="table table-hover table-striped mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th style="width: 60px;">#</th>
                            <th>Staff Code</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Designation</th>
                            <th>Phone</th>
                            <th>Status</th>
                            <th style="width: 170px;" class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($staffMembers as $member)
                            <tr>
                                <td>{{ $loop->iteration + ($staffMembers->currentPage() - 1) * $staffMembers->perPage() }}</td>
                                <td><span class="badge badge-info">{{ $member->staff_code }}</span></td>
                                <td class="font-weight-bold">{{ $member->user->name ?? '-' }}</td>
                                <td>{{ $member->user->email ?? '-' }}</td>
                                <td>{{ $member->designation ?: '-' }}</td>
                                <td>{{ $member->phone ?: '-' }}</td>
                                <td>
                                    @if($member->status === 'active')
                                        <span class="badge badge-success">Active</span>
                                    @elseif($member->status === 'on_leave')
                                        <span class="badge badge-warning">On Leave</span>
                                    @elseif($member->status === 'suspended')
                                        <span class="badge badge-danger">Suspended</span>
                                    @else
                                        <span class="badge badge-secondary">{{ ucfirst($member->status) }}</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('staff.show', $member) }}" class="btn btn-info btn-xs mr-1" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('staff.edit', $member) }}" class="btn btn-warning btn-xs mr-1" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('staff.destroy', $member) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this staff member and their user account?');">
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
                                    <i class="fas fa-user-tie fa-2x mb-2 d-block"></i> No staff members found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($staffMembers->hasPages())
                <div class="card-footer clearfix">
                    {{ $staffMembers->links('pagination::bootstrap-4') }}
                </div>
            @endif
        </div>
    </div>
</section>
@endsection