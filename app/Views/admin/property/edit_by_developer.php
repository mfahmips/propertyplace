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

  <?php if (session('validation')): ?>
    <div class="alert alert-danger"><?= session('validation')->listErrors() ?></div>
  <?php endif ?>

  <form action="<?= base_url('dashboard/property/developer/' . esc($developer['slug']) . '/edit/' . esc($property['slug'])) ?>" method="post" enctype="multipart/form-data">
    <?= csrf_field() ?>
    <div class="row gx-4">
      <!-- Kiri: Form -->
      <div class="col-md-6">
        <div class="card mb-4">
          <div class="card-body">
            <!-- Input fields (title, price, description, etc.) -->
            <input type="hidden" name="developer_id" value="<?= esc($developer['id']) ?>">
            <div class="mb-3">
              <label class="form-label">Developer</label>
              <input type="text" class="form-control" value="<?= esc($developer['name']) ?>" disabled readonly>
            </div>
            <div class="mb-3">
              <label class="form-label">Title</label>
              <input type="text" name="title" class="form-control" value="<?= old('title', esc($property['title'])) ?>" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Price (IDR)</label>
              <input type="number" name="price" class="form-control" value="<?= old('price', esc($property['price'])) ?>" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Description</label>
              <textarea name="description" class="form-control" rows="4" required><?= old('description', esc($property['description'])) ?></textarea>
            </div>
            <div class="mb-3">
              <label class="form-label">Type</label>
              <input type="text" name="type" class="form-control" value="<?= old('type', $propertyDetail['type'] ?? '') ?>">
            </div>
            <div class="mb-3">
              <label class="form-label">Purpose</label>
              <select name="purpose" class="form-select" required>
                <option value="">-- Select Purpose --</option>
                <option value="For Sale" <?= (old('purpose', $propertyDetail['purpose'] ?? '') === 'For Sale') ? 'selected' : '' ?>>For Sale</option>
                <option value="For Rent" <?= (old('purpose', $propertyDetail['purpose'] ?? '') === 'For Rent') ? 'selected' : '' ?>>For Rent</option>
              </select>
            </div>
            <div class="row">
              <div class="col-md-3 mb-3"><label class="form-label">Rooms</label><input type="number" name="rooms" class="form-control" value="<?= old('rooms', $propertyDetail['rooms'] ?? '') ?>"></div>
              <div class="col-md-3 mb-3"><label class="form-label">Bedrooms</label><input type="number" name="bedrooms" class="form-control" value="<?= old('bedrooms', $propertyDetail['bedrooms'] ?? '') ?>"></div>
              <div class="col-md-3 mb-3"><label class="form-label">Bathrooms</label><input type="number" name="bathrooms" class="form-control" value="<?= old('bathrooms', $propertyDetail['bathrooms'] ?? '') ?>"></div>
              <div class="col-md-3 mb-3"><label class="form-label">Sqft</label><input type="number" name="sqft" class="form-control" value="<?= old('sqft', $propertyDetail['sqft'] ?? '') ?>"></div>
            </div>
            <div class="mb-3">
              <label class="form-label d-block">Facilities</label>
              <div class="form-check form-check-inline"><input class="form-check-input" type="checkbox" name="wifi" value="1" <?= old('wifi', $propertyDetail['wifi'] ?? 0) ? 'checked' : '' ?>><label class="form-check-label">WiFi</label></div>
              <div class="form-check form-check-inline"><input class="form-check-input" type="checkbox" name="elevator" value="1" <?= old('elevator', $propertyDetail['elevator'] ?? 0) ? 'checked' : '' ?>><label class="form-check-label">Elevator</label></div>
              <div class="form-check form-check-inline"><input class="form-check-input" type="checkbox" name="parking" value="1" <?= old('parking', $propertyDetail['parking'] ?? 0) ? 'checked' : '' ?>><label class="form-check-label">Parking</label></div>
            </div>

            <div class="text-end">
              <button type="submit" class="btn btn-primary">Update Property</button>
              <a href="<?= base_url('dashboard/property/developer/' . esc($developer['slug'])) ?>" class="btn btn-secondary">Cancel</a>
            </div>
          </div>
        </div>
      </div>

      <!-- Kanan: Dropzone & Preview -->
      <div class="col-md-6">
        <div class="card mb-3">
          <div class="card-header"><strong>Images (max 10)</strong></div>
          <div class="card-body">
            <div id="dropzoneBox" class="dropzone p-4 border rounded text-center" style="cursor:pointer">
              <div class="fallback"><input type="file" name="images[]" id="imageInput" multiple hidden></div>
              <div class="dz-message needsclick">
                <i class="h1 bx bx-cloud-upload mb-2"></i>
                <h5>Drop files here or click to upload</h5>
              </div>
            </div>

            <div class="row mt-3" id="previewContainer">
              <?php foreach ($images as $img): ?>
                <div class="col-6 col-md-4 mb-3 text-center">
                  <div class="position-relative">
                    <span class="badge bg-secondary position-absolute top-0 start-50 translate-middle-x">Saved</span>
                    <img src="<?= base_url('uploads/property/' . $img['filename']) ?>" class="img-fluid border rounded mb-2" style="height:100px;object-fit:cover;">
                  </div>
                  <form method="post" action="<?= base_url('dashboard/property/image/delete/' . $img['id']) ?>" onsubmit="return confirm('Delete this image?')">
                    <?= csrf_field() ?>
                    <button class="btn btn-sm btn-outline-danger">Remove</button>
                  </form>
                </div>
              <?php endforeach ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </form>
</div>

<script>
  const dropzoneBox = document.getElementById('dropzoneBox');
  const input = document.getElementById('imageInput');
  const preview = document.getElementById('previewContainer');
  let count = <?= count($images) ?>;

  dropzoneBox.addEventListener('click', () => input.click());
  dropzoneBox.addEventListener('dragover', e => e.preventDefault());
  dropzoneBox.addEventListener('drop', e => {
    e.preventDefault();
    handleFiles(e.dataTransfer.files);
  });

  input.addEventListener('change', () => {
    handleFiles(input.files);
    input.value = '';
  });

  function handleFiles(files) {
    const list = Array.from(files);
    if (count + list.length > 10) return alert("Maximum 10 images allowed");

    list.forEach(file => {
      if (!file.type.startsWith('image/')) return;

      const reader = new FileReader();
      reader.onload = e => {
        const col = document.createElement('div');
        col.className = 'col-6 col-md-4 mb-3 text-center position-relative';
        col.innerHTML = `
          <span class="badge bg-success position-absolute top-0 start-50 translate-middle-x">New</span>
          <img src="${e.target.result}" class="img-fluid border rounded mb-2" style="height:100px;object-fit:cover;">
          <button type="button" class="btn btn-sm btn-outline-danger remove-btn">Remove</button>
        `;
        col.querySelector('.remove-btn').addEventListener('click', () => {
          col.remove();
          count--;
        });
        preview.appendChild(col);
        count++;
      };
      reader.readAsDataURL(file);
    });
  }
</script>

<?= $this->endSection() ?>
