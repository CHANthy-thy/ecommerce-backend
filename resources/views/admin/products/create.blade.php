@extends('admin.layouts.admin')

@section('title', 'Create Product')
@section('heading', 'Create Product')
@section('subheading', 'Add a new product')

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
            <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Category</label>
                    <select name="category_id" class="form-select" required>
                        <option value="">-- Select Category --</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Product Name</label>
                    <input type="text" name="name" value="{{ old('name') }}" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="4">{{ old('description') }}</textarea>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Price</label>
                        <input type="number" name="price" value="{{ old('price') }}" step="0.01" min="0" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Stock</label>
                        <input type="number" name="stock" value="{{ old('stock') }}" min="0" step="1" class="form-control" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Image Upload</label>
                    <input type="file" name="image_file" class="form-control" accept="image/*" id="imageFile">
                    <div class="form-text">Upload JPG, PNG, or WebP (max 2MB).</div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Image URL</label>
                    <input type="url" name="image_url" class="form-control" placeholder="https://example.com/image.jpg" id="imageUrl">
                    <div class="form-text">Or paste a direct link to an image. Leave both empty to skip.</div>
                </div>

                <button type="submit" class="btn btn-primary">Create</button>
                <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">Back</a>
            </form>
        </div>
    </div>
@endsection

