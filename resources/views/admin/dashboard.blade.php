@extends('admin.layouts.admin')

@section('title', 'Admin Dashboard')
@section('heading', 'Admin Dashboard')
@section('subheading', 'E-commerce overview')

@section('content')
    {{-- Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    {{-- Simple chart placeholder styles (future-ready) --}}
    <style>
        .stat-card .stat-icon {
            width: 44px;
            height: 44px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            background: rgba(13, 110, 253, 0.10);
        }

        .stat-card .stat-icon.bg-success { background: rgba(25, 135, 84, 0.12); }
        .stat-card .stat-icon.bg-warning { background: rgba(255, 193, 7, 0.15); }
        .stat-card .stat-icon.bg-info { background: rgba(13, 202, 240, 0.12); }
        .stat-card .stat-icon.bg-danger { background: rgba(220, 53, 69, 0.12); }
        .stat-card .stat-icon.bg-secondary { background: rgba(108, 117, 125, 0.12); }

        .table > :not(caption) > * > * {
            padding-top: 0.85rem;
            padding-bottom: 0.85rem;
        }

        /* Future charts container */
        .chart-placeholder {
            min-height: 240px;
        }
    </style>


@php
        $stats = $stats ?? [];
        $recentOrders = $recentOrders ?? collect();
        $latestProducts = $latestProducts ?? collect();
        $lowStockProducts = $lowStockProducts ?? collect();


        // Number formatting helpers
        $money = function ($value) {
            $v = is_numeric($value) ? (float) $value : 0.0;
            return '$' . number_format($v, 2);
        };

        $statusBadgeClass = function ($status) {
            return match (true) {
                $status === 'completed' => 'success',
                $status === 'pending' => 'warning',
                default => 'secondary',
            };
        };
    @endphp

    {{-- Stat cards --}}
    <div class="row g-3">
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="card shadow-sm h-100 stat-card">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-muted">Total Categories</div>
                        <div class="fs-2 fw-bold">{{ $stats['total_categories'] ?? 0 }}</div>
                    </div>
                    <div class="stat-icon bg-primary text-primary"><i class="bi bi-tags fs-4"></i></div>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-lg-3">
            <div class="card shadow-sm h-100 stat-card">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-muted">Total Brands</div>
                        <div class="fs-2 fw-bold">{{ $stats['total_brands'] ?? 0 }}</div>
                    </div>
                    <div class="stat-icon bg-success text-success"><i class="bi bi-bag-check fs-4"></i></div>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-lg-3">
            <div class="card shadow-sm h-100 stat-card">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-muted">Total Products</div>
                        <div class="fs-2 fw-bold">{{ $stats['total_products'] ?? 0 }}</div>
                    </div>
                    <div class="stat-icon bg-info text-info"><i class="bi bi-box-seam fs-4"></i></div>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-lg-3">
            <div class="card shadow-sm h-100 stat-card">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-muted">Total Users</div>
                        <div class="fs-2 fw-bold">{{ $stats['total_users'] ?? 0 }}</div>
                    </div>
                    <div class="stat-icon bg-warning text-warning"><i class="bi bi-people fs-4"></i></div>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-lg-3">
            <div class="card shadow-sm h-100 stat-card">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-muted">Total Orders</div>
                        <div class="fs-2 fw-bold">{{ $stats['total_orders'] ?? 0 }}</div>
                    </div>
                    <div class="stat-icon bg-primary text-primary"><i class="bi bi-receipt fs-4"></i></div>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-lg-3">
            <div class="card shadow-sm h-100 stat-card">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-muted">Pending Orders</div>
                        <div class="fs-2 fw-bold">{{ $stats['pending_orders'] ?? 0 }}</div>
                    </div>
                    <div class="stat-icon bg-warning text-warning"><i class="bi bi-hourglass-split fs-4"></i></div>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-lg-3">
            <div class="card shadow-sm h-100 stat-card">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-muted">Completed Orders</div>
                        <div class="fs-2 fw-bold">{{ $stats['completed_orders'] ?? 0 }}</div>
                    </div>
                    <div class="stat-icon bg-success text-success"><i class="bi bi-check-circle fs-4"></i></div>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-lg-3">
            <div class="card shadow-sm h-100 stat-card">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-muted">In Stock Products</div>
                        <div class="fs-2 fw-bold">{{ $stats['in_stock_products'] ?? 0 }}</div>
                    </div>
                    <div class="stat-icon bg-info text-info"><i class="bi bi-clipboard-check fs-4"></i></div>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-lg-3">
            <div class="card shadow-sm h-100 stat-card">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-muted">Low Stock Products (≤ 10)</div>
                        <div class="fs-2 fw-bold">{{ $stats['low_stock_products'] ?? 0 }}</div>
                    </div>
                    <div class="stat-icon bg-warning text-warning"><i class="bi bi-exclamation-triangle fs-4"></i></div>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-lg-3">
            <div class="card shadow-sm h-100 stat-card">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-muted">Out of Stock Products</div>
                        <div class="fs-2 fw-bold">{{ $stats['out_of_stock_products'] ?? 0 }}</div>
                    </div>
                    <div class="stat-icon bg-danger text-danger"><i class="bi bi-x-circle fs-4"></i></div>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-12 col-lg-6">
            <div class="card shadow-sm h-100 stat-card">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-muted">Total Revenue (Completed Orders)</div>
                        <div class="fs-2 fw-bold">{{ $money($stats['total_revenue'] ?? 0) }}</div>
                    </div>
                    <div class="stat-icon bg-primary text-primary"><i class="bi bi-currency-rupee fs-4"></i></div>
                </div>
            </div>
        </div>
    </div>


    {{-- Quick Actions --}}
    <div class="row mt-3">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between gap-2 flex-wrap">
                        <h5 class="mb-0">Quick Actions</h5>
                        <div class="d-flex gap-2 flex-wrap">
                            <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
                                <i class="bi bi-plus-circle me-1"></i> Add Product
                            </a>
                            <a href="{{ route('admin.categories.create') }}" class="btn btn-outline-primary">
                                <i class="bi bi-folder-plus me-1"></i> Add Category
                            </a>
                            <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-success">
                                <i class="bi bi-receipt me-1"></i> View Orders
                            </a>
                            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-people me-1"></i> View Users
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Analytics section --}}
    <div class="row mt-3 g-3">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h5 class="card-title mb-0">Analytics</h5>
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-12 col-sm-6 col-lg-3">
                            <div class="card shadow-sm h-100 stat-card">
                                <div class="card-body d-flex align-items-center justify-content-between">
                                    <div>
                                        <div class="text-muted">Today's Revenue</div>
                                        <div class="fs-2 fw-bold">{{ $money($today_revenue ?? 0) }}</div>
                                    </div>
                                    <div class="stat-icon bg-primary text-primary"><i class="bi bi-calendar-day fs-4"></i></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-sm-6 col-lg-3">
                            <div class="card shadow-sm h-100 stat-card">
                                <div class="card-body d-flex align-items-center justify-content-between">
                                    <div>
                                        <div class="text-muted">This Month Revenue (Monthly Sales)</div>
                                        <div class="fs-2 fw-bold">{{ $money($month_revenue ?? 0) }}</div>
                                    </div>
                                    <div class="stat-icon bg-success text-success"><i class="bi bi-calendar-month fs-4"></i></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-sm-6 col-lg-3">
                            <div class="card shadow-sm h-100 stat-card">
                                <div class="card-body">
                                    <div class="text-muted">Payment Status</div>
                                    <div class="d-flex gap-3 mt-2">
                                        <div>
                                            <span class="badge text-bg-success">Paid</span>
                                            <span class="fw-semibold">{{ $paymentStatus['paid'] ?? 0 }}</span>
                                        </div>
                                        <div>
                                            <span class="badge text-bg-warning">Pending</span>
                                            <span class="fw-semibold">{{ $paymentStatus['pending'] ?? 0 }}</span>
                                        </div>
                                        <div>
                                            <span class="badge text-bg-danger">Failed</span>
                                            <span class="fw-semibold">{{ $paymentStatus['failed'] ?? 0 }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-sm-6 col-lg-3">
                            <div class="card shadow-sm h-100 stat-card">
                                <div class="card-body d-flex align-items-center justify-content-between">
                                    <div>
                                        <div class="text-muted">Current Year</div>
                                        <div class="fs-2 fw-bold">{{ date('Y') }}</div>
                                    </div>
                                    <div class="stat-icon bg-info text-info"><i class="bi bi-graph-up fs-4"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="chart-container" style="position: relative; height: 320px; width: 100%;">
                        <canvas id="monthlySalesChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Tables row --}}
    <div class="row mt-3 g-3">
        <div class="col-12 col-lg-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h5 class="card-title mb-0">Recent Orders</h5>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Customer Name</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Created At</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentOrders as $order)
                                    <tr>
                                        <td class="fw-medium">{{ $order->id }}</td>
                                        <td>{{ $order->customer_name ?? optional($order->user)->name ?? '—' }}</td>
                                        <td>{{ $money($order->total ?? 0) }}</td>
                                        <td>
                                            <span class="badge text-bg-{{ $statusBadgeClass($order->status ?? '') }}">
                                                {{ $order->status }}
                                            </span>
                                        </td>
                                        <td class="text-muted">{{ optional($order->created_at)->toDateTimeString() }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted">No recent orders</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h5 class="card-title mb-0">Latest Products</h5>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>Product Image</th>
                                    <th>Product</th>
                                    <th>Category</th>
                                    <th>Brand</th>
                                    <th>Price</th>
                                    <th>Stock</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($latestProducts as $product)
                                    <tr>
                                        <td>
                                            <img
                                                src="{{ $product->image_url ?: ($product->image ? asset('storage/' . $product->image) : asset('images/products/placeholder-100x100.png')) }}"
                                                alt="{{ $product->name }}"
                                                style="width:52px; height:52px; object-fit:cover; border-radius:12px; border:1px solid rgba(0,0,0,0.1);"
                                                onerror="this.src='{{ asset('images/products/placeholder-100x100.png') }}'"
                                            >
                                        </td>
                                        <td class="fw-medium">{{ $product->name }}</td>
                                        <td class="text-muted">{{ $product->category?->name ?? '—' }}</td>
                                        <td class="text-muted">{{ $product->brand?->name ?? '—' }}</td>
                                        <td>{{ '$' . number_format((float)($product->price ?? 0), 2) }}</td>
                                        <td>
                                            @if((int)($product->stock ?? 0) === 0)
                                                <span class="text-danger fw-semibold">0</span>
                                            @elseif((int)($product->stock ?? 0) <= 10)
                                                <span class="text-warning fw-semibold">{{ (int)$product->stock }}</span>
                                            @else
                                                <span class="text-success fw-semibold">{{ (int)$product->stock }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge text-bg-{{ ($product->status ?? '') === 'active' ? 'success' : 'secondary' }}">
                                                {{ $product->status ?? '—' }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center text-muted">No products found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h5 class="card-title mb-0">Low Stock Products</h5>
                        <div class="text-muted small">Stock ≤ 10</div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Category</th>
                                    <th>Brand</th>
                                    <th>Price</th>
                                    <th>Stock</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($lowStockProducts as $product)
                                    @php
                                        $stock = (int)($product->stock ?? 0);
                                        $isOut = $stock === 0;
                                        $rowClass = $isOut ? 'table-danger' : 'table-warning';
                                    @endphp
                                    <tr class="{{ $rowClass }}">

                                        <td class="fw-medium">
                                            {{ $product->name }}
                                        </td>
                                        <td class="text-muted">{{ $product->category?->name ?? '—' }}</td>
                                        <td class="text-muted">{{ $product->brand?->name ?? '—' }}</td>
                                        <td>{{ '$' . number_format((float)($product->price ?? 0), 2) }}</td>
                                        <td class="fw-semibold">
                                            @if($isOut)
                                                <span class="text-danger">0</span>
                                            @else
                                                <span class="text-warning">{{ (int)$product->stock }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge text-bg-{{ ($product->status ?? '') === 'active' ? 'success' : 'secondary' }}">
                                                {{ $product->status ?? '—' }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted">No low stock products</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
    <script>
        (function() {
            const labels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
            const salesData = @json($monthlySales ?? array_fill(0, 12, 0));

            const ctx = document.getElementById('monthlySalesChart');
            if (!ctx) return;

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Monthly Sales',
                        data: salesData,
                        borderColor: '#0d6efd',
                        backgroundColor: 'rgba(13, 110, 253, 0.10)',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.3,
                        pointRadius: 4,
                        pointHoverRadius: 6,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return '$' + new Intl.NumberFormat('en-IN', { minimumFractionDigits: 2, maximumFractionDigits: 2 }).format(context.parsed.y);
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return '$' + new Intl.NumberFormat('en-IN').format(value);
                                }
                            }
                        }
                    }
                }
            });
        })();
    </script>
@endsection

