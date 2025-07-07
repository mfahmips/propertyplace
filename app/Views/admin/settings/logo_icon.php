<?= $this->extend('admin/layout/default') ?>
<?= $this->section('content') ?>
<div class="container-fluid">
  <div class="page-title-box">
    <h4 class="mb-0">Website Settings</h4>
    <ol class="breadcrumb mb-0">
      <?php foreach ($breadcrumb as $item): ?>
        <?php if (isset($item['url'])): ?>
          <li class="breadcrumb-item"><a href="<?= esc($item['url']) ?>"><?= esc($item['label']) ?></a></li>
        <?php else: ?>
          <li class="breadcrumb-item active"><?= esc($item['label']) ?></li>
        <?php endif ?>
      <?php endforeach ?>
    </ol>
  </div>
  <div class="row row-cols-lg-2 gx-3">
                         <div class="col">
                              <div class="card">
                                   <div class="card-header">
                                        <h5 class="card-title mb-0"><?= esc($title) ?></h5>
                                   </div>
    <div class="card-body">
      <form action="<?= base_url('dashboard/settings/logo-icon') ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>
        <?php $s = $settings ?? []; ?>
        <div class="mb-3">
          <label class="form-label">Site Logo</label>
          <input type="file" name="site_logo" class="form-control" accept="image/*" onchange="previewImage(this,'logoPreview')">
          <img id="logoPreview" src="<?= base_url('uploads/'.($s['site_logo'] ?? 'placeholder.png')) ?>" class="img-thumbnail mt-2" style="max-width:100px;">
        </div>
        <div class="mb-3">
          <label class="form-label">Site Icon</label>
          <input type="file" name="site_icon" class="form-control" accept="image/*" onchange="previewImage(this,'iconPreview')">
          <img id="iconPreview" src="<?= base_url('uploads/'.($s['site_icon'] ?? 'placeholder.png')) ?>" class="img-thumbnail mt-2" style="max-width:50px;">
        </div>
        <div class="text-end">
          <button type="submit" class="btn btn-primary">Save Logo & Icon</button>
          <a href="<?= base_url('dashboard/settings') ?>" class="btn btn-secondary">Back</a>
        </div>
      </form>
    </div>
  </div>
</div>
<?= $this->endSection() ?>