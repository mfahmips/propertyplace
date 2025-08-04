


<!-- START Wrapper -->
<div class="app-wrapper">

    <!-- Topbar Start -->
    <header class="app-topbar">
        <div class="container-fluid">
            <div class="navbar-header">
                <div class="d-flex align-items-center gap-2">
                
                <!-- Menu Toggle Button -->
                <div class="topbar-item d-md-none">
                    <button type="button" class="button-toggle-menu topbar-button">
                        <iconify-icon icon="solar:hamburger-menu-outline" class="fs-24 align-middle"></iconify-icon>
                    </button>
                </div>

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
                            // Ambil data dari session
                            $gender = strtolower(trim(session('gender') ?? ''));
                            $fotoDB = trim(session('foto') ?? ''); // ambil nama file foto dari database (session)

                            // Cek apakah foto dari database tersedia
                            if (!empty($fotoDB) && file_exists(FCPATH . 'uploads/user/' . $fotoDB)) {
                                $foto = $fotoDB;
                            } else {
                                // Default berdasarkan gender
                                if ($gender === 'perempuan') {
                                    $foto = 'Perempuan.jpg';
                                } else {
                                    $foto = 'Laki-laki.jpg';
                                }
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
                            <h5 class="dropdown-header">
                                Halo, <?= esc(session('name')) ?>!
                            </h5>
                            <div class="dropdown-divider my-1"></div>
                            <a class="dropdown-item" href="<?= base_url('dashboard/profile/' . session('slug')) ?>">
                                <iconify-icon icon="solar:user-outline" class="align-middle me-2 fs-18"></iconify-icon>
                                <span class="align-middle">Profil Saya</span>
                            </a>

                            

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
