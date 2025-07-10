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
<form action="<?= base_url('dashboard/developer/update/'.$dev['id']) ?>" method="post" enctype="multipart/form-data">
  <?= csrf_field() ?>

  <div class="mb-3">
    <label class="form-label">Name</label>
    <input type="text" name="name" class="form-control" 
           value="<?= old('name', esc($dev['name'])) ?>" required>
  </div>
  <div class="mb-3">
    <label class="form-label">Location</label>
    <input type="text" name="location" class="form-control" 
           value="<?= old('location', esc($dev['location'])) ?>">
  </div>
  <div class="mb-3">
    <label class="form-label">Logo <small>(leave blank to keep current)</small></label>
    <input type="file" name="logo" class="form-control" accept="image/*">
  </div>
  <button type="submit" class="btn btn-primary">Update</button>
  <a href="<?= base_url('dashboard/developer') ?>" class="btn btn-secondary">Cancel</a>
</form>
<hr class="my-4">

                    <h5>Existing Images</h5>
<div class="row">
    <?php if (!empty($dev['logo'])) : ?>
        <div class="col-3 mb-3">
            <img src="<?= base_url('uploads/developer/' . esc($dev['logo'])) ?>" 
                 class="img-thumbnail" style="width: 100%; height: auto;">
            <p class="text-muted mt-1 text-center">Logo Utama</p>
        </div>
    <?php endif ?>

    <?php if (!empty($images)) : ?>
        <?php foreach ($images as $img) : ?>
            <div class="col-3 mb-3">
                <img src="<?= base_url('uploads/developer/' . esc($img['filename'])) ?>" 
                     class="img-thumbnail" style="width: 100%; height: auto;">
                <a href="<?= base_url('dashboard/developer/deleteImage/' . $img['id']) ?>"
                   class="btn btn-danger btn-sm mt-2"
                   onclick="return confirm('Are you sure you want to delete this photo?')">
                    Delete
                </a>
            </div>
        <?php endforeach ?>
    <?php elseif (empty($dev['logo'])) : ?>
        <p class="text-muted">No images uploaded yet.</p>
    <?php endif ?>
</div>

<?= $this->endSection() ?>
