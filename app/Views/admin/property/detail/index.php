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

  <!-- Property Details -->
<div class="card mb-4">
  <div class="card-header d-flex justify-content-between align-items-center">
  <strong>Detail Properti</strong>
  <?php if (empty($detail)): ?>
    <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#detailModal" onclick="editDetail(null)">+ Tambah Detail</button>
  <?php else: ?>
    <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#detailModal" onclick="editDetail(<?= $detail['id'] ?>)">Edit Detail</button>
  <?php endif ?>
</div>
  <div class="card-body">
    <?php if (!empty($detail)): ?>
      <table class="table table-sm table-bordered">
        <tbody>
          <tr>
            <th>Lokasi</th>
            <td><?= esc($detail['location']) ?></td>
          </tr>
          <tr>
            <th>Harga</th>
            <td>Rp <?= number_format($detail['price'], 0, ',', '.') ?></td>
          </tr>
          <tr>
            <th>Tipe</th>
            <td><?= esc($detail['type']) ?: '<em class="text-muted">Belum diisi</em>' ?></td>
          </tr>
          <tr>
            <th>Tujuan</th>
            <td><?= esc($detail['purpose']) ?: '<em class="text-muted">Belum diisi</em>' ?></td>
          </tr>
          <tr>
            <th>Deskripsi</th>
            <td><?= nl2br(esc($detail['description'])) ?></td>
          </tr>
        </tbody>
      </table>
    <?php else: ?>
      <p class="text-muted">Belum ada detail property.</p>
    <?php endif ?>
  </div>
</div>

<!-- MODAL DETAIL PROPERTY -->
<div class="modal fade" id="detailModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <form action="<?= base_url('dashboard/developer/' . esc($filterDeveloper['slug']) . '/property/' . esc($property['slug']) . '/detail/save') ?>" method="post">
        <?= csrf_field() ?>
        <input type="hidden" name="property_id" value="<?= esc($property['id']) ?>">

        <?php if (!empty($detail)): ?>
          <input type="hidden" name="id" value="<?= esc($detail['id']) ?>">
        <?php endif ?>

        <div class="modal-header">
          <h5 class="modal-title">
            <?= empty($detail) ? 'Tambah Detail Properti' : 'Edit Detail Properti' ?>
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
          <div class="row">
            <div class="col-md-3 mb-3">
              <label class="form-label">Tipe Properti</label>
              <select name="type" class="form-select" required>
                <option value="">-- Pilih Tipe --</option>
                <?php
                  $tipeList = ['Rumah', 'Ruko', 'Apartemen', 'Kavling'];
                  foreach ($tipeList as $tipe):
                ?>
                  <option value="<?= $tipe ?>" <?= ($detail['type'] ?? '') == $tipe ? 'selected' : '' ?>>
                    <?= $tipe ?>
                  </option>
                <?php endforeach ?>
              </select>
            </div>

            <div class="col-md-3 mb-3">
              <label class="form-label">Harga</label>
              <input type="text" id="detail_price_display" class="form-control" placeholder="Rp. 0" value="<?= !empty($detail['price']) ? number_format($detail['price'], 0, ',', '.') : '' ?>">
              <input type="hidden" name="price" id="detail_price" value="<?= esc($detail['price'] ?? '') ?>">
              <input type="hidden" name="price_text" id="detail_price_text" value="<?= esc($detail['price_text'] ?? '') ?>">
            </div>


            <div class="col-md-3 mb-3">
              <label class="form-label">Lokasi</label>
              <select name="location" class="form-select" required>
                <option value="">-- Pilih Lokasi --</option>
                <?php
                  $lokasiList = ['Jakarta', 'Bogor', 'Depok', 'Tangerang', 'Bekasi'];
                  foreach ($lokasiList as $lok):
                ?>
                  <option value="<?= $lok ?>" <?= ($detail['location'] ?? '') == $lok ? 'selected' : '' ?>><?= $lok ?></option>
                <?php endforeach ?>
              </select>
            </div>
            <div class="col-md-3 mb-3">
              <label class="form-label">Peruntukan</label>
              <input type="text" name="purpose" class="form-control" value="<?= esc($detail['purpose'] ?? '') ?>">
            </div>

          </div>

          <div class="mb-3">
            <label class="form-label">Deskripsi</label>
            <textarea name="description" class="form-control" rows="4"><?= esc($detail['description'] ?? '') ?></textarea>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>

      </form>
    </div>
  </div>
</div>

