@extends('admin.layouts.admin')

@section('title', 'Order Details')
@section('heading', 'Order Details')
@section('subheading', 'Manage order items and status')

@section('content')
    <div class="card shadow-sm mb-4">
        <div class="card-body d-flex justify-content-between align-items-start">
            <div>
                <h5 class="card-title mb-2">Order #{{ $order->id }}</h5>
                <div class="text-muted">Status: <strong>{{ $order->status }}</strong></div>
                <div class="mt-2">Subtotal: <strong>{{ $order->subtotal }}</strong></div>
                <div>Total: <strong>{{ $order->total }}</strong></div>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h6 class="mb-3">Order Items</h6>
            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Unit Price</th>
                            <th>Qty</th>
                            <th>Line Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($order->items as $item)
                            <tr>
                                <td>{{ $item->product_name }}</td>
                                <td>{{ $item->unit_price }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>{{ $item->line_total }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted">No items</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <h6 class="mb-3">Update Status</h6>

            <form method="POST" action="{{ route('admin.orders.updateStatus', $order) }}">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        @foreach(['pending','processing','completed','cancelled'] as $s)
                            <option value="{{ $s }}" @selected($order->status === $s)>{{ $s }}</option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Save Status</button>
            </form>
        </div>
    </div>
@endsection

