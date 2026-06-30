<?php $__env->startSection('title', 'Products'); ?>
<?php $__env->startSection('heading', 'Products'); ?>
<?php $__env->startSection('subheading', 'Admin products management'); ?>

<?php $__env->startSection('content'); ?>
    <?php if(session('success')): ?>
        <div class="alert alert-success"><?php echo e(session('success')); ?></div>
    <?php endif; ?>

    <div class="d-flex align-items-center justify-content-between mb-3">
        <h5 class="mb-0">Products</h5>
        <a href="<?php echo e(route('admin.products.create')); ?>" class="btn btn-primary">Create Product</a>
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
                        <?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
<td>
                                    <?php
                                        $imgSrc = $product->image_url ?: ($product->image ? asset('storage/' . $product->image) : asset('images/products/placeholder-100x100.png'));
                                        $imgLink = $product->image_url ?: $product->image;
                                    ?>
                                    <?php if($imgLink): ?>
                                        <a href="<?php echo e($imgLink); ?>" target="_blank" rel="noopener noreferrer">
                                    <?php endif; ?>
                                        <img
                                            src="<?php echo e($imgSrc); ?>"
                                            alt="<?php echo e($product->name); ?>"
                                            style="width: 70px; height: 70px; object-fit: cover; border-radius: 8px;"
                                            loading="lazy"
                                            onerror="this.src='<?php echo e(asset('images/products/placeholder-100x100.png')); ?>'"
                                        >
                                    <?php if($imgLink): ?>
                                        </a>
                                    <?php endif; ?>
                                </td>

                                <td class="fw-medium"><?php echo e($product->name); ?></td>
                                <td class="text-muted"><?php echo e($product->category?->name ?? '—'); ?></td>
                                <td><?php echo e(number_format((float)$product->price, 2)); ?></td>
                                <td><?php echo e((int)$product->stock); ?></td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="<?php echo e(route('admin.products.edit', $product)); ?>" class="btn btn-sm btn-outline-primary">Edit</a>

                                        <form method="POST" action="<?php echo e(route('admin.products.destroy', $product)); ?>" onsubmit="return confirm('Delete this product?');">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="6" class="text-muted">No products found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <?php if(method_exists($products, 'links')): ?>
                <div class="mt-3"><?php echo e($products->links()); ?></div>
            <?php endif; ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\CHANTHY.CHET\Desktop\Full Stack E-Commerce System\ecommerce-backend\resources\views/admin/products/index.blade.php ENDPATH**/ ?>