<script>
  function formatPriceText(n) {
    if (n >= 1_000_000_000) return (n / 1_000_000_000).toFixed(1).replace(/\.0$/, '') + ' M';
    if (n >= 1_000_000) return (n / 1_000_000).toFixed(1).replace(/\.0$/, '') + ' Juta';
    if (n >= 1_000) return (n / 1_000).toFixed(1).replace(/\.0$/, '') + ' Ribu';
    return n.toString();
  }

  function bindPriceInput(displayId, hiddenId, textId) {
    const display = document.getElementById(displayId);
    const hidden  = document.getElementById(hiddenId);
    const text    = document.getElementById(textId);

    if (!display || !hidden || !text) return;

    display.addEventListener('input', function() {
      let val = this.value.replace(/\./g, '').replace(/[^0-9]/g, '');
      let n = parseInt(val) || 0;

      hidden.value = n;
      text.value = formatPriceText(n);
      this.value = n.toLocaleString('id-ID');
    });
  }

  // Jalankan untuk modal detail properti
  bindPriceInput('detail_price_display', 'detail_price', 'detail_price_text');
</script>

<!-- GALLERY PROPERTY -->
<div class="card mb-4">
  <div class="card-header d-flex justify-content-between align-items-center">
    <strong>Gallery Property</strong>
    <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#galleryModal">+ Tambah Gambar</button>
  </div>
  <div class="card-body">
    <?php if (!empty($galleryImages)): ?>
      <div class="row">
        <?php foreach ($galleryImages as $img): ?>
          <div class="col-md-3 mb-3">
          <div class="image-hover-wrapper">
            <img src="<?= base_url('uploads/property/' . esc($img['filename'])) ?>" alt="Gallery" class="img-thumbnail">
            
            <a href="<?= base_url('dashboard/developer/' . esc($filterDeveloper['slug']) . '/property/' . esc($property['slug']) . '/gallery/' . $img['id'] . '/delete') ?>"
               class="delete-overlay-btn"
               onclick="return confirm('Hapus gambar ini?')">
               Hapus
            </a>
          </div>
        </div>
        <?php endforeach ?>
      </div>
    <?php else: ?>
      <p class="text-muted">Belum ada gambar galeri.</p>
    <?php endif ?>
  </div>
</div>

<!-- MODAL GALLERY -->
<div class="modal fade" id="galleryModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <form action="<?= base_url('dashboard/developer/' . esc($filterDeveloper['slug']) . '/property/' . esc($property['slug']) . '/gallery/store') ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>
        <input type="hidden" name="property_id" value="<?= esc($property['id']) ?>">

        <div class="modal-header">
          <h5 class="modal-title">Tambah Gambar Gallery</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Pilih Gambar</label>
            <input type="file" name="images[]" id="create_imageInput" class="form-control" accept="image/*" multiple required>
            <small class="text-muted">Bisa memilih lebih dari satu gambar.</small>
          </div>

          <div class="row" id="create_previewContainer"></div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Upload</button>
        </div>
      </form>
    </div>
  </div>
</div>


<style>
.image-hover-wrapper {
    position: relative;
    overflow: hidden;
    border-radius: 8px;
}

.image-hover-wrapper img {
    width: 100%;
    height: auto;
    display: block;
    transition: filter 0.3s ease;
    border-radius: 8px;
}

/* Redupkan gambar saat hover */
.image-hover-wrapper:hover img {
    filter: brightness(50%);
}

/* Tombol Delete overlay */
.delete-overlay-btn {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background: rgba(255, 77, 77, 0.15); /* Soft red */
    border: 1px solid #ff4d4d;           /* Red border */
    color: #ff4d4d;
    padding: 8px 20px;
    font-size: 14px;
    border-radius: 8px;
    box-shadow: 0 0 8px rgba(255, 77, 77, 0.5);
    opacity: 0;
    transition: all 0.3s ease;
    text-decoration: none;
}

/* Munculkan tombol saat hover */
.image-hover-wrapper:hover .delete-overlay-btn {
    opacity: 1;
}

/* Efek hover di tombol */
.delete-overlay-btn:hover {
    background: rgba(255, 77, 77, 0.3);
    color: #fff;
    box-shadow: 0 0 12px rgba(255, 77, 77, 0.8);
}

</style>

<script>
function bindImagePreview(inputId, containerId) {
  const input = document.getElementById(inputId);
  const container = document.getElementById(containerId);

  if (!input || !container) return;

  input.addEventListener('change', () => {
    container.innerHTML = '';
    Array.from(input.files).forEach(file => {
      if (file.type.startsWith('image/')) {
        const reader = new FileReader();
        reader.onload = e => {
          const img = `<div class="col-3 mb-2"><img src="${e.target.result}" class="img-thumbnail" style="height:100px;object-fit:cover;"></div>`;
          container.insertAdjacentHTML('beforeend', img);
        };
        reader.readAsDataURL(file);
      }
    });
  });
}

