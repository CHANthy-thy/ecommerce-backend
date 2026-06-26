@extends('admin.layouts.admin')

@section('title', 'Admin Dashboard')
@section('heading', 'Admin Dashboard')
@section('subheading', 'Dashboard statistics')

@section('content')
    <div class="row g-3">
        <div class="col-12 col-md-6 col-lg-3">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <div class="text-muted">Total Categories</div>
                    <div class="fs-2 fw-bold">{{ $total_categories ?? 0 }}</div>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-6 col-lg-3">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <div class="text-muted">Total Products</div>
                    <div class="fs-2 fw-bold">{{ $total_products ?? 0 }}</div>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-6 col-lg-3">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <div class="text-muted">Total Orders</div>
                    <div class="fs-2 fw-bold">{{ $total_orders ?? 0 }}</div>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-6 col-lg-3">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <div class="text-muted">Total Users</div>
                    <div class="fs-2 fw-bold">{{ $total_users ?? 0 }}</div>
                </div>
            </div>
        </div>
    </div>
@endsection



