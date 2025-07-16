<?= $this->extend('admin/layout/default') ?>
<?= $this->section('content') ?>

<div class="container-fluid">

  <!-- Page Title -->
  <div class="row">
    <div class="col-12">
      <div class="page-title-box">
        <h4 class="mb-0"><?= esc($title) ?></h4>
        <ol class="breadcrumb mb-0">
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
    </div>
  </div>

  <?php if (session('validation')): ?>
    <div class="alert alert-danger"><?= session('validation')->listErrors() ?></div>
  <?php endif ?>

  <!-- FORM MULAI -->
  <form action="<?= base_url('dashboard/developer/' . esc($developer['slug']) . '/property/' . esc($property['slug']) . '/update') ?>" method="post" enctype="multipart/form-data">

    <?= csrf_field() ?>

    <div class="row gx-4">
      <!-- Kiri: Form Property -->
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
              <input type="text" name="title" class="form-control" value="<?= old('title', esc($property['title'])) ?>" required>
            </div>

            <div class="mb-3">
              <label class="form-label">Price</label>
              <input type="text" id="price_display" class="form-control <?= (session('errors.price') ? 'is-invalid' : '') ?>" value="<?= number_format($property['price'] ?? 0, 0, ',', '.') ?>">
              <input type="hidden" name="price" id="price" value="<?= old('price', $property['price'] ?? '') ?>">
              <?php if (session('errors.price')) : ?>
                  <div class="invalid-feedback"><?= esc(session('errors.price')) ?></div>
              <?php endif ?>
            </div>

            <input type="hidden" name="price_text" id="price_text" value="<?= old('price_text', $property['price_text'] ?? '') ?>">

            <div class="mb-3">
              <label class="form-label">Description</label>
              <textarea name="description" class="form-control" rows="4" required><?= old('description', esc($property['description'])) ?></textarea>
            </div>

            <div class="text-end">
              <button type="submit" class="btn btn-primary">Update Property</button>
              <a href="<?= base_url('dashboard/developer/' . esc($developer['slug']) . '/property') ?>" class="btn btn-secondary">Kembali</a>
            </div>

          </div>
        </div>
      </div>

      <!-- Kanan: Upload Gambar -->
      <div class="col-md-6">
        <div class="card mb-3">
          <div class="card-header"><strong>Images (max 10)</strong></div>
          <div class="card-body">

            <!-- Dropzone Box -->
            <label for="imageInput" id="dropzoneBox" class="p-4 border rounded text-center w-100" style="cursor:pointer; background: #f8f9fa;">
              <input type="file" name="images[]" id="imageInput" multiple hidden>
              <div class="dz-message needsclick">
                <i class="h1 bx bx-cloud-upload mb-2"></i>
                <h5>Drop files here or click to upload</h5>
                <small class="text-muted">Max 10 images. Max size 2MB each.</small>
              </div>
            </label>

            <!-- Preview Gambar Lama -->
            <div class="row mt-3" id="previewContainer">
              <?php foreach ($images as $img): ?>
                <div class="col-6 col-md-4 mb-3 text-center">
                  <div class="position-relative border rounded p-1 bg-light">
                    <img src="<?= base_url('uploads/property/' . $img['filename']) ?>"
                         class="img-fluid mb-2 rounded" style="height:100px;object-fit:cover;">
                    <form method="post" action="<?= base_url('dashboard/property/image/delete/' . $img['id']) ?>" onsubmit="return confirm('Hapus gambar ini?')">
                      <?= csrf_field() ?>
                      <button type="submit" class="btn btn-sm btn-outline-danger w-100">Remove</button>
                    </form>
                  </div>
                </div>
              <?php endforeach ?>
            </div>

          </div>
        </div>
      </div>
    </div>

  </form>
  <!-- FORM END -->

</div>

<!-- Script Preview Harga -->
<script>
  const priceDisplay = document.getElementById('price_display');
  const priceHidden = document.getElementById('price');
  const priceText = document.getElementById('price_text');

  priceDisplay.addEventListener('input', function () {
    let raw = this.value.replace(/\./g, '').replace(/[^0-9]/g, '');
    let number = parseInt(raw);

    if (!isNaN(number)) {
      this.value = number.toLocaleString('id-ID');
      priceHidden.value = number;

      if (number >= 1_000_000_000) {
        priceText.value = (number / 1_000_000_000).toFixed(1).replace('.0', '') + ' M';
      } else if (number >= 1_000_000) {
        priceText.value = (number / 1_000_000).toFixed(1).replace('.0', '') + ' juta';
      } else if (number >= 1_000) {
        priceText.value = (number / 1_000).toFixed(1).replace('.0', '') + ' ribu';
      } else {
        priceText.value = number;
      }
    } else {
      this.value = '';
      priceHidden.value = '';
      priceText.value = '';
    }
  });
</script>

<!-- Script Preview Image -->
<script>
  const dropzoneBox = document.getElementById('dropzoneBox');
  const input = document.getElementById('imageInput');
  const preview = document.getElementById('previewContainer');
  let count = <?= count($images) ?>; // Gambar lama yang sudah ada

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

    if (count + list.length > 10) {
      alert("Maximum 10 images allowed (existing + new)");
      return;
    }

    list.forEach(file => {
      if (!file.type.startsWith('image/')) {
        alert("File " + file.name + " bukan gambar.");
        return;
      }

      const reader = new FileReader();
      reader.onload = e => {
        const col = document.createElement('div');
        col.className = 'col-6 col-md-4 mb-3 text-center position-relative';

        col.innerHTML = `
          <div class="position-relative border rounded p-1 bg-light">
            <span class="badge bg-success position-absolute top-0 start-50 translate-middle-x">New</span>
            <img src="${e.target.result}" class="img-fluid mb-2 rounded" style="height:100px;object-fit:cover;">
          </div>
        `;

        preview.appendChild(col);
        count++;
      };
      reader.readAsDataURL(file);
    });
  }
</script>

<?= $this->endSection() ?>
