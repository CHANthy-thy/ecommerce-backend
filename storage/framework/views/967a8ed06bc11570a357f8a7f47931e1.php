

<?php $__env->startSection('title', 'Order Details'); ?>
<?php $__env->startSection('heading', 'Order Details'); ?>
<?php $__env->startSection('subheading', 'Manage order items and status'); ?>

<?php $__env->startSection('content'); ?>
    <div class="card shadow-sm mb-4">
        <div class="card-body d-flex justify-content-between align-items-start">
            <div>
                <h5 class="card-title mb-2">Order #<?php echo e($order->id); ?></h5>
                <div class="text-muted">Status: <strong><?php echo e($order->status); ?></strong></div>
                <div class="mt-2">Subtotal: <strong><?php echo e($order->subtotal); ?></strong></div>
                <div>Total: <strong><?php echo e($order->total); ?></strong></div>
            </div>
        </div>
    </div>

    <?php if(session('success')): ?>
        <div class="alert alert-success"><?php echo e(session('success')); ?></div>
    <?php endif; ?>

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
                        <?php $__empty_1 = true; $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><?php echo e($item->product_name); ?></td>
                                <td><?php echo e($item->unit_price); ?></td>
                                <td><?php echo e($item->quantity); ?></td>
                                <td><?php echo e($item->line_total); ?></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="4" class="text-center text-muted">No items</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <h6 class="mb-3">Update Status</h6>

            <form method="POST" action="<?php echo e(route('admin.orders.updateStatus', $order)); ?>">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>

                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <?php $__currentLoopData = ['pending','processing','completed','cancelled']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($s); ?>" <?php if($order->status === $s): echo 'selected'; endif; ?>><?php echo e($s); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Save Status</button>
            </form>
        </div>
    </div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('admin.layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\CHANTHY.CHET\Desktop\Full Stack E-Commerce System\ecommerce-backend\resources\views/admin/orders/show.blade.php ENDPATH**/ ?>