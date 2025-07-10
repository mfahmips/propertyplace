<?= $this->extend('admin/layout/default') ?>
<?= $this->section('content') ?>

<div class="container-fluid">
    <!-- ========== Page Title Start ========== -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="mb-0"><?= esc($title) ?></h4>
                <ol class="breadcrumb mb-0">
                    <?php foreach ($breadcrumb as $item) : ?>
                        <?php if (isset($item['url'])) : ?>
                            <li class="breadcrumb-item"><a href="<?= $item['url'] ?>"><?= esc($item['label']) ?></a></li>
                        <?php else : ?>
                            <li class="breadcrumb-item active"><?= esc($item['label']) ?></li>
                        <?php endif ?>
                    <?php endforeach ?>
                </ol>
            </div>
        </div>
    </div>

    <!-- Flash messages -->
    <?php if (session()->getFlashdata('success')) : ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php endif ?>

    <?php if (session()->getFlashdata('error')) : ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
    <?php endif ?>

    <!-- Start Table -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <a href="<?= base_url('dashboard/user/create') ?>" class="btn btn-primary btn-sm">Add New</a>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-borderless table-centered">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Role</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($users)) : ?>
                                    <tr>
                                        <td colspan="6" class="text-center text-muted">No users found.</td>
                                    </tr>
                                <?php else : ?>
                                    <?php foreach ($users as $user) : ?>
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center gap-1">
                                                    <?php if (!empty($user['foto'])) : ?>
                                                        <img src="<?= base_url('uploads/user/' . esc($user['foto'])) ?>" width="50" height="50" class="rounded-circle">
                                                    <?php else : ?>
                                                        <img src="https://via.placeholder.com/50x50?text=No+Image" class="rounded-circle">
                                                    <?php endif ?>
                                                    <div class="d-block">
                                                            <h5 class="mb-0"><?= esc($user['name']) ?></h5>
                                                    </div>
                                                </div>
                                            </td>
                                            <td><?= esc($user['email']) ?></td>
                                            <td><span class="badge bg-info"><?= esc($user['role']) ?></span></td>
                                            <td>
                                                <?php if ((int) $user['is_active'] === 1) : ?>
                                                    <span class="badge bg-success">Active</span>
                                                <?php else : ?>
                                                    <span class="badge bg-danger">Inactive</span>
                                                <?php endif ?>
                                            </td>
                                            <td>
                                                <a href="<?= base_url('dashboard/user/edit/' . esc($user['slug'])) ?>" class="btn btn-warning btn-sm">Edit</a>

                                                <?php if (session()->get('role') === 'admin') : ?>
                                                    <a href="<?= base_url('dashboard/user/delete/' . $user['id']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Delete this user?')">
                                                        Delete
                                                    </a>
                                                <?php endif ?>
                                            </td>
                                        </tr>
                                    <?php endforeach ?>
                                <?php endif ?>
                            </tbody>
                        </table>
                    </div>
                </div> <!-- end card-body -->
            </div> <!-- end card -->
        </div> <!-- end col -->
    </div> <!-- end row -->
</div> <!-- end container-fluid -->

<?= $this->endSection() ?>
