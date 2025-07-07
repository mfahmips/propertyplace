<?= $this->extend('admin/layout/default') ?>
<?= $this->section('content') ?>
<div class="container-fluid text-center">
  <div class="page-title-box">
    <h4 class="mb-0"><?= esc($title) ?></h4>
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
  <div class="card mx-auto mt-4 p-4" style="max-width:400px;">
    <h5>Status Maintenance</h5>
    <form action="<?= base_url('dashboard/settings/maintenance') ?>" method="post">
      <?= csrf_field() ?>
      <?php $s = $settings ?? []; ?>
      <div class="form-check mb-3">
        <input class="form-check-input" type="checkbox" id="maintenanceCheckbox" name="maintenance" <?= old('maintenance', $s['maintenance'] ?? false) ? 'checked' : '' ?>>
        <label class="form-check-label" for="maintenanceCheckbox">Enable Maintenance Mode</label>
      </div>
      <div class="text-end">
        <button type="submit" class="btn btn-primary">Save Maintenance</button>
        <a href="<?= base_url('dashboard/settings') ?>" class="btn btn-secondary">Back</a>
      </div>
    </form>
  </div>
</div>
<?= $this->endSection() ?>