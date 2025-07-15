<?= $this->extend('admin/layout/default') ?>
<?= $this->section('content') ?>

<div class="container-fluid">
  <div class="page-title-box">
    <h4><?= esc($title) ?></h4>
    <ol class="breadcrumb mb-3">
      <?php foreach ($breadcrumb as $item): ?>
        <li class="breadcrumb-item <?= isset($item['url']) ? '' : 'active' ?>">
          <?php if (isset($item['url'])): ?>
            <a href="<?= $item['url'] ?>"><?= $item['label'] ?></a>
          <?php else: ?>
            <?= $item['label'] ?>
          <?php endif ?>
        </li>
      <?php endforeach ?>
    </ol>
  </div>

  <?php if (session('success')): ?>
    <div class="alert alert-success"><?= session('success') ?></div>
  <?php endif ?>

  <div class="row">
    <!-- Detail Properti -->
    <div class="col-lg-4">
      <div class="card mb-4">
        <div class="card-body">
          <h5><?= esc($property['title']) ?></h5>
          <p><?= esc($property['description']) ?></p>

          <table class="table table-bordered">
            <tr><th>Type</th><td><?= esc($details['type'] ?? '-') ?></td></tr>
            <tr><th>Purpose</th><td><?= esc($details['purpose'] ?? '-') ?></td></tr>
            <tr><th>Rooms</th><td><?= esc($details['rooms'] ?? '-') ?></td></tr>
            <tr><th>Bedrooms</th><td><?= esc($details['bedrooms'] ?? '-') ?></td></tr>
            <tr><th>Bathrooms</th><td><?= esc($details['bathrooms'] ?? '-') ?></td></tr>
            <tr><th>Sqft</th><td><?= esc($details['sqft'] ?? '-') ?></td></tr>
            <tr><th>Parking</th><td><?= ($details['parking'] ?? 0) ? 'Yes' : 'No' ?></td></tr>
            <tr><th>Elevator</th><td><?= ($details['elevator'] ?? 0) ? 'Yes' : 'No' ?></td></tr>
            <tr><th>WiFi</th><td><?= ($details['wifi'] ?? 0) ? 'Yes' : 'No' ?></td></tr>
          </table>

          <button class="btn btn-warning mt-3" data-bs-toggle="modal" data-bs-target="#editDetailModal">
            Edit Detail Properti
          </button>
        </div>
      </div>
    </div>

    <!-- Floor Plan -->
    <div class="col-lg-4">
      <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
          <strong>Floor Plans</strong>
          <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addFloorPlanModal">+ Tambah</button>
        </div>
        <div class="card-body">
          <?php if (!empty($floor_plans)): ?>
            <div class="row">
              <?php foreach ($floor_plans as $plan): ?>
                <div class="col-12 text-center mb-3">
                  <img src="<?= base_url('uploads/floor_plans/' . $plan['image']) ?>" class="img-fluid border rounded mb-2" alt="Floor Plan">
                  <p><?= esc($plan['title']) ?></p>
                </div>
              <?php endforeach ?>
            </div>
          <?php else: ?>
            <p class="text-muted">Belum ada data floor plan.</p>
          <?php endif ?>
        </div>
      </div>
    </div>

    <!-- Dokumen Properti -->
    <div class="col-lg-4">
      <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
          <strong>Dokumen Properti</strong>
          <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addDocumentModal">+ Tambah</button>
        </div>
        <div class="card-body">
          <?php if (!empty($documents)): ?>
            <ul class="list-group">
              <?php foreach ($documents as $doc): ?>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                  <span><i class="bi bi-file-earmark-text me-2"></i><?= esc($doc['name']) ?></span>
                  <a href="<?= base_url('uploads/documents/' . $doc['file']) ?>" target="_blank" class="btn btn-sm btn-outline-primary">Lihat</a>
                </li>
              <?php endforeach ?>
            </ul>
          <?php else: ?>
            <p class="text-muted">Belum ada dokumen yang diunggah.</p>
          <?php endif ?>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal Edit Detail Properti -->
