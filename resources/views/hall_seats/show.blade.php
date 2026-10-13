@extends('layouts.app')

@section('title', 'Hall Seat Details')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 font-weight-bold">Seat Details</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('hall-seats.index') }}">Hall Seats</a></li>
                    <li class="breadcrumb-item active">{{ $hallSeat->seat_number }}</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6 mx-auto">
                <div class="card card-primary card-outline shadow-sm">
                    <div class="card-body box-profile">
                        <div class="text-center mb-3">
                            <span class="badge badge-primary px-4 py-2 font-size-lg">{{ $hallSeat->seat_number }}</span>
                        </div>

                        <h3 class="profile-username text-center font-weight-bold">{{ $hallSeat->examHall->name ?? 'Hall' }}</h3>
                        <p class="text-muted text-center">{{ $hallSeat->examHall->hall_code ?? '' }}</p>

                        <div class="text-center mb-3">
                            <span class="badge badge-success px-3 py-1">{{ ucfirst($hallSeat->status) }}</span>
                        </div>

                        <ul class="list-group list-group-unbordered mb-3">
                            <li class="list-group-item">
                                <b>Row</b> <span class="float-right font-weight-bold">{{ $hallSeat->row_number ?: '-' }}</span>
                            </li>
                            <li class="list-group-item">
                                <b>Column</b> <span class="float-right font-weight-bold">{{ $hallSeat->column_number ?: '-' }}</span>
                            </li>
                            <li class="list-group-item">
                                <b>Location</b> <span class="float-right text-muted">{{ $hallSeat->examHall->building ?? '-' }} / {{ $hallSeat->examHall->floor ?? '-' }}</span>
                            </li>
                            <li class="list-group-item">
                                <b>Assigned Seating Count</b> <span class="float-right badge badge-info">{{ $hallSeat->seatingArrangements->count() }}</span>
                            </li>
                        </ul>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('hall-seats.index') }}" class="btn btn-secondary btn-sm">
                                <i class="fas fa-arrow-left mr-1"></i> Back
                            </a>
                            <a href="{{ route('hall-seats.edit', $hallSeat) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit mr-1"></i> Edit Seat
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