bindImagePreview('create_imageInput', 'create_previewContainer');
</script>



  <!-- Type & Floor Plan -->
  <div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
      <strong>Type & Floor Plan</strong>
      <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#typeModal" onclick="edittype(null)">+ Tambah type</button>
    </div>
    <div class="card-body">
      <?php if (!empty($types)): ?>
        <table class="table table-bordered table-sm">
          <thead>
            <tr>
              <th>Type</th>
              <th>Images</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($types as $type): ?>
              <tr>
                <td><?= esc($type['name']) ?></td>
                <td>
                  <?php if (!empty($type['type_images'])): ?>
                    <img src="<?= base_url('uploads/property/floorplan/' . esc($type['type_images']['image'])) ?>" 
                         style="height:50px;object-fit:contain;" class="rounded border mb-2"><br>
                    <button class="btn btn-sm btn-warning"
                            onclick='openFloorPlanModal(<?= json_encode($type) ?>, <?= json_encode($type['type_images']) ?>)'>
                      Edit Floor Plan
                    </button>
                  <?php else: ?>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#typeImageModal">
                      + Tambah Type Images
                    </button>
                  <?php endif; ?>
                </td>
                <td>
                  <button class="btn btn-sm btn-warning" onclick='edittype(<?= json_encode($type) ?>)' data-bs-toggle="modal" data-bs-target="#typeModal">Edit</button>
                  <a href="<?= base_url('dashboard/developer/' . $filterDeveloper['slug'] . '/property/' . $property['slug'] . '/type/' . $type['id'] . '/delete') ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus type ini?')">Hapus</a>
                </td>
              </tr>
            <?php endforeach ?>
          </tbody>
        </table>
      <?php else: ?>
        <p class="text-muted">Belum ada type.</p>
      <?php endif ?>
    </div>
  </div>

  <!-- Dokumen Properti -->
  <div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
      <strong>Dokumen Properti</strong>
      <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addDocumentModal">+ Tambah Dokumen</button>
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

<!-- Modal Tambah/Edit Type -->
<div class="modal fade" id="typeModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <form method="post" action="<?= base_url('dashboard/developer/' . $filterDeveloper['slug'] . '/property/' . $property['slug'] . '/type/save') ?>" class="modal-content">
      <?= csrf_field() ?>
      <input type="hidden" name="id" id="type_id">
      <input type="hidden" name="property_id" value="<?= $property['id'] ?>">

      <div class="modal-header">
        <h5 class="modal-title">Form Type</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body row g-3">
        <div class="col-md-6">
          <label>Nama Type</label>
          <input type="text" name="name" id="name" class="form-control" required>
        </div>
        <input type="hidden" name="slug" id="slug">
        <div class="col-md-6">
          <label>Tipe Unit</label>
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
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
      </div>

    </form>
  </div>
</div>


<!-- Modal Tambah/Edit Type Images -->
<div class="modal fade" id="typeImageModal" tabindex="-1" aria-labelledby="typeImageModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <form method="post"
          action="<?= base_url('dashboard/developer/' . $filterDeveloper['slug'] . '/property/' . $property['slug'] . '/type-images/save') ?>"
          enctype="multipart/form-data" class="modal-content">

      <?= csrf_field() ?>

      <input type="hidden" name="id" value="">
      <input type="hidden" name="property_id" value="<?= $property['id'] ?>">
      <input type="hidden" name="type_id" value=""> <!-- isi manual sesuai kebutuhan -->

      <div class="modal-header">
        <h5 class="modal-title" id="typeImageModalLabel">Tambah Type Images</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
      </div>

      <div class="modal-body">
        <div class="mb-3">
          <label for="type_image_name">Nama Floor</label>
          <input type="text" name="name_floor" id="type_image_name" class="form-control" required>
        </div>

        <div class="mb-3">
          <label for="type_image_file">Gambar</label>
          <input type="file" name="image" id="type_image_file" class="form-control" accept="image/*" required>
          <small class="text-muted">Kosongkan jika tidak ingin mengganti gambar saat edit</small>
        </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
      </div>

    </form>
  </div>
</div>




<!-- Modal Dokumen -->
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

<!-- JS Modal Logic -->
<script>
function edittype(type = null) {
  const form = document.querySelector('#typeModal form');
  form.reset();

  if (!type) return;

  document.getElementById('type_id').value = type.id;
  document.getElementById('name').value = type.name;
  document.getElementById('slug').value = type.slug;
  document.getElementById('type_unit').value = type.type_unit;
  document.getElementById('land_area').value = type.land_area;
  document.getElementById('building_area').value = type.building_area;
  document.getElementById('floors').value = type.floors;
  document.getElementById('bedrooms').value = type.bedrooms;
  document.getElementById('bathrooms').value = type.bathrooms;
  document.getElementById('carport').value = type.carport;
  document.getElementById('elevator').value = type.elevator;
}

function openFloorPlanModal(type, floorPlan = null) {
  document.getElementById('floorplan_type_id').value = type.id;
  document.getElementById('floorplan_name').value = type.name;

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

function toggleFileInput(select) {
  document.getElementById('fileInput').style.display = select.value === 'pdf' ? 'block' : 'none';
  document.getElementById('videoInput').style.display = select.value === 'video' ? 'block' : 'none';
}
</script>

<?= $this->endSection() ?>
