<!-- App Sidebar -->
<div class="app-sidebar d-flex flex-column" style="height: 100vh; overflow: hidden;">
    
    <!-- Sidebar Logo -->
    <div class="logo-box text-center py-3">
        <a href="<?= base_url('dashboard') ?>" class="d-block">
            <img src="<?= base_url('uploads/' . ($settings['site_logo'] ?? 'default-logo.png')) ?>"
                alt="Logo"
                class="logo-lg"
                style="height: 48px; object-fit: contain;"
                onerror="this.onerror=null;this.src='<?= base_url('uploads/default-logo.png') ?>';">
        </a>
    </div>

    <!-- Sidebar Scrollable Menu -->
    <div class="scrollbar flex-grow-1 overflow-auto" data-simplebar>
        <?php $role = session('role'); ?>
        <ul class="navbar-nav" id="navbar-nav">
            
            <!-- Dashboard -->
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('dashboard') ?>">
                    <span class="nav-icon"><i class="fa-solid fa-grip"></i></span>
                    <span class="nav-text">Dashboard</span>
                </a>
            </li>

            <!-- Main Menu -->
            <li class="menu-title">Menu</li>

            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('dashboard/property') ?>">
                    <span class="nav-icon"><i class="fa-solid fa-house-circle-check"></i></span>
                    <span class="nav-text">Property</span>
                </a>
            </li>

            <?php if ($role === 'admin'): ?>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('dashboard/developer') ?>">
                        <span class="nav-icon"><i class="fa-solid fa-building-circle-check"></i></span>
                        <span class="nav-text">Developer</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('dashboard/blog') ?>">
                        <span class="nav-icon"><i class="fa-solid fa-newspaper"></i></span>
                        <span class="nav-text">Blog</span>
                    </a>
                </li>
            <?php endif; ?>

            <?php if (in_array($role, ['sales', 'admin'])): ?>
                <!-- Admin Settings -->
                <li class="menu-title">Administrasi Sales</li>

                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('dashboard/KPRCalculator') ?>">
                        <span class="nav-icon"><i class="fa-solid fa-calculator"></i></span>
                        <span class="nav-text">Kalkulator KPR</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-arrow" href="#sidebarSalesActivity" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="sidebarSalesActivity">
                        <span class="nav-icon">
                            <iconify-icon icon="mdi:briefcase-outline"></iconify-icon>
                        </span>
                        <span class="nav-text">Sales Activity</span>
                    </a>
                    <div class="collapse" id="sidebarSalesActivity">
                        <ul class="nav sub-navbar-nav">

                            <li class="sub-nav-item">
                                <a class="sub-nav-link" href="<?= base_url('dashboard/SalesActivity/absensi') ?>">
                                    <iconify-icon icon="fa-solid:clock" class="me-1"></iconify-icon>
                                    Absensi
                                </a>
                            </li>

                            <li class="sub-nav-item">
                                <a class="sub-nav-link" href="<?= base_url('dashboard/SalesActivity/komisi') ?>">
                                    <iconify-icon icon="fa-solid:coins" class="me-1"></iconify-icon>
                                    Komisi
                                </a>
                            </li>
                            <?php if ($role === 'admin'): ?>
                            <li class="sub-nav-item">
                                <a class="sub-nav-link" href="<?= base_url('dashboard/SalesActivity/pameran') ?>">
                                    <iconify-icon icon="fa-solid:landmark" class="me-1"></iconify-icon>
                                    Pameran
                                </a>
                            </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </li>


            <?php endif; ?>

            <?php if ($role === 'admin'): ?>
                <!-- Admin Settings -->
                <li class="menu-title">Settings</li>

                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('dashboard/user') ?>">
                        <span class="nav-icon"><i class="fa-solid fa-users"></i></span>
                        <span class="nav-text">User</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('dashboard/settings') ?>">
                        <span class="nav-icon"><i class="fa-solid fa-gears"></i></span>
                        <span class="nav-text">Settings</span>
                    </a>
                </li>
            <?php endif; ?>

        </ul>
    </div>
</div>
