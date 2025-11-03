<!-- App Sidebar -->
<div class="app-sidebar d-flex flex-column" style="height: 100vh; overflow: hidden;">
    
    <!-- Sidebar Logo -->
    <div class="logo-box text-center py-3">
        <a href="<?= base_url('/') ?>">
            <img 
              src="<?= base_url('uploads/' . ($settings['site_logo'] ?? 'default-logo.png')) ?>"
              alt="<?= esc($settings['site_name'] ?? 'PropertyPlace') ?>"
              class="glow-logo"
              style="max-height:60px;">
        </a>

        <style>
        .glow-logo {
          display: inline-block;
          border: none;
          border-radius: 0; /* pastikan tidak ada rounding yang memunculkan tepi */
          background: transparent; /* hapus latar apapun */
          transition: transform 0.4s ease, filter 0.4s ease, box-shadow 0.4s ease;
          animation: logoGlow 3s infinite ease-in-out;
          filter: drop-shadow(0 0 15px rgba(196, 85, 46, 0.4)); /* gunakan drop-shadow, bukan box-shadow */
        }

        /* Hover: lebih terang tanpa lingkaran tepi */
        .glow-logo:hover {
          transform: scale(1.07);
          filter: drop-shadow(0 0 25px rgba(196, 85, 46, 0.7)) brightness(1.1);
        }

        /* Animasi glow lembut */
        @keyframes logoGlow {
          0% {
            filter: drop-shadow(0 0 10px rgba(196, 85, 46, 0.2));
          }
          50% {
            filter: drop-shadow(0 0 25px rgba(196, 85, 46, 0.5));
          }
          100% {
            filter: drop-shadow(0 0 10px rgba(196, 85, 46, 0.2));
          }
        }

        </style>

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

                            <li class="sub-nav-item">
                                <a class="sub-nav-link" href="<?= base_url('dashboard/SalesActivity/bookings') ?>">
                                    <iconify-icon icon="fa-solid:coins" class="me-1"></iconify-icon>
                                    Booking Unit
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


<!-- Footer Start -->
<footer class="footer py-2 mt-auto" style="font-size: 0.8rem; background: transparent; position: relative; top: -5px;">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12 text-center text-muted">
        Copyright &copy; <script>document.write(new Date().getFullYear())</script> <?= esc($settings['site_name'] ?? 'PropertyPlace') ?> All rights reserved
      </div>
    </div>
  </div>
</footer>
<!-- Footer End -->
<style>
    .footer:hover {
  color: #adb5bd !important;
  transition: color 0.3s ease;
}

</style>
</div>
