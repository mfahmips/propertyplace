<!-- App Menu Start -->
<div class="app-sidebar">
    <!-- Sidebar Logo -->
    <div class="logo-box">
        <a href="<?= base_url('dashboard') ?>" class="logo-dark">
            <img src="<?= base_url('uploads/' . ($settings['site_logo'] ?? 'default-logo.png')) ?>" style="height:60px;" alt="logo dark">
        </a>
        <a href="<?= base_url('dashboard') ?>" class="logo-light">
            <img src="<?= base_url('uploads/' . ($settings['site_logo'] ?? 'default-logo.png')) ?>" style="height:60px;" alt="logo light">
        </a>
    </div>

    <div class="scrollbar" data-simplebar>
        <?php $role = session('role'); ?>
        <ul class="navbar-nav" id="navbar-nav">



            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('dashboard') ?>">
                    <span class="nav-icon">
                        <iconify-icon icon="solar:home-2-outline"></iconify-icon>
                    </span>
                    <span class="nav-text">Dashboard</span>
                </a>
            </li>

            <!-- Main Menu -->
            <li class="menu-title">Menu</li>

            

            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('dashboard/property') ?>">
                    <span class="nav-icon">
                        <iconify-icon icon="solar:home-smile-linear"></iconify-icon>
                    </span>
                    <span class="nav-text">Property</span>
                </a>
            </li>

            <?php if ($role === 'admin'): ?>

                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('dashboard/developer') ?>">
                        <span class="nav-icon">
                            <iconify-icon icon="solar:buildings-outline"></iconify-icon>
                        </span>
                        <span class="nav-text">Developer</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('dashboard/blog') ?>">
                        <span class="nav-icon">
                            <iconify-icon icon="solar:user-outline"></iconify-icon>
                        </span>
                        <span class="nav-text">Blog</span>
                    </a>
                </li>
                <!-- Admin Settings -->
                <li class="menu-title">Settings</li>

                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('dashboard/user') ?>">
                        <span class="nav-icon">
                            <iconify-icon icon="solar:user-outline"></iconify-icon>
                        </span>
                        <span class="nav-text">User</span>
                    </a>
                </li>


                

                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('dashboard/settings') ?>">
                        <span class="nav-icon">
                            <iconify-icon icon="solar:settings-outline"></iconify-icon>
                        </span>
                        <span class="nav-text">Settings</span>
                    </a>
                </li>
            <?php endif; ?>

        </ul>

        <!-- Footer Start -->
        <footer class="footer mt-auto">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 text-center small">
                        <script>document.write(new Date().getFullYear())</script> &copy; <?= esc($settings['site_name']) ?>
                    </div>
                </div>
            </div>
        </footer>
        <!-- Footer End -->

    </div>
</div>

<!-- Animated Stars -->
<div class="animated-stars">
    <?php for ($i = 0; $i < 20; $i++): ?>
        <div class="shooting-star"></div>
    <?php endfor; ?>
</div>
<!-- App Menu End -->
