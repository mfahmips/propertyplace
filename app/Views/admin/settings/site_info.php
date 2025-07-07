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
      <form action="<?= base_url('dashboard/settings/site-info') ?>" method="post">
        <?= csrf_field() ?>
        <?php $s = $settings ?? []; ?>
        <div class="mb-3">
          <label class="form-label">Site Name</label>
          <input type="text" name="site_name" class="form-control" value="<?= old('site_name', esc($s['site_name'] ?? '')) ?>" required>
          <?php if(session('validation') && session('validation')->hasError('site_name')): ?>
            <div class="text-danger small"><?= session('validation')->getError('site_name') ?></div>
          <?php endif ?>
        </div>
        <div class="mb-3">
          <label class="form-label">Tagline</label>
          <input type="text" name="tagline" class="form-control" value="<?= old('tagline', esc($s['tagline'] ?? '')) ?>">
        </div>
        <div class="mb-3">
          <label class="form-label">About</label>
          <textarea name="about" class="form-control" rows="4"><?= old('about', esc($s['about'] ?? '')) ?></textarea>
        </div>
        <div class="mb-3">
          <label class="form-label">Location</label>
          <input type="text" name="location" class="form-control" value="<?= old('location', esc($s['location'] ?? '')) ?>">
        </div>
        <div class="text-end">
          <button type="submit" class="btn btn-primary">Save Site Info</button>
          <a href="<?= base_url('dashboard/settings') ?>" class="btn btn-secondary">Back</a>
        </div>
      </form>
    </div>
  </div>
</div>
<?= $this->endSection() ?>