@extends('layouts.app')

@section('title', 'Exam Hall Details')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 font-weight-bold">Exam Hall Details</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('exam-halls.index') }}">Halls</a></li>
                    <li class="breadcrumb-item active">{{ $examHall->hall_code }}</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4">
                <div class="card card-primary card-outline shadow-sm">
                    <div class="card-body box-profile">
                        <div class="text-center mb-3">
                            <span class="badge badge-info px-3 py-2 font-size-lg">{{ $examHall->hall_code }}</span>
                        </div>

                        <h3 class="profile-username text-center font-weight-bold">{{ $examHall->name }}</h3>
                        <p class="text-muted text-center">{{ $examHall->building ?: 'Main Building' }} {{ $examHall->floor ? '(' . $examHall->floor . ')' : '' }}</p>

                        <div class="text-center mb-3">
                            <span class="badge badge-success px-3 py-1">{{ ucfirst($examHall->status) }}</span>
                        </div>

                        <ul class="list-group list-group-unbordered mb-3">
                            <li class="list-group-item">
                                <b>Max Capacity</b> <span class="float-right font-weight-bold">{{ $examHall->capacity }}</span>
                            </li>
                            <li class="list-group-item">
                                <b>Total Generated Seats</b> <span class="float-right badge badge-primary">{{ $examHall->seats->count() }}</span>
                            </li>
                            <li class="list-group-item">
                                <b>Description</b> <p class="text-muted mb-0 mt-1">{{ $examHall->description ?: 'No notes available.' }}</p>
                            </li>
                        </ul>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('exam-halls.index') }}" class="btn btn-secondary btn-sm">
                                <i class="fas fa-arrow-left mr-1"></i> Back
                            </a>
                            <a href="{{ route('exam-halls.edit', $examHall) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit mr-1"></i> Edit Hall
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="card-title"><i class="fas fa-chair mr-1"></i> Hall Seats ({{ $examHall->seats->count() }})</h3>
                        <div class="card-tools ml-auto">
                            <a href="{{ route('hall-seats.create') }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-plus mr-1"></i> Add Seat
                            </a>
                        </div>
                    </div>
                    <div class="card-body p-0 table-responsive" style="max-height: 450px;">
                        <table class="table table-sm table-striped">
                            <thead>
                                <tr>
                                    <th>Seat Number</th>
                                    <th>Row</th>
                                    <th>Column</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($examHall->seats as $seat)
                                    <tr>
                                        <td><span class="badge badge-primary font-weight-bold">{{ $seat->seat_number }}</span></td>
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
                                    </tr>
                                @empty
                                    <tr><td colspan="4" class="text-center text-muted py-4">No seats configured for this hall yet.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
