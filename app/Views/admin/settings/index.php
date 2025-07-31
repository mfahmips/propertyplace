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
              <td>
                <button type="button" class="btn btn-sm btn-info me-1" data-bs-toggle="modal" data-bs-target="#contactSocialModal">
                  View
                </button>
              </td>
            </tr>
            <tr>
              <td>Logo &amp; Icon</td>
              <td>Logo dan favicon</td>
              <td>
                <a href="<?= base_url('dashboard/settings/logo-icon') ?>" class="btn btn-sm btn-primary">Edit</a>
              </td>
              <td>
                <button type="button" class="btn btn-sm btn-info me-1" data-bs-toggle="modal" data-bs-target="#logoIconModal">
                  View
                </button>
              </td>
            </tr>
            <tr>
              <td>Locale Settings</td>
              <td>Zona waktu, bahasa, format tanggal</td>
              <td>
                <a href="<?= base_url('dashboard/settings/locale') ?>" class="btn btn-sm btn-primary">Edit</a>
              </td>
              <td>
                <button type="button" class="btn btn-sm btn-info me-1" data-bs-toggle="modal" data-bs-target="#localeModal">
                  View
                </button>
              </td>
            </tr>
            <tr>
              <td>Maintenance</td>
              <td>Status mode pemeliharaan</td>
              <td>
                <a href="<?= base_url('dashboard/settings/maintenance') ?>" class="btn btn-sm btn-primary">Edit</a>
              </td>
              <td>
                <button type="button" class="btn btn-sm btn-info me-1" data-bs-toggle="modal" data-bs-target="#maintenanceModal">
                  View
                </button>
              </td>
            </tr>
            <tr>
              <td>Image</td>
              <td>Banner Frontend</td>
              <td>
                <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#bannerModal">+ Tambah Banner</button>
              </td>
              <td>
                <button type="button" class="btn btn-sm btn-info me-1" data-bs-toggle="modal" data-bs-target="#imageBannerModal">
                  View
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- Modal -->
  <div class="modal fade" id="settingsModal" tabindex="-1" aria-labelledby="settingsModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title" id="settingsModalLabel">Site Info</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        <?php if (!empty($settings)): ?>
          <div class="mb-3 row">
            <label class="col-sm-3 col-form-label fw-bold">Site Name</label>
            <div class="col-sm-9 pt-1"><?= esc($settings['site_name'] ?? '-') ?></div>
          </div>
          <div class="mb-3 row">
            <label class="col-sm-3 col-form-label fw-bold">Tagline</label>
            <div class="col-sm-9 pt-1"><?= esc($settings['tagline'] ?? '-') ?></div>
          </div>
          <div class="mb-3 row">
            <label class="col-sm-3 col-form-label fw-bold">About</label>
            <div class="col-sm-9 pt-1"><?= esc($settings['about'] ?? '-') ?></div>
          </div>
          <div class="mb-3 row">
            <label class="col-sm-3 col-form-label fw-bold">Location</label>
            <div class="col-sm-9 pt-1"><?= esc($settings['location'] ?? '-') ?></div>
          </div>
        <?php else: ?>
          <p class="text-muted">Data pengaturan belum tersedia.</p>
        <?php endif ?>
      </div>

    </div>
  </div>
</div>

<div class="modal fade" id="contactSocialModal" tabindex="-1" aria-labelledby="contactSocialModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="contactSocialModalLabel">Contact & Social</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <?php if (!empty($settings)): ?>
          <div class="mb-2 row"><label class="col-sm-4 fw-bold">Telepon</label><div class="col-sm-8"><?= esc($settings['phone'] ?? '-') ?></div></div>
          <div class="mb-2 row"><label class="col-sm-4 fw-bold">Instagram</label><div class="col-sm-8"><?= esc($settings['instagram'] ?? '-') ?></div></div>
          <div class="mb-2 row"><label class="col-sm-4 fw-bold">TikTok</label><div class="col-sm-8"><?= esc($settings['tiktok'] ?? '-') ?></div></div>
        <?php else: ?>
          <p class="text-muted">Data belum tersedia.</p>
        <?php endif ?>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="logoIconModal" tabindex="-1" aria-labelledby="logoIconModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="logoIconModalLabel">Logo & Icon</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body text-center">
        <?php if (!empty($settings['site_logo'])): ?>
          <p class="fw-bold">Logo:</p>
          <img src="<?= base_url('uploads/' . $settings['site_logo']) ?>" alt="Logo" class="img-fluid mb-3" style="max-height: 80px;">
        <?php endif ?>
        <?php if (!empty($settings['site_icon'])): ?>
          <p class="fw-bold">Favicon:</p>
          <img src="<?= base_url('uploads/' . $settings['site_icon']) ?>" alt="Icon" style="max-height: 40px;">
        <?php endif ?>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="localeModal" tabindex="-1" aria-labelledby="localeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="localeModalLabel">Locale Settings</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <?php if (!empty($settings)): ?>
          <div class="mb-2 row"><label class="col-sm-5 fw-bold">Timezone</label><div class="col-sm-7"><?= esc($settings['timezone'] ?? '-') ?></div></div>
          <div class="mb-2 row"><label class="col-sm-5 fw-bold">Bahasa</label><div class="col-sm-7"><?= esc($settings['language'] ?? '-') ?></div></div>
          <div class="mb-2 row"><label class="col-sm-5 fw-bold">Format Tanggal</label><div class="col-sm-7"><?= esc($settings['date_format'] ?? '-') ?></div></div>
        <?php else: ?>
          <p class="text-muted">Data belum tersedia.</p>
        <?php endif ?>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="maintenanceModal" tabindex="-1" aria-labelledby="maintenanceModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="maintenanceModalLabel">Maintenance</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body text-center">
        <?php if (isset($settings['maintenance_mode'])): ?>
          <span class="badge bg-<?= $settings['maintenance_mode'] == 'on' ? 'danger' : 'success' ?>">
            <?= ucfirst($settings['maintenance_mode']) ?>
          </span>
        <?php else: ?>
          <p class="text-muted">Belum diatur.</p>
        <?php endif ?>
      </div>
    </div>
  </div>
