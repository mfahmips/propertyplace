<?= $this->extend('admin/layout/default') ?>
<?= $this->section('content') ?>

<?php if (session('validation')): ?>
  <div class="alert alert-danger">
    <?= session('validation')->listErrors() ?>
  </div>
<?php endif; ?>

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
    <div class="mt-2">
      <img src="<?= base_url('writable/uploads/developers/'.$dev['logo']) ?>"
           style="height:80px; object-fit:cover;">
    </div>
  </div>
  <button type="submit" class="btn btn-primary">Update</button>
  <a href="<?= base_url('dashboard/developer') ?>" class="btn btn-secondary">Cancel</a>
</form>

<?= $this->endSection() ?>
