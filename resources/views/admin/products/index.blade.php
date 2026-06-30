@extends('admin.layouts.admin')

@section('title', 'Products')
@section('heading', 'Products')
@section('subheading', 'Admin products management')

@section('content')
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="d-flex align-items-center justify-content-between mb-3">
        <h5 class="mb-0">Products</h5>
        <a href="{{ route('admin.products.create') }}" class="btn btn-primary">Create Product</a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th style="width: 10%">Image</th>
                            <th style="width: 30%">Product</th>
                            <th style="width: 20%">Category</th>
                            <th style="width: 12%">Price</th>
                            <th style="width: 10%">Stock</th>
                            <th style="width: 18%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($products as $product)
                            <tr>
<td>
                                    @php
                                        $imgSrc = $product->image_url ?: ($product->image ? asset('storage/' . $product->image) : asset('images/products/placeholder-100x100.png'));
                                        $imgLink = $product->image_url ?: $product->image;
                                    @endphp
                                    @if ($imgLink)
                                        <a href="{{ $imgLink }}" target="_blank" rel="noopener noreferrer">
                                    @endif
                                        <img
                                            src="{{ $imgSrc }}"
                                            alt="{{ $product->name }}"
                                            style="width: 70px; height: 70px; object-fit: cover; border-radius: 8px;"
                                            loading="lazy"
                                            onerror="this.src='{{ asset('images/products/placeholder-100x100.png') }}'"
                                        >
                                    @if ($imgLink)
                                        </a>
                                    @endif
                                </td>

                                <td class="fw-medium">{{ $product->name }}</td>
                                <td class="text-muted">{{ $product->category?->name ?? '—' }}</td>
                                <td>{{ number_format((float)$product->price, 2) }}</td>
                                <td>{{ (int)$product->stock }}</td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-sm btn-outline-primary">Edit</a>

                                        <form method="POST" action="{{ route('admin.products.destroy', $product) }}" onsubmit="return confirm('Delete this product?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-muted">No products found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if (method_exists($products, 'links'))
                <div class="mt-3">{{ $products->links() }}</div>
            @endif
        </div>
    </div>
@endsection