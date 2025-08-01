


<!-- START Wrapper -->
<div class="app-wrapper">

    <!-- Topbar Start -->
    <header class="app-topbar">
        <div class="container-fluid">
            <div class="navbar-header">
                <div class="d-flex align-items-center gap-2">
                    <!-- Menu Toggle Button -->
                    <div class="topbar-item">
                        <button type="button" class="button-toggle-menu topbar-button">
                            <iconify-icon icon="solar:hamburger-menu-outline"
                                class="fs-24 align-middle"></iconify-icon>
                        </button>
                    </div>

                    <!-- App Search-->
                    <form class="app-search d-none d-md-block me-auto">
                        <div class="position-relative">
                            <input type="search" class="form-control" placeholder="cari apa saja..."
                                autocomplete="off" value="">
                            <iconify-icon icon="solar:magnifer-outline" class="search-widget-icon"></iconify-icon>
                        </div>
                    </form>
                </div>

                <div class="d-flex align-items-center gap-2">
                    <!-- Theme Color (Light/Dark) -->
                    <div class="topbar-item">
                        <button type="button" class="topbar-button" id="light-dark-mode">
                            <iconify-icon icon="solar:moon-outline"
                                class="fs-22 align-middle light-mode"></iconify-icon>
                            <iconify-icon icon="solar:sun-2-outline"
                                class="fs-22 align-middle dark-mode"></iconify-icon>
                        </button>
                    </div>

                    <!-- User Dropdown -->
                    <div class="dropdown topbar-item">
                        <a type="button" class="topbar-button" id="page-header-user-dropdown"
                           data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                            <?php
                            // Ambil gender dari session
                            $gender = strtolower(trim(session('gender') ?? ''));

                            // Tentukan nama foto berdasarkan gender
                            if ($gender === 'laki-laki') {
                                $foto = 'Laki-laki.jpg';
                            } elseif ($gender === 'perempuan') {
                                $foto = 'Perempuan.jpg';
                            } else {
                                $foto = 'Laki-laki.jpg'; // fallback jika gender tidak dikenali
                            }

                            // Buat URL gambar
                            $avatarUrl = base_url('uploads/user/' . $foto);
                            ?>

                            <span class="d-flex align-items-center">
                                <img src="<?= $avatarUrl ?>" alt="User Avatar"
                                     width="32" height="32"
                                     class="rounded-circle border"
                                     style="object-fit: cover;"
                                     onerror="this.onerror=null;this.src='<?= base_url('uploads/user/Laki-laki.jpg') ?>';">
                            </span>

                        </a>


                        <div class="dropdown-menu dropdown-menu-end">
                            <h6 class="dropdown-header">
                                Halo, <?= esc(session('name')) ?>!
                            </h6>

                            <a class="dropdown-item" href="<?= base_url('dashboard/user/profile/' . session('slug')) ?>">
                                <iconify-icon icon="solar:user-outline" class="align-middle me-2 fs-18"></iconify-icon>
                                <span class="align-middle">Profil Saya</span>
                            </a>


                            <div class="dropdown-divider my-1"></div>

                            <a class="dropdown-item text-danger" href="<?= site_url('logout') ?>">
                                <iconify-icon icon="solar:logout-3-outline" class="align-middle me-2 fs-18"></iconify-icon>
                                <span class="align-middle">Keluar</span>
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </header>
    <!-- Topbar End -->
