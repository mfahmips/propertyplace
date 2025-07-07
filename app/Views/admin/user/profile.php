<?= $this->extend('admin/layout/default') ?>
<?= $this->section('content') ?>


<div class="container-fluid">
  <!-- Page title & breadcrumb -->
  <div class="row">
    <div class="col-12">
      <div class="page-title-box">
        <h4 class="mb-0">Profile</h4>
        <ol class="breadcrumb mb-0">
          <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Dashboard</a></li>
          <li class="breadcrumb-item active">Profile</li>
        </ol>
      </div>
    </div>
  </div>

  <div class="row row-cols-lg-2 gx-3">
    <!-- Left: Card Profile -->
    <div class="col">
      <div class="card">
        <div class="card-body text-center">
          <img src="<?= base_url('uploads/user/' . ($user['foto'] ?? 'default.jpg')) ?>"
               class="rounded-circle img-thumbnail mb-3"
               style="width:120px; height:120px; object-fit:cover;"
               alt="Profile Photo">

          <h5 class="text-white mb-1"><?= esc($user['email']) ?></h5>
          <span class="badge bg-<?= $user['is_active'] ? 'success' : 'secondary' ?> mb-3">
            <?= $user['is_active'] ? 'Active' : 'Inactive' ?>
          </span>

          <div class="d-flex justify-content-center gap-4 mb-4">
            <div>
              <h6 class="text-white mb-1"><?= number_format($user['friends'] ?? 0) ?></h6>
              <small class="text-muted">Friends</small>
            </div>
            <div>
              <h6 class="text-white mb-1"><?= number_format($user['photos'] ?? 0) ?></h6>
              <small class="text-muted">Photos</small>
            </div>
            <div>
              <h6 class="text-white mb-1"><?= number_format($user['comments'] ?? 0) ?></h6>
              <small class="text-muted">Comments</small>
            </div>
          </div>

          <a href="<?= base_url('dashboard/user/edit/' . esc($user['slug'])) ?>"
             class="btn btn-outline-light btn-sm">
            Edit Profile
          </a>
        </div>
      </div>
    </div>

    <!-- Right: Read-only details -->
    <div class="col">
      <div class="card">
        <div class="card-header">
          <h5 class="card-title mb-0">Your Details</h5>
        </div>
        <div class="card-body">
          <div class="mb-1">
            <label class="form-label">Name</label>
            <input type="text" readonly class="form-control-plaintext" value="<?= esc($user['name']) ?>">
          </div>
          <div class="mb-1">
            <label class="form-label">Email</label>
            <input type="text" readonly class="form-control-plaintext" value="<?= esc($user['email']) ?>">
          </div>
          <div class="mb-1">
            <label class="form-label">Role</label>
            <input type="text" readonly class="form-control-plaintext" value="<?= esc(ucfirst($user['role'])) ?>">
          </div>
          <div class="mb-1">
            <label class="form-label">Joined On</label>
            <input type="text" readonly class="form-control-plaintext"
                   value="<?= date('d M Y', strtotime($user['created_at'])) ?>">
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?= $this->endSection() ?>

