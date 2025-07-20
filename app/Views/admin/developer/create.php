<?= $this->extend('admin/layout/default') ?>
<?= $this->section('content') ?>

<?php if (session('validation')): ?>
  <div class="alert alert-danger">
    <?= session('validation')->listErrors() ?>
  </div>
<?php endif; ?>

<!-- Start Container Fluid -->
<div class="container-fluid">

    <!-- ========== Page Title Start ========== -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="mb-0"><?= $title ?></h4>
                <ol class="breadcrumb mb-0">
                    <?php foreach ($breadcrumb as $item) : ?>
                        <?php if (isset($item['url'])) : ?>
                            <li class="breadcrumb-item">
                                <a href="<?= $item['url'] ?>"><?= $item['label'] ?></a>
                            </li>
                        <?php else : ?>
                            <li class="breadcrumb-item active"><?= $item['label'] ?></li>
                        <?php endif ?>
                    <?php endforeach ?>
                </ol>
            </div>
        </div>
    </div>

    <div class="row row-cols-lg-2 gx-3">
        <div class="col">
            <div class="card">
                <div class="card-body">

<form action="<?= base_url('dashboard/developer/store') ?>" method="post" enctype="multipart/form-data">
  <?= csrf_field() ?>

  <div class="mb-3">
    <label class="form-label">Name</label>
    <input type="text" name="name" class="form-control" value="<?= old('name') ?>" required>
  </div>
  <div class="mb-3">
    <label class="form-label">Logo</label>
    <input type="file" name="logo" class="form-control" accept="image/*" required>
  </div>
  <button type="submit" class="btn btn-primary">Save</button>
  <a href="<?= base_url('dashboard/developer') ?>" class="btn btn-secondary">Kembali</a>
</form>

<?= $this->endSection() ?>
