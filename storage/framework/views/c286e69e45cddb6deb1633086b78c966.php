

<?php $__env->startSection('title', 'Users'); ?>
<?php $__env->startSection('heading', 'Users'); ?>
<?php $__env->startSection('subheading', 'Admin user management'); ?>

<?php $__env->startSection('content'); ?>
    <?php if(session('success')): ?>
        <div class="alert alert-success"><?php echo e(session('success')); ?></div>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <div class="alert alert-danger"><?php echo e(session('error')); ?></div>
    <?php endif; ?>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="d-flex align-items-center justify-content-between mb-3 gap-2 flex-wrap">
                <div>
                    <h5 class="card-title mb-0">Users</h5>
                </div>

                <div class="d-flex gap-2">
                    <a href="<?php echo e(route('admin.users.create')); ?>" class="btn btn-primary">Create User</a>
                </div>
            </div>

            <form method="GET" action="<?php echo e(route('admin.users.index')); ?>" class="mb-3">
                <div class="input-group">
                    <input type="text" name="search" value="<?php echo e(old('search', $search ?? '')); ?>" class="form-control" placeholder="Search by name, email, or role">
                    <button class="btn btn-outline-secondary" type="submit">Search</button>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Created Date</th>
                            <th style="width: 18%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td class="fw-medium"><?php echo e($user->name); ?></td>
                                <td class="text-muted"><?php echo e($user->email); ?></td>
                                <td>
                                    <span class="badge <?php echo e($user->role === 'admin' ? 'text-bg-primary' : 'text-bg-secondary'); ?>"><?php echo e($user->role); ?></span>
                                </td>
                                <td class="text-muted"><?php echo e($user->created_at?->format('Y-m-d')); ?></td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="<?php echo e(route('admin.users.show', $user)); ?>" class="btn btn-sm btn-outline-primary">View</a>
                                        <a href="<?php echo e(route('admin.users.edit', $user)); ?>" class="btn btn-sm btn-outline-secondary">Edit</a>
                                    </div>
                                    <div class="mt-2">
                                        <form method="POST" action="<?php echo e(route('admin.users.destroy', $user)); ?>" onsubmit="return confirm('Delete this user?');">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="btn btn-sm btn-outline-danger w-100">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="5" class="text-muted">No users found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <?php if(method_exists($users, 'links')): ?>
                <div class="mt-3"><?php echo e($users->links()); ?></div>
            <?php endif; ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('admin.layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\CHANTHY.CHET\Desktop\Full Stack E-Commerce System\ecommerce-backend\resources\views/admin/users/index.blade.php ENDPATH**/ ?>