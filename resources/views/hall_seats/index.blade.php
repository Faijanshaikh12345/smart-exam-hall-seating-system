@extends('layouts.app')

@section('title', 'Hall Seats')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 font-weight-bold">Hall Seats</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Hall Seats</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="card card-outline card-primary shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title"><i class="fas fa-chair mr-1"></i> Seat Directory</h3>
                <div class="card-tools ml-auto">
                    <a href="{{ route('hall-seats.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus mr-1"></i> Add Seat
                    </a>
                </div>
            </div>
            <div class="card-body p-0 table-responsive">
                <table class="table table-hover table-striped mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th style="width: 60px;">#</th>
                            <th>Exam Hall</th>
                            <th>Seat Number</th>
                            <th>Row</th>
                            <th>Column</th>
                            <th>Status</th>
                            <th style="width: 170px;" class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($seats as $seat)
                            <tr>
                                <td>{{ $loop->iteration + ($seats->currentPage() - 1) * $seats->perPage() }}</td>
                                <td class="font-weight-bold">{{ $seat->examHall->name ?? '-' }} ({{ $seat->examHall->hall_code ?? '-' }})</td>
                                <td><span class="badge badge-primary font-size-md">{{ $seat->seat_number }}</span></td>
                                <td>{{ $seat->row_number ?: '-' }}</td>
                                <td>{{ $seat->column_number ?: '-' }}</td>
                                <td>
                                    @if($seat->status === 'available')
                                        <span class="badge badge-success">Available</span>
                                    @elseif($seat->status === 'occupied')
                                        <span class="badge badge-warning">Occupied</span>
                                    @else
                                        <span class="badge badge-secondary">Blocked</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('hall-seats.show', $seat) }}" class="btn btn-info btn-xs mr-1" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('hall-seats.edit', $seat) }}" class="btn btn-warning btn-xs mr-1" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('hall-seats.destroy', $seat) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this seat?');">
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
                                    <i class="fas fa-chair fa-2x mb-2 d-block"></i> No hall seats configured yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($seats->hasPages())
                <div class="card-footer clearfix">
                    {{ $seats->links('pagination::bootstrap-4') }}
                </div>
            @endif
        </div>
    </div>
</section>
@endsection
