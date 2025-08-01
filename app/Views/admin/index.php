<?= $this->extend('admin/layout/default') ?>

<?= $this->section('content') ?>

<!-- Start Container Fluid -->
<div class="container-fluid">


    <!-- Welcome Section -->
    <div class="row">
        <div class="col-12 mb-4">
            <h2 class="text-white">Selamat Datang, <?= esc($username) ?>!</h2>
            <p class="text-muted mb-0">
                Hari ini : <?= tanggal_indo(date('Y-m-d')) ?>
            </p>
        </div>
    </div>

    <div class="row">

<?php if (in_array(session('role'), ['admin', 'managemen'])): ?>

    <!-- Total Developer -->
    <div class="col-md-6 col-xl-4">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-8">
                        <p class="text-muted mb-0">Total Developer</p>
                        <h3 class="text-dark mt-2 mb-0"><?= esc($totalDeveloper) ?></h3>
                    </div>
                    <div class="col-4 text-end">
                        <div class="avatar-md bg-soft-primary rounded">
                            <iconify-icon icon="solar:home-2-outline" class="fs-32 avatar-title text-primary"></iconify-icon>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Property -->
    <div class="col-md-6 col-xl-4">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-8">
                        <p class="text-muted mb-0">Total Properti</p>
                        <h3 class="text-dark mt-2 mb-0"><?= esc($totalProperty) ?></h3>
                    </div>
                    <div class="col-4 text-end">
                        <div class="avatar-md bg-soft-primary rounded">
                            <iconify-icon icon="solar:buildings-outline" class="fs-32 avatar-title text-primary"></iconify-icon>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Total User -->
    <div class="col-md-6 col-xl-4">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-8">
                        <p class="text-muted mb-0">Total User</p>
                        <h3 class="text-dark mt-2 mb-0"><?= esc($totalUser) ?></h3>
                    </div>
                    <div class="col-4 text-end">
                        <div class="avatar-md bg-soft-primary rounded">
                            <iconify-icon icon="solar:user-outline" class="fs-32 avatar-title text-primary"></iconify-icon>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php elseif (session('role') === 'sales'): ?>

    <!-- Absen Masuk -->
    <div class="col-md-6 col-xl-4">
        <div class="card">
            <a href="#" class="text-decoration-none text-dark" data-bs-toggle="modal" data-bs-target="#modalAbsenMasuk">
                <div class="card-body text-center">
                    <iconify-icon icon="solar:login-3-outline" class="fs-40 text-success"></iconify-icon>
                    <h5 class="mt-2">Absen Masuk</h5>
                </div>
            </a>
        </div>
    </div>

    <!-- Modal Absen Masuk -->
    <div class="modal fade" id="modalAbsenMasuk" tabindex="-1" aria-labelledby="modalAbsenMasukLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form action="<?= base_url('dashboard/absensi/masuk') ?>" method="post" class="modal-content">
                <?= csrf_field() ?>
                <div class="modal-header">
                    <h5 class="modal-title" id="modalAbsenMasukLabel">Form Absen Masuk</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="lokasi_pameran" class="form-label">Lokasi Pameran</label>
                        <input type="text" name="lokasi_pameran" class="form-control" id="lokasi_pameran" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success w-100">Absen Sekarang</button>
                </div>
            </form>
        </div>
    </div>


    <!-- Absen Pulang -->
    <div class="col-md-6 col-xl-4">
        <div class="card">
            <a href="#" class="text-decoration-none text-dark" data-bs-toggle="modal" data-bs-target="#modalAbsenPulang">
                <div class="card-body text-center">
                    <iconify-icon icon="solar:logout-3-outline" class="fs-40 text-warning"></iconify-icon>
                    <h5 class="mt-2">Absen Pulang</h5>
                </div>
            </a>
        </div>
    </div>

    <!-- Modal Absen Pulang -->
    <div class="modal fade" id="modalAbsenPulang" tabindex="-1" aria-labelledby="modalAbsenPulangLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form action="<?= base_url('absensi/pulang') ?>" method="post" class="modal-content">
                <?= csrf_field() ?>
                <div class="modal-header">
                    <h5 class="modal-title" id="modalAbsenPulangLabel">Form Absen Pulang</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="database_pameran" class="form-label">Jumlah Database Pameran</label>
                        <input type="number" name="database_pameran" id="database_pameran" class="form-control" min="0" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-warning w-100">Simpan dan Pulang</button>
                </div>
            </form>
        </div>
    </div>


    <!-- History Absen -->
    <div class="col-md-6 col-xl-4">
        <div class="card">
            <a href="<?= base_url('absensi/history') ?>" class="text-decoration-none text-dark">
                <div class="card-body text-center">
                    <iconify-icon icon="solar:calendar-linear" class="fs-40 text-info"></iconify-icon>
                    <h5 class="mt-2">Riwayat Absen</h5>
                </div>
            </a>
        </div>
    </div>

<?php endif; ?>

</div>
<!-- end row -->



</div>
<!-- End Container Fluid -->

<?php if (!empty($profileIncomplete)) : ?>
<!-- Modal Lengkapi Profil -->
<div class="modal fade" id="profileReminderModal" tabindex="-1"
      aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="profileReminderTitle">Profil Anda Belum Lengkap</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Tutup"></button>
      </div>
      <div class="modal-body">
        <p>Mohon lengkapi profil terlebih dahulu untuk menggunakan sistem secara optimal.</p>
      </div>
      <div class="modal-footer">
        <a href="<?= base_url('dashboard/user/profile/' . session('slug')) ?>" class="btn btn-light w-100">Lengkapi Profil</a>
      </div>
    </div>
  </div>
</div>

<!-- Show modal on page load -->
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const modal = new bootstrap.Modal(document.getElementById('profileReminderModal'));
    modal.show();
  });
</script>
<?php endif; ?>



<?php if (session()->getFlashdata('absen_masuk_success')): ?>
<!-- Toast Notification Centered -->
<div class="position-fixed top-50 start-50 translate-middle p-3" style="z-index: 1060;">
    <div id="absenToast" class="toast align-items-center text-white bg-success border-0 shadow-lg"
         role="alert" aria-live="assertive" aria-atomic="true"
         data-bs-delay="5000" data-bs-autohide="true">
        <div class="d-flex">
            <div class="toast-body fs-5">
                💪 Selamat bertugas, tetap semangat, yakin closing!!!
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>
<?php endif; ?>


<script>
  document.addEventListener('DOMContentLoaded', function () {
    var toastEl = document.getElementById('absenToast');
    if (toastEl) {
        var toast = new bootstrap.Toast(toastEl);
        toast.show();
    }
  });
</script>




<?= $this->endSection() ?>
