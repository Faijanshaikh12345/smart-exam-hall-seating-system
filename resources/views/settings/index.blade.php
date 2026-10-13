@extends('layouts.app')

@section('title', 'System Settings')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 font-weight-bold">System Settings</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Settings</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="card card-outline card-primary shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title"><i class="fas fa-cogs mr-1"></i> Application Configuration</h3>
                <div class="card-tools ml-auto">
                    <a href="{{ route('settings.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus mr-1"></i> Add Setting
                    </a>
                </div>
            </div>
            <div class="card-body p-0 table-responsive">
                <table class="table table-hover table-striped mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th style="width: 60px;">#</th>
                            <th>Key</th>
                            <th>Value</th>
                            <th>Group</th>
                            <th>Updated</th>
                            <th style="width: 170px;" class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($settings as $setting)
                            <tr>
                                <td>{{ $loop->iteration + ($settings->currentPage() - 1) * $settings->perPage() }}</td>
                                <td class="font-weight-bold font-monospace"><code>{{ $setting->key }}</code></td>
                                <td>{{ Str::limit($setting->value, 60) ?: '-' }}</td>
                                <td><span class="badge badge-secondary">{{ $setting->group }}</span></td>
                                <td>{{ $setting->updated_at->format('M d, Y') }}</td>
                                <td class="text-center">
                                    <a href="{{ route('settings.show', $setting) }}" class="btn btn-info btn-xs mr-1" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('settings.edit', $setting) }}" class="btn btn-warning btn-xs mr-1" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('settings.destroy', $setting) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this setting?');">
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
                                <td colspan="6" class="text-center text-muted py-4">
                                    <i class="fas fa-cog fa-2x mb-2 d-block"></i> No custom settings defined.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($settings->hasPages())
                <div class="card-footer clearfix">
                    {{ $settings->links('pagination::bootstrap-4') }}
                </div>
            @endif
        </div>
    </div>
</section>
@endsection
