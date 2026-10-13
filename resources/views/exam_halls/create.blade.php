@extends('layouts.app')

@section('title', 'Add Exam Hall')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 font-weight-bold">Create Exam Hall</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('exam-halls.index') }}">Halls</a></li>
                    <li class="breadcrumb-item active">Create</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="card card-primary shadow-sm">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-plus-circle mr-1"></i> New Exam Hall Details</h3>
                    </div>
                    <form action="{{ route('exam-halls.store') }}" method="POST">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="hall_code">Hall Code <span class="text-danger">*</span></label>
                                        <input type="text" name="hall_code" id="hall_code" class="form-control @error('hall_code') is-invalid @enderror" placeholder="e.g. HALL-A, LH-101" value="{{ old('hall_code') }}" required>
                                        @error('hall_code')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Hall Name <span class="text-danger">*</span></label>
                                        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" placeholder="e.g. Main Auditorium" value="{{ old('name') }}" required>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="capacity">Total Capacity <span class="text-danger">*</span></label>
                                        <input type="number" min="1" name="capacity" id="capacity" class="form-control @error('capacity') is-invalid @enderror" placeholder="50" value="{{ old('capacity', 50) }}" required>
                                        @error('capacity')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="building">Building</label>
                                        <input type="text" name="building" id="building" class="form-control @error('building') is-invalid @enderror" placeholder="e.g. Science Block" value="{{ old('building') }}">
                                        @error('building')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="floor">Floor</label>
                                        <input type="text" name="floor" id="floor" class="form-control @error('floor') is-invalid @enderror" placeholder="e.g. 2nd Floor" value="{{ old('floor') }}">
                                        @error('floor')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="status">Hall Status</label>
                                        <select name="status" id="status" class="form-control @error('status') is-invalid @enderror">
                                            <option value="available" {{ old('status') === 'available' ? 'selected' : '' }}>Available</option>
                                            <option value="occupied" {{ old('status') === 'occupied' ? 'selected' : '' }}>Occupied</option>
                                            <option value="maintenance" {{ old('status') === 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                                        </select>
                                        @error('status')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="description">Notes / Features</label>
                                        <input type="text" name="description" id="description" class="form-control @error('description') is-invalid @enderror" placeholder="Air conditioned, projector equipped..." value="{{ old('description') }}">
                                        @error('description')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer d-flex justify-content-between">
                            <a href="{{ route('exam-halls.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left mr-1"></i> Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save mr-1"></i> Save Hall
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
