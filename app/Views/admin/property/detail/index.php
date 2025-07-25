<?= $this->extend('admin/layout/default') ?>
<?= $this->section('content') ?>

<div class="container-fluid">
  <div class="page-title-box">
    <h4><?= esc($title) ?></h4>
    <ol class="breadcrumb mb-3">
        <?php foreach ($breadcrumb as $item): ?>
            <li class="breadcrumb-item <?= isset($item['url']) ? '' : 'active' ?>">
                <?php if (isset($item['url'])): ?>
                    <a href="<?= esc($item['url']) ?>"><?= esc($item['label']) ?></a>
                <?php else: ?>
                    <?= esc($item['label']) ?>
                <?php endif ?>
            </li>
        <?php endforeach ?>
    </ol>
  </div>

  <?php if (session('success')): ?>
    <div class="alert alert-success"><?= session('success') ?></div>
  <?php endif ?>

  <!-- Unit Types + Floor Plan -->
  <div class="card mb-4">
  <div class="card-header d-flex justify-content-between align-items-center">
    <strong>Unit & Floor Plan</strong>
    <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#unitModal" onclick="editUnit(null)">+ Tambah Unit</button>
  </div>
  <div class="card-body">

    <?php if (!empty($units)): ?>
      <table class="table table-bordered table-sm">
        <thead>
          <tr>
            <th>Nama Unit</th>
            <th>Floor Plan</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($units as $unit): ?>
            <tr>
              <td><?= esc($unit['name_unit']) ?></td>
              
              <td>
                <?php if (!empty($unit['floor_plan'])): ?>
                  <img src="<?= base_url('uploads/property/floorplan/' . esc($unit['floor_plan']['image'])) ?>" 
                       style="height:50px;object-fit:contain;" class="rounded border mb-2"><br>
                  <button class="btn btn-sm btn-warning"
                          onclick='openFloorPlanModal(<?= json_encode($unit) ?>, <?= json_encode($unit['floor_plan']) ?>)'>
                    Edit Floor Plan
                  </button>
                <?php else: ?>
                  <button class="btn btn-sm btn-primary"
                          onclick='openFloorPlanModal(<?= json_encode($unit) ?>)'>
                    + Tambah Floor Plan
                  </button>
                <?php endif; ?>
              </td>

              <td>
                <button class="btn btn-sm btn-warning" onclick='editUnit(<?= json_encode($unit) ?>)' data-bs-toggle="modal" data-bs-target="#unitModal">Edit</button>
                <a href="<?= base_url('dashboard/developer/' . $filterDeveloper['slug'] . '/property/' . $property['slug'] . '/unit/' . $unit['id'] . '/delete') ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus unit ini?')">Hapus</a>
              </td>
            </tr>
          <?php endforeach ?>
        </tbody>
      </table>
    <?php else: ?>
      <p class="text-muted">Belum ada unit.</p>
    <?php endif ?>
  </div>
</div>


  <!-- Dokumen Properti -->
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

<div class="modal fade" id="unitModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <form method="post" action="<?= base_url('dashboard/developer/' . $filterDeveloper['slug'] . '/property/' . $property['slug'] . '/unit/save') ?>" class="modal-content">
      <?= csrf_field() ?>
      <input type="hidden" name="id" id="unit_id">
      <input type="hidden" name="property_id" value="<?= $property['id'] ?>">

      <div class="modal-header">
        <h5 class="modal-title">Form Unit Type</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body row g-3">
        <div class="col-md-6">
          <label>Nama Unit</label>
          <input type="text" name="name_unit" id="name_unit" class="form-control" required>
        </div>

        <input type="hidden" name="slug" id="slug">

        <div class="col-md-6">
          <label>Tipe</label>
          <input type="text" name="type_unit" id="type_unit" class="form-control">
        </div>

        <div class="col-md-3">
          <label>Luas Tanah</label>
          <input name="land_area" id="land_area" class="form-control">
        </div>

        <div class="col-md-3">
          <label>Luas Bangunan</label>
          <input name="building_area" id="building_area" class="form-control">
        </div>

        <div class="col-md-2">
          <label>Lantai</label>
          <input name="floors" id="floors" class="form-control">
        </div>

        <div class="col-md-2">
          <label>Kamar</label>
          <input name="bedrooms" id="bedrooms" class="form-control">
        </div>

        <div class="col-md-2">
          <label>K. Mandi</label>
          <input name="bathrooms" id="bathrooms" class="form-control">
        </div>

        <div class="col-md-2">
          <label>Carport</label>
          <input name="carport" id="carport" class="form-control">
        </div>

        <div class="col-md-2">
          <label>Lift</label>
          <select name="elevator" id="elevator" class="form-control">
            <option value="0">Tidak</option>
            <option value="1">Ya</option>
          </select>
        </div>
      </div>

      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button class="btn btn-primary" type="submit">Simpan</button>
      </div>
    </form>
  </div>
</div>


<script>
function editUnit(unit = null) {
  const form = document.querySelector('#unitModal form');
  form.reset();

  if (!unit) return;

  document.getElementById('unit_id').value = unit.id;
  document.getElementById('name_unit').value = unit.name_unit;
  document.getElementById('slug').value = unit.slug;
  document.getElementById('type_unit').value = unit.type_unit;
  document.getElementById('land_area').value = unit.land_area;
  document.getElementById('building_area').value = unit.building_area;
  document.getElementById('floors').value = unit.floors;
  document.getElementById('bedrooms').value = unit.bedrooms;
  document.getElementById('bathrooms').value = unit.bathrooms;
  document.getElementById('carport').value = unit.carport;
  document.getElementById('elevator').value = unit.elevator;
}
</script>


<div class="modal fade" id="floorPlanModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <form method="post" action="<?= base_url('dashboard/developer/' . $filterDeveloper['slug'] . '/property/' . $property['slug'] . '/floorplan/save') ?>" enctype="multipart/form-data" class="modal-content">
      <?= csrf_field() ?>
      <input type="hidden" name="id" id="floorplan_id">
      <input type="hidden" name="property_id" value="<?= $property['id'] ?>">
      <input type="hidden" name="unit_id" id="floorplan_unit_id">

      <div class="modal-header">
        <h5 class="modal-title" id="floorPlanModalTitle">Tambah Floor Plan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <div class="mb-3">
          <label>Nama Floor Plan</label>
          <input type="text" name="name" id="floorplan_name" class="form-control" readonly required>
        </div>

        <div class="mb-3">
          <label>Gambar</label>
          <input type="file" name="image" id="floorplan_image" class="form-control" accept="image/*">
          <small class="text-muted">Kosongkan jika tidak ingin ganti gambar saat edit</small>
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
function openFloorPlanModal(unit, floorPlan = null) {
  document.getElementById('floorplan_unit_id').value = unit.id;
  document.getElementById('floorplan_name').value = unit.name_unit;

  if (floorPlan) {
    document.getElementById('floorPlanModalTitle').innerText = 'Edit Floor Plan';
    document.getElementById('floorplan_id').value = floorPlan.id;
    document.getElementById('floorplan_image').required = false;
  } else {
    document.getElementById('floorPlanModalTitle').innerText = 'Tambah Floor Plan';
    document.getElementById('floorplan_id').value = '';
    document.getElementById('floorplan_image').required = true;
  }

  const modal = new bootstrap.Modal(document.getElementById('floorPlanModal'));
  modal.show();
}
</script>





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
