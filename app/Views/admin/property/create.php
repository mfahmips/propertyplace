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

    <div class="row row-cols-lg-2 gx-3">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <form action="<?= base_url('dashboard/property/store') ?>" method="post" enctype="multipart/form-data">
                        <?= csrf_field() ?>

                        <div class="mb-3">
                            <label for="simpleinput" class="form-label">Name</label>
                            <input type="text" name="title" class="form-control" value="<?= old('title') ?>">
                            <?php if (isset($errors['title'])) : ?>
                                <div class="text-danger"><?= $errors['title'] ?></div>
                            <?php endif ?>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Location</label>
                            <input type="text" name="location" class="form-control" value="<?= old('location') ?>">
                            <?php if (isset($errors['location'])) : ?>
                                <div class="text-danger"><?= $errors['location'] ?></div>
                            <?php endif ?>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Price</label>
                            <input type="text" name="price_text" class="form-control" value="<?= old('price_text') ?>" placeholder="cth: 1.2 M, 750 Juta, 500 jt-an" required>
                            <?php if (isset($errors['price_text'])) : ?>
                                <div class="text-danger"><?= $errors['price_text'] ?></div>
                            <?php endif ?>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control" rows="5"><?= old('description') ?></textarea>
                            <?php if (isset($errors['description'])) : ?>
                                <div class="text-danger"><?= $errors['description'] ?></div>
                            <?php endif ?>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Upload Photos</label>
                            <input type="file" name="images[]" class="form-control" multiple>
                            <small class="text-muted">You can select multiple images.</small>
                            <?php if (isset($errors['images'])) : ?>
                                <div class="text-danger"><?= $errors['images'] ?></div>
                            <?php endif ?>
                        </div>

                        <button class="btn btn-primary">Save</button>
                    </form>

                </div>
            </div>
        </div>
    </div>

</div>
<!-- End Container Fluid -->

<?= $this->endSection() ?>

<?php if (session()->getFlashdata('errors')): ?>
    <div class="alert alert-danger">
        <ul>
            <?php foreach (session()->getFlashdata('errors') as $error): ?>
                <li><?= esc($error) ?></li>
            <?php endforeach ?>
        </ul>
    </div>
<?php endif ?>
