<?= $this->extend('admin/layout/default') ?>
<?= $this->section('content') ?>

<div class="container-fluid">

  <!-- Page Title -->
  <div class="row">
    <div class="col-12">
      <div class="page-title-box">
        <h4 class="mb-0"><?= $title ?></h4>
        <ol class="breadcrumb mb-0">
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
    </div>
  </div>

  <?php if (isset($errors)): ?>
    <div class="alert alert-danger">
      <?php foreach ($errors as $err): ?>
        <p class="mb-0"><?= esc($err) ?></p>
      <?php endforeach ?>
    </div>
  <?php endif ?>

  <form action="<?= base_url('dashboard/property/developer/' . $developer['slug'] . '/store') ?>" method="post" enctype="multipart/form-data">
    <?= csrf_field() ?>

    <div class="row gx-4">
      <!-- Kiri: Form Input -->
      <div class="col-md-6">
        <div class="card mb-4">
          <div class="card-body">

            <input type="hidden" name="developer_id" value="<?= esc($developer['id']) ?>">

            <div class="mb-3">
              <label class="form-label">Developer</label>
              <input type="text" class="form-control" value="<?= esc($developer['name']) ?>" disabled readonly>
            </div>

            <div class="mb-3">
              <label class="form-label">Title</label>
              <input type="text" name="title" class="form-control" value="<?= old('title') ?>" required>
            </div>

            <div class="mb-3">
              <label class="form-label">Price (IDR)</label>
              <input type="number" name="price" class="form-control" value="<?= old('price') ?>" required>
            </div>

            <div class="mb-3">
              <label class="form-label">Description</label>
              <textarea name="description" class="form-control" rows="4" required><?= old('description') ?></textarea>
            </div>

            <div class="mb-3">
              <label class="form-label">Type</label>
              <input type="text" name="type" class="form-control" value="<?= old('type') ?>">
            </div>

            <div class="mb-3">
              <label class="form-label">Purpose</label>
              <select name="purpose" class="form-select" required>
                <option value="">-- Select Purpose --</option>
                <option value="For Sale" <?= old('purpose') == 'For Sale' ? 'selected' : '' ?>>For Sale</option>
                <option value="For Rent" <?= old('purpose') == 'For Rent' ? 'selected' : '' ?>>For Rent</option>
              </select>
            </div>

            <div class="row">
              <div class="col-md-3 mb-3">
                <label class="form-label">Rooms</label>
                <input type="number" name="rooms" class="form-control" value="<?= old('rooms') ?>" min="0">
              </div>
              <div class="col-md-3 mb-3">
                <label class="form-label">Bedrooms</label>
                <input type="number" name="bedrooms" class="form-control" value="<?= old('bedrooms') ?>" min="0">
              </div>
              <div class="col-md-3 mb-3">
                <label class="form-label">Bathrooms</label>
                <input type="number" name="bathrooms" class="form-control" value="<?= old('bathrooms') ?>" min="0">
              </div>
              <div class="col-md-3 mb-3">
                <label class="form-label">Sqft</label>
                <input type="number" name="sqft" class="form-control" value="<?= old('sqft') ?>" min="0">
              </div>
            </div>

            <div class="mb-3">
              <label class="form-label d-block">Facilities</label>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="wifi" value="1" <?= old('wifi') ? 'checked' : '' ?>>
                <label class="form-check-label">WiFi</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="elevator" value="1" <?= old('elevator') ? 'checked' : '' ?>>
                <label class="form-check-label">Elevator</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="parking" value="1" <?= old('parking') ? 'checked' : '' ?>>
                <label class="form-check-label">Parking</label>
              </div>
            </div>

            <div class="text-end">
              <button type="submit" class="btn btn-primary">Save Property</button>
              <a href="<?= base_url('dashboard/property/developer/' . $developer['slug']) ?>" class="btn btn-secondary">Cancel</a>
            </div>
          </div>
        </div>
      </div>

      <!-- Kanan: Upload Gambar -->
      <div class="col-md-6">
        <!-- Dropzone Container -->
        <div class="card">
          <div class="card-header"><strong>Upload Images</strong></div>
          <div class="card-body">

            <div id="custom-dropzone" class="dropzone border rounded p-4 position-relative text-center" style="cursor: pointer;">
              <div class="fallback">
                <input name="images[]" type="file" id="imageInput" accept="image/*" multiple hidden>
              </div>
              <div class="dz-message needsclick">
                <i class="h1 bx bx-cloud-upload mb-3"></i>
                <h5>Drop files here or click to upload.</h5>
                <span class="text-muted fs-13">(Maximum 10 images allowed)</span>
              </div>
            </div>

            <!-- Preview Container -->
            <div class="row mt-4" id="previewContainer"></div>

          </div>
        </div>

      </div>
    </div>
  </form>
</div>

<script>
  const dropzone = document.getElementById('custom-dropzone');
  const input = document.getElementById('imageInput');
  const previewContainer = document.getElementById('previewContainer');
  let imageCount = 0;
  const maxImages = 10;

  // Click to open file input
  dropzone.addEventListener('click', () => input.click());

  // Drag & drop highlight
  ['dragenter', 'dragover'].forEach(evt => {
    dropzone.addEventListener(evt, e => {
      e.preventDefault();
      dropzone.classList.add('border-primary');
    });
  });

  ['dragleave', 'drop'].forEach(evt => {
    dropzone.addEventListener(evt, () => {
      dropzone.classList.remove('border-primary');
    });
  });

  // Handle drop
  dropzone.addEventListener('drop', e => {
    e.preventDefault();
    handleFiles(e.dataTransfer.files);
  });

  // Handle manual input
  input.addEventListener('change', () => {
    handleFiles(input.files);
    input.value = ''; // reset input
  });

  function handleFiles(files) {
    const newFiles = Array.from(files);
    if (imageCount + newFiles.length > maxImages) {
      alert('Maximum 10 images allowed.');
      return;
    }

    newFiles.forEach(file => {
      if (!file.type.startsWith('image/')) return;

      const reader = new FileReader();
      reader.onload = function (e) {
        const col = document.createElement('div');
        col.className = 'col-6 col-md-4 mb-3 text-center';
        col.innerHTML = `
          <img src="${e.target.result}" class="img-fluid rounded border mb-2" style="height:100px;object-fit:cover;">
          <button type="button" class="btn btn-sm btn-outline-danger remove-btn">Remove</button>
        `;
        previewContainer.appendChild(col);

        col.querySelector('.remove-btn').addEventListener('click', () => {
          col.remove();
          imageCount--;
        });

        imageCount++;
      };
      reader.readAsDataURL(file);
    });
  }
</script>


<?= $this->endSection() ?>
