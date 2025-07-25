<?= $this->extend('admin/layout/default') ?>
<?= $this->section('content') ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="mb-0"><?= esc($title) ?></h4>
                <ol class="breadcrumb mb-0">
                    <?php foreach ($breadcrumb as $item) : ?>
                        <li class="breadcrumb-item"><?= isset($item['url']) ? '<a href="'.$item['url'].'">'.esc($item['label']).'</a>' : esc($item['label']) ?></li>
                    <?php endforeach ?>
                </ol>
            </div>
        </div>
    </div>

    <?php if (session()->getFlashdata('success')) : ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php endif ?>

    <?php if (session()->getFlashdata('error')) : ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
    <?php endif ?>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addUserModal">Tambah User</button>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-borderless table-centered">
                            <thead class="table-light">
                                <tr>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($users)) : ?>
                                    <tr><td colspan="5" class="text-center text-muted">Tidak ada data.</td></tr>
                                <?php else : ?>
                                    <?php foreach ($users as $user) : ?>
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center gap-2">
                                                    <img src="<?= !empty($user['foto']) ? base_url('uploads/user/' . esc($user['foto'])) : 'https://via.placeholder.com/50x50?text=No+Image' ?>" width="50" height="50" class="rounded-circle">
                                                    <div><strong><?= esc($user['name']) ?></strong></div>
                                                </div>
                                            </td>
                                            <td><?= esc($user['email']) ?></td>
                                            <td><span class="badge bg-info"><?= esc($user['role']) ?></span></td>
                                            <td>
                                                <span class="badge <?= $user['is_active'] ? 'bg-success' : 'bg-danger' ?>">
                                                    <?= $user['is_active'] ? 'Active' : 'Inactive' ?>
                                                </span>
                                            </td>
                                            <td>
                                                <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editUserModal<?= $user['id'] ?>">Edit</button>
                                                <a href="<?= base_url('dashboard/user/delete/' . $user['id']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Hapus user ini?')">Delete</a>
                                            </td>
                                        </tr>
                                    <?php endforeach ?>
                                <?php endif ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Add User -->
<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form action="<?= base_url('dashboard/user/store') ?>" method="post" enctype="multipart/form-data" class="modal-content">
            <?= csrf_field() ?>
            <div class="modal-header">
                <h5 class="modal-title">Tambah User Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div class="mb-3">
                    <label>Nama</label>
                    <input type="text" name="name" class="form-control" value="<?= old('name') ?>" required>
                </div>

                <div class="mb-3">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" value="<?= old('email') ?>" required>
                </div>

                <div class="mb-3">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Role</label>
                    <select name="role" class="form-select" required>
                        <option value="" disabled <?= old('role') ? '' : 'selected' ?>>-- Pilih Role --</option>
                        <?php foreach ($roles as $role): ?>
                            <option value="<?= $role ?>" <?= old('role') === $role ? 'selected' : '' ?>><?= ucfirst($role) ?></option>
                        <?php endforeach ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label>Foto</label>
                    <input type="file" name="foto" id="foto" class="form-control" accept="image/*" onchange="previewImage(event)">
                    <div class="mt-2">
                        <img id="preview" src="https://via.placeholder.com/150" class="img-thumbnail" style="max-width:150px; aspect-ratio:1/1; object-fit:cover;">
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit User -->
<?php foreach ($users as $user) : ?>
<div class="modal fade" id="editUserModal<?= $user['id'] ?>" tabindex="-1" aria-labelledby="editUserModalLabel<?= $user['id'] ?>" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form action="<?= base_url('dashboard/user/update/' . $user['id']) ?>" method="post" enctype="multipart/form-data" class="modal-content">
            <?= csrf_field() ?>
            <div class="modal-header">
                <h5 class="modal-title">Edit User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div class="mb-3">
                    <label>Nama</label>
                    <input type="text" name="name" class="form-control" value="<?= esc($user['name']) ?>" required>
                </div>

                <div class="mb-3">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" value="<?= esc($user['email']) ?>" required>
                </div>

                <div class="mb-3">
                    <label>Password (Kosongkan jika tidak diubah)</label>
                    <input type="password" name="password" class="form-control">
                </div>

                <div class="mb-3">
                    <label>Role</label>
                    <select name="role" class="form-select" required>
                        <option value="" disabled>-- Pilih Role --</option>
                        <?php foreach ($roles as $role): ?>
                            <option value="<?= $role ?>" <?= $user['role'] === $role ? 'selected' : '' ?>><?= ucfirst($role) ?></option>
                        <?php endforeach ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label>Foto</label>
                    <input type="file" name="foto" class="form-control" accept="image/*" onchange="previewEditImage(event, <?= $user['id'] ?>)">
                    <div class="mt-2">
                        <img id="previewEdit<?= $user['id'] ?>" src="<?= !empty($user['foto']) ? base_url('uploads/user/' . $user['foto']) : 'https://via.placeholder.com/150' ?>" class="img-thumbnail" style="max-width:150px; aspect-ratio:1/1; object-fit:cover;">
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            </div>
        </form>
    </div>
</div>
<?php endforeach ?>

<script>
function previewImage(event) {
    const reader = new FileReader();
    reader.onload = () => { document.getElementById('preview').src = reader.result; };
    reader.readAsDataURL(event.target.files[0]);
}

function previewEditImage(event, id) {
    const reader = new FileReader();
    reader.onload = () => { document.getElementById('previewEdit' + id).src = reader.result; };
    reader.readAsDataURL(event.target.files[0]);
}
</script>

<?= $this->endSection() ?>
