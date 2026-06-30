

<?php $__env->startSection('title', 'Orders'); ?>
<?php $__env->startSection('heading', 'Orders'); ?>
<?php $__env->startSection('subheading', 'Admin orders management'); ?>

<?php $__env->startSection('content'); ?>

    <?php if(session('success')): ?>
        <div class="alert alert-success"><?php echo e(session('success')); ?></div>
    <?php endif; ?>

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" class="row g-2 align-items-end">
                <div class="col-md-6">
                    <label class="form-label">Search (id/status)</label>
                    <input type="text" name="search" value="<?php echo e($search ?? ''); ?>" class="form-control" placeholder="e.g. 12 or pending" />
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">Search</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="card-title mb-0">Orders</h5>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>User ID</th>
                            <th>Status</th>
                            <th>Subtotal</th>
                            <th>Total</th>
                            <th>Created</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><?php echo e($order->id); ?></td>
                                <td><?php echo e($order->user_id); ?></td>
                                <td>
                                    <span class="badge text-bg-<?php echo e($order->status === 'completed' ? 'success' : ($order->status === 'cancelled' ? 'danger' : 'secondary')); ?>">
                                        <?php echo e($order->status); ?>

                                    </span>
                                </td>
                                <td><?php echo e($order->subtotal); ?></td>
                                <td><?php echo e($order->total); ?></td>
                                <td><?php echo e($order->created_at?->toDateTimeString()); ?></td>
                                <td class="text-end">
                                    <a class="btn btn-sm btn-outline-primary" href="<?php echo e(route('admin.orders.show', $order)); ?>">View</a>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="7" class="text-center text-muted">No orders found</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                <?php echo e($orders->links()); ?>

            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('admin.layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\CHANTHY.CHET\Desktop\Full Stack E-Commerce System\ecommerce-backend\resources\views/admin/orders/index.blade.php ENDPATH**/ ?>