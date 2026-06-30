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
                    <label class="form-label">Brand</label>
                    <select name="brand_id" class="form-select">
                        <option value="">-- Select Brand --</option>
                        @foreach ($brands as $brand)
                            <option value="{{ $brand->id }}" {{ old('brand_id') == $brand->id ? 'selected' : '' }}>
                                {{ $brand->name }}
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

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Skin Type</label>
                        <input type="text" name="skin_type" value="{{ old('skin_type') }}" class="form-control" placeholder="e.g., normal, dry">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Volume</label>
                        <input type="text" name="volume" value="{{ old('volume') }}" class="form-control" placeholder="e.g., 150ml">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Ingredients</label>
                    <textarea name="ingredients" class="form-control" rows="2">{{ old('ingredients') }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        <option value="archived" {{ old('status') == 'archived' ? 'selected' : '' }}>Archived</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Product Image (choose one)</label>

                    <div class="p-3 mb-3 rounded-3" style="border: 1px dashed rgba(0,0,0,0.15); background: rgba(0,0,0,0.02);">
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="image_source" id="imageSourceFile" value="file" checked>
                            <label class="form-check-label" for="imageSourceFile">Upload file</label>
                        </div>

                        <input type="file" name="image" class="form-control" accept="image/*">
                        <div class="form-text">Allowed: jpg, jpeg, png, webp (max 2MB).</div>
                    </div>

                    <div class="p-3 rounded-3" style="border: 1px dashed rgba(0,0,0,0.15); background: rgba(0,0,0,0.02);">
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="image_source" id="imageSourceUrl" value="url">
                            <label class="form-check-label" for="imageSourceUrl">Paste image URL</label>
                        </div>

                        <input type="text" name="image_url" class="form-control" placeholder="https://example.com/image.jpg" id="imageUrl" value="{{ old('image_url') }}">
                        <div class="form-text">Must be a valid URL starting with https://</div>
                    </div>
                </div>



                <div class="mb-3">
                    <label class="form-label">Live Preview (100×100)</label>
                    <div>
                        <img
                            id="imagePreview"
                            src="{{ asset('images/products/placeholder-100x100.png') }}"
                            alt="Image preview"
                            style="width: 100px; height: 100px; object-fit: cover; border-radius: 12px; border: 1px solid rgba(0,0,0,0.1);"
                            onerror="this.src='{{ asset('images/products/placeholder-100x100.png') }}'"
                        >
                    </div>
                </div>


                <button type="submit" class="btn btn-primary">Create</button>
                <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">Back</a>
            </form>
        </div>
    </div>
@push('scripts')
    <script src="{{ asset('js/admin/product-image-preview.js') }}"></script>
@endpush

@endsection