</div>

<!-- MODAL VIEW BANNER -->
<div class="modal fade" id="imageBannerModal" tabindex="-1" aria-labelledby="imageBannerModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="imageBannerModalLabel">Banner Halaman Frontend</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <?php if (!empty($banners) && is_array($banners)): ?>
          <div class="row">
            <?php 
              $labelMap = [
                'home' => 'Home Banner',
                'about' => 'About Banner',
                'property' => 'Property Banner',
                'blog' => 'Blog Banner',
                'contact' => 'Contact Banner',
              ];
            ?>
            <?php foreach ($banners as $banner): ?>
              <div class="col-md-6 mb-4 text-center">
                <strong class="d-block mb-2"><?= esc($labelMap[$banner['type']] ?? ucfirst($banner['type'])) ?></strong>
                <img src="<?= base_url('uploads/settings/banner/' . $banner['filename']) ?>" 
                     class="img-fluid rounded border" style="max-height: 200px;">
              </div>
            <?php endforeach ?>
          </div>
        <?php else: ?>
          <p class="text-muted text-center">Belum ada banner yang diunggah.</p>
        <?php endif ?>
      </div>
    </div>
  </div>
</div>




<!-- MODAL BANNER IMAGE -->
<div class="modal fade" id="bannerModal" tabindex="-1" aria-labelledby="bannerModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <form action="<?= base_url('dashboard/settings/banner/save') ?>" method="post" enctype="multipart/form-data" class="modal-content">
      <?= csrf_field() ?>
      <input type="hidden" name="id" id="banner_id">

      <div class="modal-header">
        <h5 class="modal-title" id="bannerModalLabel">Tambah / Edit Banner</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
      </div>

      <div class="modal-body">
        <div class="mb-3">
          <label class="form-label">Jenis Banner</label>
          <select class="form-select" name="type" id="banner_type" required>
            <option value="">-- Pilih Jenis Banner --</option>
            <option value="home">Home Banner</option>
            <option value="about">About Banner</option>
            <option value="property">Property Banner</option>
            <option value="blog">Blog Banner</option>
            <option value="contact">Contact Banner</option>
          </select>
        </div>

        <div class="mb-3">
          <label class="form-label">Upload Gambar</label>
          <input type="file" class="form-control" name="filename" accept="image/*">
          <small class="text-muted">Max 2MB. Format: JPG, PNG, WEBP.</small>
        </div>

        <div class="mb-3" id="currentBannerPreview" style="display:none;">
          <label class="form-label">Banner Saat Ini</label><br>
          <img src="" id="banner_preview_img" style="max-height: 150px;" class="img-thumbnail">
        </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
      </div>
    </form>
  </div>
</div>


<script>
function openBannerModal(data = null) {
  document.getElementById('banner_id').value = data?.id || '';
  document.getElementById('banner_type').value = data?.type || '';
  document.getElementById('currentBannerPreview').style.display = 'none';

  if (data && data.filename) {
    const preview = document.getElementById('banner_preview_img');
    preview.src = "<?= base_url('uploads/settings/banner/') ?>/" + data.filename;
    document.getElementById('currentBannerPreview').style.display = 'block';
  }

  const modal = new bootstrap.Modal(document.getElementById('bannerModal'));
  modal.show();
}
</script>




<?= $this->endSection() ?>
