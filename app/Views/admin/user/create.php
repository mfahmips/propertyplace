<?= $this->extend('admin/layout/default') ?>
<?= $this->section('content') ?>

<?php $errors = session()->getFlashdata('errors') ?? []; ?>

<div class="container-fluid">
    <!-- Page Title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="mb-0"><?= esc($title) ?></h4>
                <ol class="breadcrumb mb-0">
                    <?php foreach ($breadcrumb as $item) : ?>
                        <li class="breadcrumb-item<?= isset($item['url']) ? '' : ' active' ?>">
                            <?= isset($item['url']) ? '<a href="' . $item['url'] . '">' . $item['label'] . '</a>' : $item['label'] ?>
                        </li>
                    <?php endforeach ?>
                </ol>
            </div>
        </div>
    </div>

    <!-- Form Tambah User -->
    <div class="row row-cols-lg-2 gx-3">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <form action="<?= base_url('dashboard/user/store') ?>" method="post" enctype="multipart/form-data">
                        
                        <!-- Nama -->
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama</label>
                            <input type="text" name="name" class="form-control" value="<?= old('name') ?>" required>
                            <?php if (isset($errors['name'])) : ?>
                                <small class="text-danger"><?= esc($errors['name']) ?></small>
                            <?php endif ?>
                        </div>

                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" value="<?= old('email') ?>" required>
                            <?php if (isset($errors['email'])) : ?>
                                <small class="text-danger"><?= esc($errors['email']) ?></small>
                            <?php endif ?>
                        </div>

                        <!-- Password -->
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" required>
                            <?php if (isset($errors['password'])) : ?>
                                <small class="text-danger"><?= esc($errors['password']) ?></small>
                            <?php endif ?>
                        </div>

                        <!-- Role -->
                        <div class="mb-3">
                            <label for="role" class="form-label">Role</label>
                            <select name="role" class="form-select" required>
                                <option value="" disabled selected>-- Pilih Role --</option>
                                <?php foreach ($roles as $role): ?>
                                    <option value="<?= $role ?>" <?= old('role') === $role ? 'selected' : '' ?>>
                                        <?= ucfirst($role) ?>
                                    </option>
                                <?php endforeach ?>
                            </select>
                            <?php if (isset($errors['role'])) : ?>
                                <small class="text-danger"><?= esc($errors['role']) ?></small>
                            <?php endif ?>
                        </div>

                        <!-- Foto -->
                        <div class="mb-3">
                            <label for="foto" class="form-label">Foto</label>
                            <input type="file" name="foto" id="foto" class="form-control" accept="image/*" onchange="previewImage(event)">
                            <div class="mt-2">
                                <img id="preview" src="https://via.placeholder.com/300" class="img-thumbnail" style="max-width: 150px; aspect-ratio: 1/1; object-fit: cover;">
                            </div>
                            <?php if (isset($errors['foto'])) : ?>
                                <small class="text-danger"><?= esc($errors['foto']) ?></small>
                            <?php endif ?>
                        </div>

                        <script>
                            function previewImage(event) {
                                const reader = new FileReader();
                                reader.onload = function() {
                                    document.getElementById('preview').src = reader.result;
                                };
                                reader.readAsDataURL(event.target.files[0]);
                            }
                        </script>

                        <!-- Tombol Simpan -->
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
