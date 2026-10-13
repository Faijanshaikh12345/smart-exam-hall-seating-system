@extends('layouts.app')

@section('title', 'Setting Details')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 font-weight-bold">Setting Details</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('settings.index') }}">Settings</a></li>
                    <li class="breadcrumb-item active">{{ $setting->key }}</li>
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
                            <span class="badge badge-info px-3 py-2 font-size-lg font-monospace"><code>{{ $setting->key }}</code></span>
                        </div>

                        <ul class="list-group list-group-unbordered mb-3">
                            <li class="list-group-item">
                                <b>Group</b> <span class="float-right badge badge-secondary">{{ $setting->group }}</span>
                            </li>
                            <li class="list-group-item">
                                <b>Last Updated</b> <span class="float-right text-muted">{{ $setting->updated_at->format('M d, Y h:i A') }}</span>
                            </li>
                            <li class="list-group-item">
                                <b>Setting Value</b> 
                                <div class="mt-2 p-3 bg-light rounded border">
                                    <pre class="mb-0 text-wrap">{{ $setting->value ?: '(empty)' }}</pre>
                                </div>
                            </li>
                        </ul>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('settings.index') }}" class="btn btn-secondary btn-sm">
                                <i class="fas fa-arrow-left mr-1"></i> Back
                            </a>
                            <a href="{{ route('settings.edit', $setting) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit mr-1"></i> Edit Setting
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
