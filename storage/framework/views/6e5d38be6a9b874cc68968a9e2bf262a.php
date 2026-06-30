

<?php $__env->startSection('title', 'Edit User'); ?>
<?php $__env->startSection('heading', 'Edit User'); ?>
<?php $__env->startSection('subheading', 'Update user details'); ?>

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
            <form method="POST" action="<?php echo e(route('admin.users.update', $user)); ?>">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>

                <div class="mb-3">
                    <label class="form-label">Name</label>
                    <input type="text" name="name" value="<?php echo e(old('name', $user->name)); ?>" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" value="<?php echo e(old('email', $user->email)); ?>" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Role</label>
                    <select name="role" class="form-select" required>
                        <option value="user" <?php echo e((string)old('role', $user->role) === 'user' ? 'selected' : ''); ?>>user</option>
                        <option value="admin" <?php echo e((string)old('role', $user->role) === 'admin' ? 'selected' : ''); ?>>admin</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">New Password (optional)</label>
                    <input type="password" name="password" class="form-control" autocomplete="new-password">
                </div>

                <div class="mb-3">
                    <label class="form-label">Confirm New Password</label>
                    <input type="password" name="password_confirmation" class="form-control" autocomplete="new-password">
                </div>

                <button type="submit" class="btn btn-primary">Save Changes</button>
                <a href="<?php echo e(route('admin.users.index')); ?>" class="btn btn-outline-secondary">Back</a>
            </form>
        </div>
    </div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('admin.layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\CHANTHY.CHET\Desktop\Full Stack E-Commerce System\ecommerce-backend\resources\views/admin/users/edit.blade.php ENDPATH**/ ?>