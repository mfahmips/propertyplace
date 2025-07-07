<?= $this->extend('admin/layout/default') ?>
<?= $this->section('content') ?>

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


<?php if(isset($errors)): ?>
  <div class="alert alert-danger">
    <?php foreach($errors as $err): ?>
      <p class="mb-0"><?= esc($err) ?></p>
    <?php endforeach ?>
  </div>
<?php endif ?>

<div class="row row-cols-lg-2 gx-3">
        <div class="col">
            <div class="card">
                <div class="card-body">
<form action="<?= base_url('dashboard/property/developer/'.$developer['slug'].'/store') ?>"
      method="post" enctype="multipart/form-data">
  <?= csrf_field() ?>

  <!-- Tampilkan developer (readonly) -->
  <div class="mb-3">
    <label class="form-label">Developer</label>
    <input type="text" class="form-control" 
           value="<?= esc($developer['name']) ?>" disabled readonly>
  </div>

  <!-- Title -->
  <div class="mb-3">
    <label class="form-label">Title</label>
    <input type="text" name="title" class="form-control" 
           value="<?= old('title') ?>" required>
  </div>

  <!-- Location -->
  <div class="mb-3">
    <label class="form-label">Location</label>
    <input type="text" name="location" class="form-control" 
           value="<?= old('location') ?>" required>
  </div>

  <!-- Price -->
  <div class="mb-3">
    <label class="form-label">Price (IDR)</label>
    <input type="number" name="price" class="form-control" 
           value="<?= old('price') ?>" required>
  </div>

  <!-- Description -->
  <div class="mb-3">
    <label class="form-label">Description</label>
    <textarea name="description" rows="4" class="form-control" required><?= old('description') ?></textarea>
  </div>

  <!-- Images -->
  <div class="mb-3">
    <label class="form-label">Images (max 10)</label>
    <input type="file" name="images[]" multiple class="form-control" accept="image/*">
  </div>

  <div class="text-end">
    <button type="submit" class="btn btn-primary">Save Property</button>
    <a href="<?= base_url('dashboard/property/developer/'.$developer['slug']) ?>" class="btn btn-secondary">Cancel</a>
  </div>
</form>

<?= $this->endSection() ?>
