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
      <form action="<?= base_url('dashboard/settings/contact-social') ?>" method="post">
        <?= csrf_field() ?>
        <?php $s = $settings ?? []; ?>
        <div class="mb-3">
          <label class="form-label">Phone</label>
          <input type="text" name="phone" class="form-control" value="<?= old('phone', esc($s['phone'] ?? '')) ?>">
        </div>
        <div class="mb-3">
          <label class="form-label">Instagram</label>
          <input type="text" name="instagram" class="form-control" value="<?= old('instagram', esc($s['instagram'] ?? '')) ?>">
        </div>
        <div class="mb-3">
          <label class="form-label">TikTok</label>
          <input type="text" name="tiktok" class="form-control" value="<?= old('tiktok', esc($s['tiktok'] ?? '')) ?>">
        </div>
        <div class="text-end">
          <button type="submit" class="btn btn-primary">Save Contact & Social</button>
          <a href="<?= base_url('dashboard/settings') ?>" class="btn btn-secondary">Back</a>
        </div>
      </form>
    </div>
  </div>
</div>
<?= $this->endSection() ?>