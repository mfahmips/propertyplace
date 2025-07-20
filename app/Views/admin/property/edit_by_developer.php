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

                    <form action="<?= base_url('dashboard/developer/' . esc($developer['slug']) . '/property/' . esc($property['slug']) . '/update') ?>"
                          method="post" enctype="multipart/form-data">

                        <?= csrf_field() ?>

                        <input type="hidden" name="developer_id" value="<?= esc($developer['id']) ?>">

                        <div class="mb-3">
                            <label class="form-label">Developer</label>
                            <input type="text" class="form-control" value="<?= esc($developer['name']) ?>" readonly>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Title</label>
                            <input type="text" name="title" class="form-control <?= (session('errors.title') ? 'is-invalid' : '') ?>" value="<?= esc($property['title']) ?>" required>
                            <?php if (session('errors.title')) : ?>
                                <div class="invalid-feedback"><?= esc(session('errors.title')) ?></div>
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
                                <div class="invalid-feedback"><?= esc(session('errors.description')) ?></div>
                            <?php endif ?>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Upload Additional Images</label>
                            <input type="file" name="images[]" id="imageInput" class="form-control <?= (session('errors.images') ? 'is-invalid' : '') ?>" multiple>
                            <?php if (session('errors.images')) : ?>
                                <div class="invalid-feedback"><?= esc(session('errors.images')) ?></div>
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
                                    <form method="post" action="<?= base_url('dashboard/property/image/delete/' . $img['id']) ?>" onsubmit="return confirm('Are you sure you want to delete this photo?')">
                                        <?= csrf_field() ?>
                                        <button type="submit" class="btn btn-danger btn-sm mt-2">Delete</button>
                                    </form>
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

<!-- Preview Image Script -->
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

<!-- Price Format Script -->
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

// Auto trigger format on load
window.addEventListener('DOMContentLoaded', function () {
    if (priceDisplay.value) {
        const event = new Event('input');
        priceDisplay.dispatchEvent(event);
    }
});
</script>

<?= $this->endSection() ?>
