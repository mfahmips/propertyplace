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
        <!-- Total Property -->
        <div class="col-md-6 col-xl-3">
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

        <!-- Total User Role Karyawan -->
        <div class="col-md-6 col-xl-3">
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

        <!-- Total Penjualan -->
        <div class="col-md-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-8">
                            <p class="text-muted mb-0">Total Penjualan</p>
                            <h3 class="text-dark mt-2 mb-0"><?= number_to_currency($totalPenjualan, 'IDR', 'id_ID') ?></h3>
                        </div>
                        <div class="col-4 text-end">
                            <div class="avatar-md bg-soft-primary rounded">
                                <iconify-icon icon="solar:bag-5-outline" class="fs-32 avatar-title text-primary"></iconify-icon>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Customer -->
        <div class="col-md-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-8">
                            <p class="text-muted mb-0">Total Customer</p>
                            <h3 class="text-dark mt-2 mb-0"><?= esc($totalCustomer) ?></h3>
                        </div>
                        <div class="col-4 text-end">
                            <div class="avatar-md bg-soft-primary rounded">
                                <iconify-icon icon="solar:users-group-rounded-outline" class="fs-32 avatar-title text-primary"></iconify-icon>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- end row -->

</div>
<!-- End Container Fluid -->

<?= $this->endSection() ?>
