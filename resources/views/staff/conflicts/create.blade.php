@extends('layouts.app')

@section('title', 'Report Conflict')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 font-weight-bold">Report Exam Conflict</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('staff.conflicts.index') }}">Conflicts</a></li>
                    <li class="breadcrumb-item active">Report</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="card card-danger shadow-sm">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-exclamation-triangle mr-1"></i> Conflict Details</h3>
                    </div>
                    <form action="{{ route('staff.conflicts.store') }}" method="POST">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label for="conflict_type">Conflict Type <span class="text-danger">*</span></label>
                                <input type="text" name="conflict_type" id="conflict_type" class="form-control @error('conflict_type') is-invalid @enderror" placeholder="e.g. Double booking, wrong seat, student absent" value="{{ old('conflict_type') }}" required>
                                @error('conflict_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exam_id">Associated Exam</label>
                                        <select name="exam_id" id="exam_id" class="form-control @error('exam_id') is-invalid @enderror">
                                            <option value="">— None / General —</option>
                                            @foreach($exams as $exam)
                                                <option value="{{ $exam->id }}" {{ old('exam_id') == $exam->id ? 'selected' : '' }}>
                                                    {{ $exam->name }} ({{ $exam->exam_code }})
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('exam_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="student_id">Affected Student</label>
                                        <select name="student_id" id="student_id" class="form-control @error('student_id') is-invalid @enderror">
                                            <option value="">— None / General —</option>
                                            @foreach($students as $student)
                                                <option value="{{ $student->id }}" {{ old('student_id') == $student->id ? 'selected' : '' }}>
                                                    {{ $student->student_code }} — {{ $student->user->name ?? 'Student' }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('student_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="seating_arrangement_id">Related Seat Allocation (optional)</label>
                                <select name="seating_arrangement_id" id="seating_arrangement_id" class="form-control @error('seating_arrangement_id') is-invalid @enderror">
                                    <option value="">— Not linked to a seat —</option>
                                    @foreach($seatingArrangements as $arr)
                                        <option value="{{ $arr->id }}" {{ old('seating_arrangement_id') == $arr->id ? 'selected' : '' }}>
                                            {{ $arr->exam->exam_code ?? 'Exam' }} /
                                            {{ $arr->student->student_code ?? 'Student' }} /
                                            {{ $arr->examHall->name ?? 'Hall' }} Seat {{ $arr->hallSeat->seat_number ?? '?' }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('seating_arrangement_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="severity">Severity Level</label>
                                <select name="severity" id="severity" class="form-control @error('severity') is-invalid @enderror">
                                    <option value="low" {{ old('severity') === 'low' ? 'selected' : '' }}>Low</option>
                                    <option value="medium" {{ old('severity', 'medium') === 'medium' ? 'selected' : '' }}>Medium</option>
                                    <option value="high" {{ old('severity') === 'high' ? 'selected' : '' }}>High</option>
                                    <option value="critical" {{ old('severity') === 'critical' ? 'selected' : '' }}>Critical</option>
                                </select>
                                @error('severity')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="description">Detailed Description <span class="text-danger">*</span></label>
                                <textarea name="description" id="description" rows="4" class="form-control @error('description') is-invalid @enderror" placeholder="Describe the issue, time, hall, and student details..." required>{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="card-footer d-flex justify-content-between">
                            <a href="{{ route('staff.conflicts.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left mr-1"></i> Cancel
                            </a>
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-paper-plane mr-1"></i> Submit Report
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
