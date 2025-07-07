<!-- App Menu Start -->
<div class="app-sidebar">
    <!-- Sidebar Logo -->
    <div class="logo-box">
        <a href="<?= base_url('dashboard') ?>" class="logo-dark">
            <img src="<?= base_url('uploads/' . ($settings['site_logo'] ?? 'default-logo.png')) ?>" style="height:60px;" alt="logo sm">
        </a>

        <a href="<?= base_url('dashboard') ?>" class="logo-light">
            <img src="<?= base_url('uploads/' . ($settings['site_logo'] ?? 'default-logo.png')) ?>" style="height:60px;" alt="logo sm">
        </a>
    </div>

    <div class="scrollbar" data-simplebar>
        <?php $role = session('role'); ?>
        <ul class="navbar-nav" id="navbar-nav">

            <li class="menu-title">Menu...</li>
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('dashboard') ?>">
                    <span class="nav-icon">
                        <iconify-icon icon="mingcute:home-3-line"></iconify-icon>
                    </span>
                    <span class="nav-text"> Dashboard </span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('dashboard/developer') ?>">
                    <span class="nav-icon">
                        <iconify-icon icon="mingcute:home-3-line"></iconify-icon>
                    </span>
                    <span class="nav-text"> Property </span>
                </a>
            </li>

            <?php if ($role === 'admin'): ?>


            <li class="menu-title">Settings...</li>

            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('dashboard/user') ?>">
                    <span class="nav-icon">
                        <iconify-icon icon="mingcute:home-3-line"></iconify-icon>
                    </span>
                    <span class="nav-text"> User </span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('dashboard/settings') ?>">
                    <span class="nav-icon">
                        <iconify-icon icon="mingcute:chart-bar-line"></iconify-icon>
                    </span>
                    <span class="nav-text"> Settings </span>
                </a>
            </li>

            <?php endif ?>

            <!-- Tambahkan base_url ke semua href lainnya -->
            <!-- Sisanya bisa disesuaikan dengan base_url juga seperti di atas -->

        </ul>

        <!-- Footer Start -->
<footer class="footer">
   <div class="container-fluid">
       <div class="row">
           <div class="col-12 text-center">
               <script>document.write(new Date().getFullYear())</script> &copy; <?= esc($settings['site_name']) ?></a>
           </div>
       </div>
   </div>
</footer>
<!-- Footer End -->
    </div>
</div>



<div class="animated-stars">
    <div class="shooting-star"></div>
    <div class="shooting-star"></div>
    <div class="shooting-star"></div>
    <div class="shooting-star"></div>
    <div class="shooting-star"></div>
    <div class="shooting-star"></div>
    <div class="shooting-star"></div>
    <div class="shooting-star"></div>
    <div class="shooting-star"></div>
    <div class="shooting-star"></div>
    <div class="shooting-star"></div>
    <div class="shooting-star"></div>
    <div class="shooting-star"></div>
    <div class="shooting-star"></div>
    <div class="shooting-star"></div>
    <div class="shooting-star"></div>
    <div class="shooting-star"></div>
    <div class="shooting-star"></div>
    <div class="shooting-star"></div>
    <div class="shooting-star"></div>
</div>
<!-- App Menu End -->
