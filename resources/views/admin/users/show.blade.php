@extends('admin.layouts.admin')

@section('title', 'User Details')
@section('heading', 'User Details')
@section('subheading', 'View user information')

@section('content')
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="d-flex align-items-start justify-content-between gap-3 flex-wrap">
                <div>
                    <h5 class="mb-1">{{ $user->name }}</h5>
                    <div class="text-muted">{{ $user->email }}</div>
                </div>

                <div>
                    <span class="badge {{ $user->role === 'admin' ? 'text-bg-primary' : 'text-bg-secondary' }}">{{ $user->role }}</span>
                </div>
            </div>

            <hr>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <div class="fw-medium">Created Date</div>
                    <div class="text-muted">{{ $user->created_at?->format('Y-m-d H:i') }}</div>
                </div>
            </div>

            <div class="d-flex gap-2 mt-3 flex-wrap">
                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-outline-secondary">Edit</a>
                <a href="{{ route('admin.users.index') }}" class="btn btn-outline-primary">Back to list</a>
            </div>
        </div>
    </div>
@endsection

