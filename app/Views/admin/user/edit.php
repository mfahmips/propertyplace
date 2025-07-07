
<?= $this->extend('admin/layout/default') ?>
<?= $this->section('content') ?>

<div class="container-fluid">
  <!-- Page Title -->
  <div class="row">
    <div class="col-12">
      <div class="page-title-box">
        <h4 class="mb-0">Edit Profile</h4>
        <ol class="breadcrumb mb-0">
          <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Dashboard</a></li>
          <li class="breadcrumb-item"><a href="<?= base_url('dashboard/user/profile') ?>">Profile</a></li>
          <li class="breadcrumb-item active">Edit Profile</li>
        </ol>
      </div>
    </div>
  </div>

  <div class="row justify-content">
    <div class="col-md-8">
      <div class="card">
        <div class="card-body">
          <?= form_open_multipart(base_url('dashboard/user/update/'.esc($user['slug'])), ['method'=>'post']) ?>
            <?= csrf_field() ?>

            <!-- Name -->
            <div class="mb-3">
              <label for="name" class="form-label">Name</label>
              <input type="text" id="name" name="name" class="form-control" 
                     value="<?= old('name', esc($user['name'])) ?>" required>
              <?php if(session('validation') && session('validation')->hasError('name')): ?>
                <div class="text-danger small"><?= session('validation')->getError('name') ?></div>
              <?php endif ?>
            </div>

            <!-- Email -->
            <div class="mb-3">
              <label for="email" class="form-label">Email</label>
              <input type="email" id="email" name="email" class="form-control" 
                     value="<?= old('email', esc($user['email'])) ?>" required>
              <?php if(session('validation') && session('validation')->hasError('email')): ?>
                <div class="text-danger small"><?= session('validation')->getError('email') ?></div>
              <?php endif ?>
            </div>

            <!-- Password -->
            <div class="mb-3">
              <label for="password" class="form-label">Password <small>(leave blank to keep current)</small></label>
              <input type="password" id="password" name="password" class="form-control">
              <?php if(session('validation') && session('validation')->hasError('password')): ?>
                <div class="text-danger small"><?= session('validation')->getError('password') ?></div>
              <?php endif ?>
            </div>

            <?php if(session()->get('role') === 'admin'): ?>
            <!-- Role -->
            <div class="mb-3">
              <label for="role" class="form-label">Role</label>
              <select id="role" name="role" class="form-select">
                <?php foreach($roles as $roleOption): ?>
                  <option value="<?= esc($roleOption) ?>" 
                    <?= old('role', $user['role']) === $roleOption ? 'selected' : '' ?>>
                    <?= ucfirst($roleOption) ?>
                  </option>
                <?php endforeach ?>
              </select>
            </div>

            <!-- Active Status -->
            <div class="mb-3">
              <label for="is_active" class="form-label">Status</label>
              <select id="is_active" name="is_active" class="form-select">
                <option value="1" <?= old('is_active',(string)$user['is_active']) === '1' ? 'selected' : '' ?>>Active</option>
                <option value="0" <?= old('is_active',(string)$user['is_active']) === '0' ? 'selected' : '' ?>>Inactive</option>
              </select>
            </div>
            <?php else: ?>
              <input type="hidden" name="role" value="<?= esc($user['role']) ?>">
              <input type="hidden" name="is_active" value="<?= esc($user['is_active']) ?>">
            <?php endif ?>

            <!-- Photo -->
            <div class="mb-4">
              <label for="foto" class="form-label">Profile Photo</label>
              <input class="form-control" type="file" id="foto" name="foto" accept="image/*" onchange="previewUserImage(event,'userPreview')">
              <div class="mt-3 text-center">
                <img id="userPreview" 
                     src="<?= base_url('uploads/user/'.($user['foto'] ?? 'default.jpg')) ?>" 
                     class="rounded-circle" style="width:100px;height:100px;object-fit:cover;">
              </div>
              <?php if(session('validation') && session('validation')->hasError('foto')): ?>
                <div class="text-danger small text-center"><?= session('validation')->getError('foto') ?></div>
              <?php endif ?>
            </div>

            <script>
            function previewUserImage(event, id) {
              const reader = new FileReader();
              reader.onload = e => document.getElementById(id).src = e.target.result;
              reader.readAsDataURL(event.target.files[0]);
            }
            </script>

            <div class="text-end">
              <button type="submit" class="btn btn-primary">Update Profile</button>
              <a href="<?= base_url('dashboard/user/profile') ?>" class="btn btn-secondary">Cancel</a>
            </div>
          <?= form_close() ?>
        </div>
      </div>
    </div>
  </div>
</div>

<?= $this->endSection() ?>
