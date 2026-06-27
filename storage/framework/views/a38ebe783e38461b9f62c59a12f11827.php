<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title><?php echo $__env->yieldContent('title', 'Admin'); ?></title>

    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    
    <meta name="color-scheme" content="light dark">

    <style>
        /* Simple responsive admin shell */
        body.admin-shell {
            min-height: 100vh;
        }

        .admin-sidebar {
            width: 260px;
            min-height: 100vh;
        }

        @media (max-width: 991.98px) {
            .admin-sidebar {
                width: 100%;
                min-height: auto;
            }
        }

        .admin-nav-link {
            display: block;
            padding: 10px 12px;
            border-radius: 8px;
            color: #f1f5f9;
            text-decoration: none;
        }

        .admin-nav-link:hover {
            background: rgba(255,255,255,0.1);
            color: #ffffff;
            text-decoration: none;
        }

        .admin-nav-link.active {
            background: rgba(255,255,255,0.15);
            color: #ffffff;
            font-weight: 600;
        }
    </style>

    <?php echo $__env->yieldContent('styles'); ?>
</head>

<?php
    // Use Bootstrap's built-in dark classes via HTML attribute.
    $isDark = request()->cookie('admin_dark') === '1';
?>
<body class="admin-shell" data-theme="<?php echo e($isDark ? 'dark' : 'light'); ?>" <?php if($isDark): ?> style="background:#0b1220;" <?php endif; ?>>
    
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="<?php echo e(route('admin.dashboard')); ?>">Admin Panel</a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#adminTopNav" aria-controls="adminTopNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="adminTopNav">
                <ul class="navbar-nav ms-auto align-items-lg-center">
                    <li class="nav-item me-lg-3">
                        <span class="navbar-text">
                            <?php echo e(auth()->user()->name ?? 'Admin'); ?>

                        </span>
                    </li>

                    <li class="nav-item me-lg-2">
                        <button type="button" class="btn btn-sm btn-outline-light" id="adminThemeToggle">
                            Toggle Dark Mode
                        </button>
                    </li>

                    <li class="nav-item">
                        <form method="POST" action="<?php echo e(route('admin.logout')); ?>">
                            <?php echo csrf_field(); ?>
                            <button class="btn btn-sm btn-danger" type="submit">Logout</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row flex-nowrap">
            
            <aside class="admin-sidebar bg-dark text-white col-12 col-lg-3 p-3">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <strong class="fs-5">Menu</strong>
                </div>

                <div class="d-grid gap-2">
                    <a class="admin-nav-link <?php echo e(request()->routeIs('admin.dashboard') ? 'active' : ''); ?>" href="<?php echo e(route('admin.dashboard')); ?>">Dashboard</a>

                    <a class="admin-nav-link <?php echo e(request()->is('admin/categories*') ? 'active' : ''); ?>" href="<?php echo e(route('admin.categories.index')); ?>">Categories</a>
                    <a class="admin-nav-link <?php echo e(request()->is('admin/products*') ? 'active' : ''); ?>" href="<?php echo e(route('admin.products.index')); ?>">Products</a>
                    <a class="admin-nav-link <?php echo e(request()->is('admin/orders*') ? 'active' : ''); ?>" href="<?php echo e(route('admin.orders.index')); ?>">Orders</a>
                    <a class="admin-nav-link <?php echo e(request()->is('admin/users*') ? 'active' : ''); ?>" href="<?php echo e(route('admin.users.index')); ?>">Users</a>

                    <div class="mt-2">
                        <form method="POST" action="<?php echo e(route('admin.logout')); ?>">
                            <?php echo csrf_field(); ?>
                            <button class="admin-nav-link text-start btn btn-link text-white" type="submit" style="width:100%;">Logout</button>
                        </form>
                    </div>
                </div>
            </aside>

            
            <main class="col-12 col-lg-9 p-3 p-lg-4">
                <div class="d-flex align-items-start justify-content-between mb-3">
                    <div>
                        <h2 class="mb-0"><?php echo $__env->yieldContent('heading', 'Dashboard'); ?></h2>
                        <p class="text-muted mb-0"><?php echo $__env->yieldContent('subheading', ''); ?></p>
                    </div>
                </div>

                <?php echo $__env->yieldContent('content'); ?>
            </main>
        </div>
    </div>

    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        (function() {
            const body = document.body;
            const btn = document.getElementById('adminThemeToggle');
            if (!btn) return;

            function applyTheme(isDark) {
                if (isDark) {
                    body.style.background = '#0b1220';
                    body.style.color = '#e9ecef';
                    // Ensure navbar/sidebar remain dark; already using bg-dark.
                } else {
                    body.style.background = '';
                    body.style.color = '';
                }
            }

            let isDark = document.cookie.split('; ').find(row => row.startsWith('admin_dark='))?.split('=')[1] === '1';
            applyTheme(isDark);

            btn.addEventListener('click', function() {
                isDark = !isDark;
                document.cookie = 'admin_dark=' + (isDark ? '1' : '0') + '; path=/; max-age=' + (60*60*24*30);
                applyTheme(isDark);
            });
        })();
    </script>

    <?php echo $__env->yieldContent('scripts'); ?>
</body>
</html>

<?php /**PATH C:\Users\CHANTHY.CHET\Desktop\Full Stack E-Commerce System\ecommerce-backend\resources\views/admin/layouts/admin.blade.php ENDPATH**/ ?>