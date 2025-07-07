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

<?php if (session('validation')): ?>
  <div class="alert alert-danger">
    <?= session('validation')->listErrors() ?>
  </div>
<?php endif; ?>

<div class="row row-cols-lg-2 gx-3">
        <div class="col">
            <div class="card">
                <div class="card-body">
<form action="<?= base_url('dashboard/property/developer/' . esc($developer['slug']) . '/edit/' . esc($property['slug'])) ?>"
      method="post" enctype="multipart/form-data">
  <?= csrf_field() ?>

  <!-- Developer (readonly) -->
  <div class="mb-3">
    <label class="form-label">Developer</label>
    <input type="text" class="form-control" value="<?= esc($developer['name']) ?>" disabled readonly>
  </div>

  <!-- Title -->
  <div class="mb-3">
    <label class="form-label">Title</label>
    <input type="text"
           name="title"
           class="form-control"
           value="<?= old('title', esc($property['title'])) ?>"
           required>
  </div>

  <!-- Location -->
  <div class="mb-3">
    <label class="form-label">Location</label>
    <input type="text"
           name="location"
           class="form-control"
           value="<?= old('location', esc($property['location'])) ?>"
           required>
  </div>

  <!-- Price -->
  <div class="mb-3">
    <label class="form-label">Price (IDR)</label>
    <input type="number"
           name="price"
           class="form-control"
           value="<?= old('price', esc($property['price'])) ?>"
           required>
  </div>

  <!-- Description -->
  <div class="mb-3">
    <label class="form-label">Description</label>
    <textarea name="description"
              class="form-control"
              rows="4"
              required><?= old('description', esc($property['description'])) ?></textarea>
  </div>

  <!-- Existing Images -->
  <div class="mb-3">
    <label class="form-label">Existing Images</label>
    <div class="d-flex flex-wrap gap-2">
      <?php if (! empty($property['images'])): ?>
        <?php foreach ($property['images'] as $img): ?>
          <img src="<?= esc($img) ?>" width="80" class="img-thumbnail">
        <?php endforeach ?>
      <?php else: ?>
        <p class="text-muted">No images yet.</p>
      <?php endif ?>
    </div>
  </div>

  <!-- Upload New Images -->
  <div class="mb-3">
    <label class="form-label">Add New Images (max 10)</label>
    <input type="file"
           name="images[]"
           multiple
           class="form-control"
           accept="image/*">
  </div>

  <div class="text-end">
    <button type="submit" class="btn btn-primary">Update Property</button>
    <a href="<?= base_url('dashboard/property/developer/' . esc($developer['slug'])) ?>"
       class="btn btn-secondary">Cancel</a>
  </div>
</form>

<?= $this->endSection() ?>
