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
      <form action="<?= base_url('dashboard/settings/locale') ?>" method="post">
        <?= csrf_field() ?>
        <?php $s = $settings ?? []; ?>
        <div class="mb-3">
          <label class="form-label">Timezone</label>
          <input type="text" name="timezone" class="form-control" value="<?= old('timezone', esc($s['timezone'] ?? 'UTC')) ?>">
        </div>
        <div class="mb-3">
          <label class="form-label">Language</label>
          <input type="text" name="language" class="form-control" value="<?= old('language', esc($s['language'] ?? 'en')) ?>">
        </div>
        <div class="mb-3">
          <label class="form-label">Date Format</label>
          <input type="text" name="date_format" class="form-control" value="<?= old('date_format', esc($s['date_format'] ?? 'Y-m-d')) ?>">
        </div>
        <div class="form-check mb-3">
          <input type="checkbox" name="maintenance" id="maintenance" class="form-check-input" <?= old('maintenance', $s['maintenance'] ?? false) ? 'checked' : '' ?>>
          <label class="form-check-label" for="maintenance">Enable Maintenance Mode</label>
        </div>
        <div class="text-end">
          <button type="submit" class="btn btn-primary">Save Locale Settings</button>
          <a href="<?= base_url('dashboard/settings') ?>" class="btn btn-secondary">Back</a>
        </div>
      </form>
    </div>
  </div>
</div>
<?= $this->endSection() ?>