@extends('layouts.app')

@section('title', 'Resolve Conflict')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 font-weight-bold">Resolve Conflict</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('conflicts.index') }}">Conflicts</a></li>
                    <li class="breadcrumb-item active">Resolve</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-9 mx-auto">
                <div class="card card-warning shadow-sm">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-tools mr-1"></i> Conflict #{{ $conflict->id }}: {{ $conflict->conflict_type }}</h3>
                    </div>
                    <form action="{{ route('conflicts.update', $conflict) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="form-group">
                                <label for="conflict_type">Conflict Type <span class="text-danger">*</span></label>
                                <input type="text" name="conflict_type" id="conflict_type" class="form-control @error('conflict_type') is-invalid @enderror" value="{{ old('conflict_type', $conflict->conflict_type) }}" required>
                                @error('conflict_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="severity">Severity</label>
                                        <select name="severity" id="severity" class="form-control @error('severity') is-invalid @enderror">
                                            <option value="low" {{ old('severity', $conflict->severity) === 'low' ? 'selected' : '' }}>Low</option>
                                            <option value="medium" {{ old('severity', $conflict->severity) === 'medium' ? 'selected' : '' }}>Medium</option>
                                            <option value="high" {{ old('severity', $conflict->severity) === 'high' ? 'selected' : '' }}>High</option>
                                            <option value="critical" {{ old('severity', $conflict->severity) === 'critical' ? 'selected' : '' }}>Critical</option>
                                        </select>
                                        @error('severity')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="status">Resolution Status</label>
                                        <select name="status" id="status" class="form-control @error('status') is-invalid @enderror">
                                            <option value="open" {{ old('status', $conflict->status) === 'open' ? 'selected' : '' }}>Open</option>
                                            <option value="investigating" {{ old('status', $conflict->status) === 'investigating' ? 'selected' : '' }}>Investigating</option>
                                            <option value="resolved" {{ old('status', $conflict->status) === 'resolved' ? 'selected' : '' }}>Resolved</option>
                                            <option value="dismissed" {{ old('status', $conflict->status) === 'dismissed' ? 'selected' : '' }}>Dismissed</option>
                                        </select>
                                        @error('status')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea name="description" id="description" rows="3" class="form-control @error('description') is-invalid @enderror" required>{{ old('description', $conflict->description) }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="resolution_notes">Resolution Notes / Action Taken</label>
                                <textarea name="resolution_notes" id="resolution_notes" rows="4" class="form-control @error('resolution_notes') is-invalid @enderror" placeholder="Explain how this conflict was settled...">{{ old('resolution_notes', $conflict->resolution_notes) }}</textarea>
                                @error('resolution_notes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="card-footer d-flex justify-content-between">
                            <a href="{{ route('conflicts.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left mr-1"></i> Cancel
                            </a>
                            <button type="submit" class="btn btn-warning">
                                <i class="fas fa-check-circle mr-1"></i> Update Conflict Status
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
