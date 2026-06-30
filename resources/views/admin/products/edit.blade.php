@extends('admin.layouts.admin')

@section('title', 'Edit Product')
@section('heading', 'Edit Product')
@section('subheading', 'Update product details')

@section('content')
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data">

                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Category</label>
                    <select name="category_id" class="form-select" required>
                        <option value="">-- Select Category --</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ (int)old('category_id', $product->category_id) === $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Brand</label>
                    <select name="brand_id" class="form-select">
                        <option value="">-- Select Brand --</option>
                        @foreach ($brands as $brand)
                            <option value="{{ $brand->id }}" {{ (int)old('brand_id', $product->brand_id) === $brand->id ? 'selected' : '' }}>
                                {{ $brand->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Product Name</label>
                    <input type="text" name="name" value="{{ old('name', $product->name) }}" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="4">{{ old('description', $product->description) }}</textarea>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Price</label>
                        <input type="number" name="price" value="{{ old('price', $product->price) }}" step="0.01" min="0" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Stock</label>
                        <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" min="0" step="1" class="form-control" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Skin Type</label>
                        <input type="text" name="skin_type" value="{{ old('skin_type', $product->skin_type) }}" class="form-control" placeholder="e.g., normal, dry">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Volume</label>
                        <input type="text" name="volume" value="{{ old('volume', $product->volume) }}" class="form-control" placeholder="e.g., 150ml">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Ingredients</label>
                    <textarea name="ingredients" class="form-control" rows="2">{{ old('ingredients', $product->ingredients) }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="active" {{ old('status', $product->status) == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status', $product->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        <option value="archived" {{ old('status', $product->status) == 'archived' ? 'selected' : '' }}>Archived</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Current Image</label>
                    <div class="mb-2">
                        @php
                            $currentImageUrl = $product->image_url ?: ($product->image ? asset('storage/' . $product->image) : asset('images/products/placeholder-100x100.png'));
                        @endphp
                        <img
                            id="imagePreview"
                            src="{{ $currentImageUrl }}"
                            alt="Product image"
                            style="max-width: 220px; border-radius: 12px; border: 1px solid rgba(0,0,0,0.1); object-fit: cover;"
                            onerror="this.src='{{ asset('images/products/placeholder-100x100.png') }}'"
                        >
                    </div>

                    <label class="form-label mt-3">Replace image (choose one)</label>

                    <div class="p-3 mb-3 rounded-3" style="border: 1px dashed rgba(0,0,0,0.15); background: rgba(0,0,0,0.02);">
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="image_source" id="imageSourceFile" value="file" checked>
                            <label class="form-check-label" for="imageSourceFile">Upload file</label>
                        </div>
                        <input type="file" name="image" class="form-control" accept="image/*">
                        <div class="form-text">Leave empty to keep the existing image.</div>
                    </div>

                    <div class="p-3 rounded-3" style="border: 1px dashed rgba(0,0,0,0.15); background: rgba(0,0,0,0.02);">
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="image_source" id="imageSourceUrl" value="url">
                            <label class="form-check-label" for="imageSourceUrl">Paste image URL</label>
                        </div>

                        <input type="text" name="image_url" class="form-control" placeholder="https://example.com/image.jpg" id="imageUrl" value="{{ old('image_url', $product->image_url) }}">
                        <div class="form-text">Leave empty to keep the existing image.</div>
                    </div>
                </div>


                <button type="submit" class="btn btn-primary">Save Changes</button>
                <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">Back</a>
            </form>
        </div>
    </div>
@push('scripts')
    <script src="{{ asset('js/admin/product-image-preview.js') }}"></script>
@endpush

@endsection