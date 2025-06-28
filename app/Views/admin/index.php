<?= $this->extend('admin/layout/default') ?>

<?= $this->section('breadcrumb') ?>
    <?= view('admin/layout/default', [
        'title' => $title,
        'breadcrumb' => $breadcrumb
    ]) ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <!-- Start Container Fluid -->
            <div class="container-fluid">

                <!-- ========== Page Title Start ========== -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box">
                            <h4 class="mb-0">Dashboard</h4>
                        </div>
                    </div>
                </div>
                <!-- ========== Page Title End ========== -->


                <div class="row">
                    <!-- Card 1 -->
                    <div class="col-md-6 col-xl-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-6">
                                        <p class="text-muted mb-0 text-truncate">Total Income</p>
                                        <h3 class="text-dark mt-2 mb-0">$78.8k</h3>
                                    </div>

                                    <div class="col-6">
                                        <div class="ms-auto avatar-md bg-soft-primary rounded">
                                            <iconify-icon icon="solar:globus-outline"
                                                class="fs-32 avatar-title text-primary"></iconify-icon>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="chart01"></div>
                        </div>
                    </div>

                    <!-- Card 2 -->
                    <div class="col-md-6 col-xl-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-6">
                                        <p class="text-muted mb-0 text-truncate">New Users</p>
                                        <h3 class="text-dark mt-2 mb-0">2,150</h3>
                                    </div>

                                    <div class="col-6">
                                        <div class="ms-auto avatar-md bg-soft-primary rounded">
                                            <iconify-icon icon="solar:users-group-two-rounded-broken"
                                                class="fs-32 avatar-title text-primary"></iconify-icon>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="chart02"></div>
                        </div>
                    </div>

                    <!-- Card 3 -->
                    <div class="col-md-6 col-xl-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-6">
                                        <p class="text-muted mb-0 text-truncate">Orders</p>
                                        <h3 class="text-dark mt-2 mb-0">1,784</h3>
                                    </div>

                                    <div class="col-6">
                                        <div class="ms-auto avatar-md bg-soft-primary rounded">
                                            <iconify-icon icon="solar:cart-5-broken"
                                                class="fs-32 avatar-title text-primary"></iconify-icon>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="chart03"></div>
                        </div>
                    </div>

                    <!-- Card 4 -->
                    <div class="col-md-6 col-xl-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-6">
                                        <p class="text-muted mb-0 text-truncate">Conversion Rate</p>
                                        <h3 class="text-dark mt-2 mb-0">12.3%</h3>
                                    </div>

                                    <div class="col-6">
                                        <div class="ms-auto avatar-md bg-soft-primary rounded">
                                            <iconify-icon icon="solar:pie-chart-2-broken"
                                                class="fs-32 avatar-title text-primary"></iconify-icon>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="chart04"></div>
                        </div>
                    </div>
                </div>
                <!-- end card-->
            </div>
            <!-- end col -->
        </div>
        <!-- end row -->

    </div>
    <!-- End Container Fluid -->
<?= $this->endSection() ?>
