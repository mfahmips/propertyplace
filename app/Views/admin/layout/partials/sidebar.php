<!-- App Menu Start -->
<div class="app-sidebar">
    <!-- Sidebar Logo -->
    <div class="logo-box">
        <a href="<?= base_url('dashboard') ?>" class="logo-dark">
            <img src="<?= base_url('assets/admin/images/logo-sm.png') ?>" class="logo-sm" alt="logo sm">
            <img src="<?= base_url('assets/admin/images/logo-dark.png') ?>" class="logo-lg" alt="logo dark">
        </a>

        <a href="<?= base_url('dashboard') ?>" class="logo-light">
            <img src="<?= base_url('assets/admin/images/logo-sm.png') ?>" class="logo-sm" alt="logo sm">
            <img src="<?= base_url('assets/admin/images/logo-light.png') ?>" class="logo-lg" alt="logo light">
        </a>
    </div>

    <div class="scrollbar" data-simplebar>
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
                <a class="nav-link" href="<?= base_url('dashboard/property') ?>">
                    <span class="nav-icon">
                        <iconify-icon icon="mingcute:home-3-line"></iconify-icon>
                    </span>
                    <span class="nav-text"> Property </span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link menu-arrow" href="#sidebarError" data-bs-toggle="collapse" role="button"
                    aria-expanded="false" aria-controls="sidebarError">
                    <span class="nav-icon">
                        <iconify-icon icon="mingcute:bug-line"></iconify-icon>
                    </span>
                    <span class="nav-text"> Error Pages</span>
                </a>
                <div class="collapse" id="sidebarError">
                    <ul class="nav sub-navbar-nav">
                        <li class="sub-nav-item">
                            <a class="sub-nav-link" href="<?= base_url('pages/404') ?>">Pages 404</a>
                        </li>
                        <li class="sub-nav-item">
                            <a class="sub-nav-link" href="<?= base_url('pages/404-alt') ?>">Pages 404 Alt</a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="menu-title">UI Kit...</li>

            <li class="nav-item">
                <a class="nav-link menu-arrow" href="#sidebarBaseUI" data-bs-toggle="collapse" role="button"
                    aria-expanded="false" aria-controls="sidebarBaseUI">
                    <span class="nav-icon"><iconify-icon icon="mingcute:leaf-line"></iconify-icon></span>
                    <span class="nav-text"> Base UI </span>
                </a>
                <div class="collapse" id="sidebarBaseUI">
                    <ul class="nav sub-navbar-nav">
                        <li class="sub-nav-item">
                            <a class="sub-nav-link" href="<?= base_url('ui/accordion') ?>">Accordion</a>
                        </li>
                        <li class="sub-nav-item">
                            <a class="sub-nav-link" href="<?= base_url('ui/alerts') ?>">Alerts</a>
                        </li>
                        <li class="sub-nav-item">
                            <a class="sub-nav-link" href="<?= base_url('ui/avatar') ?>">Avatar</a>
                        </li>
                        <li class="sub-nav-item">
                            <a class="sub-nav-link" href="<?= base_url('ui/badge') ?>">Badge</a>
                        </li>
                        <!-- ... dan seterusnya untuk semua UI links -->
                    </ul>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('charts') ?>">
                    <span class="nav-icon">
                        <iconify-icon icon="mingcute:chart-bar-line"></iconify-icon>
                    </span>
                    <span class="nav-text"> Apex Charts </span>
                </a>
            </li>

            <!-- Tambahkan base_url ke semua href lainnya -->
            <!-- Sisanya bisa disesuaikan dengan base_url juga seperti di atas -->

        </ul>
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