<div class="modal fade" id="editDetailModal" tabindex="-1" aria-labelledby="editDetailModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <form action="<?= base_url('dashboard/property/detail/update/' . $property['slug']) ?>" method="post">
      <?= csrf_field() ?>
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editDetailModalLabel">Edit Detail Properti</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label">Type</label>
              <select name="type" class="form-select">
                <?php $options = ['rumah', 'apartemen', 'ruko', 'kavling']; $selected = $details['type'] ?? ''; ?>
                <option value="">-- Pilih Type --</option>
                <?php foreach ($options as $opt): ?>
                  <option value="<?= $opt ?>" <?= $selected === $opt ? 'selected' : '' ?>><?= ucfirst($opt) ?></option>
                <?php endforeach ?>
              </select>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Purpose</label>
              <select name="purpose" class="form-select">
                <option value="For Sale" <?= ($details['purpose'] ?? '') == 'For Sale' ? 'selected' : '' ?>>For Sale</option>
                <option value="For Rent" <?= ($details['purpose'] ?? '') == 'For Rent' ? 'selected' : '' ?>>For Rent</option>
              </select>
            </div>
            <div class="col-md-3 mb-3">
              <label class="form-label">Rooms</label>
              <input type="number" name="rooms" class="form-control" value="<?= esc($details['rooms'] ?? '') ?>">
            </div>
            <div class="col-md-3 mb-3">
              <label class="form-label">Bedrooms</label>
              <input type="number" name="bedrooms" class="form-control" value="<?= esc($details['bedrooms'] ?? '') ?>">
            </div>
            <div class="col-md-3 mb-3">
              <label class="form-label">Bathrooms</label>
              <input type="number" name="bathrooms" class="form-control" value="<?= esc($details['bathrooms'] ?? '') ?>">
            </div>
            <div class="col-md-3 mb-3">
              <label class="form-label">Sqft</label>
              <input type="number" name="sqft" class="form-control" value="<?= esc($details['sqft'] ?? '') ?>">
            </div>
            <div class="col-md-12 mb-3">
              <label class="form-label d-block">Facilities</label>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="wifi" value="1" <?= !empty($details['wifi']) ? 'checked' : '' ?>>
                <label class="form-check-label">WiFi</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="elevator" value="1" <?= !empty($details['elevator']) ? 'checked' : '' ?>>
                <label class="form-check-label">Elevator</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="parking" value="1" <?= !empty($details['parking']) ? 'checked' : '' ?>>
                <label class="form-check-label">Parking</label>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Simpan</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- Modal Tambah Floor Plan -->
<div class="modal fade" id="addFloorPlanModal" tabindex="-1" aria-labelledby="addFloorPlanModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form action="<?= base_url('dashboard/property/' . $property['slug'] . '/add-floorplan') ?>" method="post" enctype="multipart/form-data">
      <?= csrf_field() ?>
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addFloorPlanModalLabel">Tambah Floor Plan</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label>Nama</label>
            <input type="text" name="name" class="form-control" required>
          </div>
          <div class="mb-3">
            <label>Deskripsi</label>
            <textarea name="description" class="form-control"></textarea>
          </div>
          <div class="mb-3">
            <label>Gambar</label>
            <input type="file" name="image" accept="image/*" class="form-control" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- Modal Tambah Dokumen -->
<div class="modal fade" id="addDocumentModal" tabindex="-1" aria-labelledby="addDocumentModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form action="<?= base_url('dashboard/property/' . $property['slug'] . '/add-document') ?>" method="post" enctype="multipart/form-data">
      <?= csrf_field() ?>
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addDocumentModalLabel">Tambah Dokumen</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label>Judul</label>
            <input type="text" name="title" class="form-control" required>
          </div>
          <div class="mb-3">
            <label>Jenis</label>
            <select name="type" class="form-select" required onchange="toggleFileInput(this)">
              <option value="">-- Pilih Jenis --</option>
              <option value="pdf">PDF</option>
              <option value="video">Video</option>
            </select>
          </div>
          <div class="mb-3" id="fileInput" style="display:none;">
            <label>File PDF</label>
            <input type="file" name="file" accept="application/pdf" class="form-control">
          </div>
          <div class="mb-3" id="videoInput" style="display:none;">
            <label>Link Video</label>
            <input type="url" name="video_url" class="form-control">
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
      </div>
    </form>
  </div>
</div>

<script>
function toggleFileInput(select) {
  document.getElementById('fileInput').style.display = select.value === 'pdf' ? 'block' : 'none';
  document.getElementById('videoInput').style.display = select.value === 'video' ? 'block' : 'none';
}
</script>

<?= $this->endSection() ?>
