<?= $this->extend('admin/layout/default') ?>

<?= $this->section('content') ?>

<!-- Start Container Fluid -->
<div class="container-fluid">

    <!-- ========== Page Title Start ========== -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="mb-0"><?= $title ?></h4>
                <ol class="breadcrumb mb-0">
                    <?php foreach ($breadcrumb as $item) : ?>
                        <?php if (isset($item['url'])) : ?>
                            <li class="breadcrumb-item">
                                <a href="<?= $item['url'] ?>"><?= $item['label'] ?></a>
                            </li>
                        <?php else : ?>
                            <li class="breadcrumb-item active"><?= $item['label'] ?></li>
                        <?php endif ?>
                    <?php endforeach ?>
                </ol>
            </div>
        </div>
    </div>

    <?php if (session()->getFlashdata('success')) : ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif ?>

    <?php if (session()->getFlashdata('errors')) : ?>
        <div class="alert alert-danger">
            <ul class="mb-0">
                <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach ?>
            </ul>
        </div>
    <?php endif ?>

    <div class="row row-cols-lg-2 gx-3">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <form action="<?= base_url('dashboard/property/update/' . $property['id']) ?>" method="post" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label class="form-label">Developer</label>
                            <select name="developer_id" class="form-select <?= (session('errors.developer_id') ? 'is-invalid' : '') ?>" required>
                                <option value="">-- Pilih Developer --</option>
                                <?php foreach ($developers as $dev): ?>
                                    <option value="<?= $dev['id'] ?>" <?= $dev['id'] == $property['developer_id'] ? 'selected' : '' ?>>
                                        <?= esc($dev['name']) ?>
                                    </option>
                                <?php endforeach ?>
                            </select>
                            <?php if (session('errors.developer_id')) : ?>
                                <div class="invalid-feedback">
                                    <?= esc(session('errors.developer_id')) ?>
                                </div>
                            <?php endif ?>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Title</label>
                            <input type="text" name="title" class="form-control <?= (session('errors.title') ? 'is-invalid' : '') ?>" value="<?= esc($property['title']) ?>">
                            <?php if (session('errors.title')) : ?>
                                <div class="invalid-feedback">
                                    <?= esc(session('errors.title')) ?>
                                </div>
                            <?php endif ?>
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
                            <textarea name="description" class="form-control <?= (session('errors.description') ? 'is-invalid' : '') ?>" rows="5"><?= esc($property['description']) ?></textarea>
                            <?php if (session('errors.description')) : ?>
                                <div class="invalid-feedback">
                                    <?= esc(session('errors.description')) ?>
                                </div>
                            <?php endif ?>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Upload Additional Images</label>
                            <input type="file" name="images[]" id="imageInput" class="form-control <?= (session('errors.images') ? 'is-invalid' : '') ?>" multiple>
                            <?php if (session('errors.images')) : ?>
                                <div class="invalid-feedback">
                                    <?= esc(session('errors.images')) ?>
                                </div>
                            <?php endif ?>
                            <div class="row mt-2" id="previewContainer"></div>
                            <small class="text-muted">You can select multiple images to upload.</small>
                        </div>

                        <button class="btn btn-primary">Save</button>
                    </form>

                    <hr class="my-4">

                    <h5>Existing Images</h5>
                    <div class="row">
                        <?php if (!empty($images)) : ?>
                            <?php foreach ($images as $img) : ?>
                                <div class="col-3 mb-3">
                                    <img src="<?= base_url('uploads/property/' . $img['filename']) ?>" class="img-thumbnail" style="width: 100%; height: auto;">
                                    <a href="<?= base_url('dashboard/property/deleteImage/' . $img['id']) ?>"
                                       class="btn btn-danger btn-sm mt-2"
                                       onclick="return confirm('Are you sure you want to delete this photo?')">
                                        Delete
                                    </a>
                                </div>
                            <?php endforeach ?>
                        <?php else : ?>
                            <p class="text-muted">No images uploaded yet.</p>
                        <?php endif ?>
                    </div>

                </div>
            </div>
        </div>
    </div>

</div>
<!-- End Container Fluid -->

<!-- Preview Script -->
<script>
document.getElementById('imageInput').addEventListener('change', function(e) {
    let container = document.getElementById('previewContainer');
    container.innerHTML = ''; // Clear previews

    for (let file of e.target.files) {
        if (file.type.startsWith('image/')) {
            let reader = new FileReader();
            reader.onload = function(e) {
                let div = document.createElement('div');
                div.classList.add('col-3', 'mb-2');
                div.innerHTML = `
                    <img src="${e.target.result}" class="img-thumbnail" style="width:100%; height:auto;">
                `;
                container.appendChild(div);
            }
            reader.readAsDataURL(file);
        }
    }
});
</script>

<script>
  const priceDisplay = document.getElementById('price_display');
  const priceHidden = document.getElementById('price');
  const priceText = document.getElementById('price_text');

  priceDisplay.addEventListener('input', function () {
    // Hapus semua karakter non angka
    let raw = this.value.replace(/\./g, '').replace(/[^0-9]/g, '');
    let number = parseInt(raw);

    if (!isNaN(number)) {
      // Format angka dengan titik ribuan (contoh: 650000000 -> 650.000.000)
      this.value = number.toLocaleString('id-ID');

      // Set nilai ke input hidden
      priceHidden.value = number;

      // Set nilai ke price_text dalam format singkat
      if (number >= 1_000_000_000) {
        priceText.value = (number / 1_000_000_000).toFixed(1).replace(/\.0$/, '') + ' M';
      } else if (number >= 1_000_000) {
        priceText.value = (number / 1_000_000).toFixed(1).replace(/\.0$/, '') + ' Juta';
      } else if (number >= 1_000) {
        priceText.value = (number / 1_000).toFixed(1).replace(/\.0$/, '') + ' Ribu';
      } else {
        priceText.value = number;
      }
    } else {
      this.value = '';
      priceHidden.value = '';
      priceText.value = '';
    }
  });

  // Trigger formatting saat pertama load jika ada nilai default
  window.addEventListener('DOMContentLoaded', function () {
    if (priceDisplay.value) {
      const event = new Event('input');
      priceDisplay.dispatchEvent(event);
    }
  });
</script>


<?= $this->endSection() ?>
