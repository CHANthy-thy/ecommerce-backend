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

                <div class="mb-3">
                    <label class="form-label">Current Image</label>
                    @if (!empty($product->image))
                        <div class="mb-2">
                            <img src="{{ asset('storage/'.$product->image) }}" alt="Product image" style="max-width: 220px; border-radius: 8px; border: 1px solid rgba(0,0,0,0.1);">
                        </div>
                    @else
                        <p class="text-muted mb-2">No image uploaded.</p>
                    @endif

                    <label class="form-label mt-3">Change Image — Upload File (optional)</label>
                    <input type="file" name="image_file" class="form-control" accept="image/*" id="imageFile">
                    <div class="form-text">Leave file empty and image URL empty to keep the current image.</div>

                    <label class="form-label mt-3">Or Paste Image URL</label>
                    <input type="url" name="image_url" class="form-control" placeholder="https://example.com/image.jpg" id="imageUrl" value="{{ old('image_url') }}">
                </div>

                <button type="submit" class="btn btn-primary">Save Changes</button>
                <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">Back</a>
            </form>
        </div>
    </div>
@endsection

