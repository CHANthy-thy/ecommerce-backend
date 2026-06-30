

<?php $__env->startSection('title', 'User Details'); ?>
<?php $__env->startSection('heading', 'User Details'); ?>
<?php $__env->startSection('subheading', 'View user information'); ?>

<?php $__env->startSection('content'); ?>
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="d-flex align-items-start justify-content-between gap-3 flex-wrap">
                <div>
                    <h5 class="mb-1"><?php echo e($user->name); ?></h5>
                    <div class="text-muted"><?php echo e($user->email); ?></div>
                </div>

                <div>
                    <span class="badge <?php echo e($user->role === 'admin' ? 'text-bg-primary' : 'text-bg-secondary'); ?>"><?php echo e($user->role); ?></span>
                </div>
            </div>

            <hr>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <div class="fw-medium">Created Date</div>
                    <div class="text-muted"><?php echo e($user->created_at?->format('Y-m-d H:i')); ?></div>
                </div>
            </div>

            <div class="d-flex gap-2 mt-3 flex-wrap">
                <a href="<?php echo e(route('admin.users.edit', $user)); ?>" class="btn btn-outline-secondary">Edit</a>
                <a href="<?php echo e(route('admin.users.index')); ?>" class="btn btn-outline-primary">Back to list</a>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('admin.layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\CHANTHY.CHET\Desktop\Full Stack E-Commerce System\ecommerce-backend\resources\views/admin/users/show.blade.php ENDPATH**/ ?>