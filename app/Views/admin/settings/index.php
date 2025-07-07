<?= $this->extend('admin/layout/default') ?>
<?= $this->section('content') ?>

<div class="container-fluid">
  <div class="page-title-box">
    <h4 class="mb-0"><?= esc($title) ?></h4>
    <ol class="breadcrumb mb-0">
      <?php foreach ($breadcrumb as $item): ?>
        <?php if (isset($item['url'])): ?>
          <li class="breadcrumb-item">
            <a href="<?= esc($item['url']) ?>"><?= esc($item['label']) ?></a>
          </li>
        <?php else: ?>
          <li class="breadcrumb-item active"><?= esc($item['label']) ?></li>
        <?php endif ?>
      <?php endforeach ?>
    </ol>
  </div>

  <div class="card">
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-striped table-borderless table-centered">
          <thead class="table-light">
            <tr>
              <th>Bagian</th>
              <th>Tambah atau Edit</th>
              <th>Aksi</th>
              <th>Hasil</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>Site Info</td>
              <td>Nama website, tagline, about, lokasi</td>
              <td>
                <a href="<?= base_url('dashboard/settings/site-info') ?>" class="btn btn-sm btn-primary">Edit</a>
              </td>
              <td>
                <button type="button" class="btn btn-sm btn-info me-1" data-bs-toggle="modal" data-bs-target="#settingsModal">
                  View
                </button>
              </td>
            </tr>
            <tr>
              <td>Contact &amp; Social</td>
              <td>Telepon, Instagram, TikTok</td>
              <td>
                <a href="<?= base_url('dashboard/settings/contact-social') ?>" class="btn btn-sm btn-primary">Edit</a>
              </td>
            </tr>
            <tr>
              <td>Logo &amp; Icon</td>
              <td>Logo dan favicon</td>
              <td>
                <a href="<?= base_url('dashboard/settings/logo-icon') ?>" class="btn btn-sm btn-primary">Edit</a>
              </td>
            </tr>
            <tr>
              <td>Locale Settings</td>
              <td>Zona waktu, bahasa, format tanggal</td>
              <td>
                <a href="<?= base_url('dashboard/settings/locale') ?>" class="btn btn-sm btn-primary">Edit</a>
              </td>
            </tr>
            <tr>
              <td>Maintenance</td>
              <td>Status mode pemeliharaan</td>
              <td>
                <a href="<?= base_url('dashboard/settings/maintenance') ?>" class="btn btn-sm btn-primary">Edit</a>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- Modal -->
  <div class="modal fade" id="settingsModal" tabindex="-1" aria-labelledby="settingsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="settingsModalLabel">Current Settings</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="table-responsive">
            <table class="table table-bordered">
              <tbody>
                <?php foreach ((array) ($settings ?? []) as $key => $value): ?>
                  <tr>
                    <th><?= esc(ucwords(str_replace('_', ' ', $key))) ?></th>
                    <td>
                      <?php if (in_array($key, ['site_logo', 'site_icon']) && $value): ?>
                        <img src="<?= base_url('uploads/' . $value) ?>" alt="<?= esc($key) ?>" style="max-height:50px;">
                      <?php else: ?>
                        <?= esc($value) ?>
                      <?php endif ?>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?= $this->endSection() ?>
