<?php $__env->startSection('title', 'Create Product'); ?>
<?php $__env->startSection('heading', 'Create Product'); ?>
<?php $__env->startSection('subheading', 'Add a new product'); ?>

<?php $__env->startSection('content'); ?>
    <?php if(session('success')): ?>
        <div class="alert alert-success"><?php echo e(session('success')); ?></div>
    <?php endif; ?>

    <?php if($errors->any()): ?>
        <div class="alert alert-danger">
            <ul class="mb-0">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    <div class="card shadow-sm">
        <div class="card-body">
            <form method="POST" action="<?php echo e(route('admin.products.store')); ?>" enctype="multipart/form-data">

                <?php echo csrf_field(); ?>

                <div class="mb-3">
                    <label class="form-label">Category</label>
                    <select name="category_id" class="form-select" required>
                        <option value="">-- Select Category --</option>
                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($category->id); ?>" <?php echo e(old('category_id') == $category->id ? 'selected' : ''); ?>>
                                <?php echo e($category->name); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Brand</label>
                    <select name="brand_id" class="form-select">
                        <option value="">-- Select Brand --</option>
                        <?php $__currentLoopData = $brands; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $brand): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($brand->id); ?>" <?php echo e(old('brand_id') == $brand->id ? 'selected' : ''); ?>>
                                <?php echo e($brand->name); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Product Name</label>
                    <input type="text" name="name" value="<?php echo e(old('name')); ?>" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="4"><?php echo e(old('description')); ?></textarea>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Price</label>
                        <input type="number" name="price" value="<?php echo e(old('price')); ?>" step="0.01" min="0" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Stock</label>
                        <input type="number" name="stock" value="<?php echo e(old('stock')); ?>" min="0" step="1" class="form-control" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Skin Type</label>
                        <input type="text" name="skin_type" value="<?php echo e(old('skin_type')); ?>" class="form-control" placeholder="e.g., normal, dry">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Volume</label>
                        <input type="text" name="volume" value="<?php echo e(old('volume')); ?>" class="form-control" placeholder="e.g., 150ml">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Ingredients</label>
                    <textarea name="ingredients" class="form-control" rows="2"><?php echo e(old('ingredients')); ?></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="active" <?php echo e(old('status') == 'active' ? 'selected' : ''); ?>>Active</option>
                        <option value="inactive" <?php echo e(old('status') == 'inactive' ? 'selected' : ''); ?>>Inactive</option>
                        <option value="archived" <?php echo e(old('status') == 'archived' ? 'selected' : ''); ?>>Archived</option>
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

                        <input type="text" name="image_url" class="form-control" placeholder="https://example.com/image.jpg" id="imageUrl" value="<?php echo e(old('image_url')); ?>">
                        <div class="form-text">Must be a valid URL starting with https://</div>
                    </div>
                </div>



                <div class="mb-3">
                    <label class="form-label">Live Preview (100×100)</label>
                    <div>
                        <img
                            id="imagePreview"
                            src="<?php echo e(asset('images/products/placeholder-100x100.png')); ?>"
                            alt="Image preview"
                            style="width: 100px; height: 100px; object-fit: cover; border-radius: 12px; border: 1px solid rgba(0,0,0,0.1);"
                            onerror="this.src='<?php echo e(asset('images/products/placeholder-100x100.png')); ?>'"
                        >
                    </div>
                </div>


                <button type="submit" class="btn btn-primary">Create</button>
                <a href="<?php echo e(route('admin.products.index')); ?>" class="btn btn-outline-secondary">Back</a>
            </form>
        </div>
    </div>
<?php $__env->startPush('scripts'); ?>
    <script src="<?php echo e(asset('js/admin/product-image-preview.js')); ?>"></script>
<?php $__env->stopPush(); ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\CHANTHY.CHET\Desktop\Full Stack E-Commerce System\ecommerce-backend\resources\views/admin/products/create.blade.php ENDPATH**/ ?>