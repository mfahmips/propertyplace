<?= $this->extend('admin/layout/default') ?>
<?= $this->section('content') ?>

<?php if (session()->getFlashdata('success')): ?>
  <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
<?php endif; ?>

<div class="container-fluid">
  <div class="page-title-box">
    <h4 class="mb-0"><?= esc($title) ?></h4>
    <ol class="breadcrumb mb-0">
      <?php foreach($breadcrumb as $item): ?>
        <li class="breadcrumb-item<?= isset($item['url']) ? '' : ' active' ?>">
          <?php if(isset($item['url'])): ?>
            <a href="<?= esc($item['url']) ?>"><?= esc($item['label']) ?></a>
          <?php else: ?>
            <?= esc($item['label']) ?>
          <?php endif ?>
        </li>
      <?php endforeach ?>
    </ol>
  </div>

  <div class="card">
    <div class="card-body">
      <a href="<?= base_url('dashboard/developer/create') ?>" class="btn btn-primary">Add Developer</a>
    </div>
    <div class="table-responsive">
      <table class="table table-striped table-borderless table-centered">
        <thead class="table-light">
          <tr>
            <th>Logo</th>
            <th>Name</th>
            <th>Location</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($devs as $d): ?>
            <tr>
              <td>
                <img 
                  src="<?= base_url('uploads/developer/' . esc($d['logo'])) ?>" 
                  width="60" 
                  class="img-thumbnail" 
                  alt="<?= esc($d['name']) ?> Logo"
                  style=background-color:white;>
              </td>
              <td>
                <a href="<?= base_url('dashboard/property/developer/' . esc($d['slug'])) ?>">
                  <?= esc($d['name']) ?>
                </a>
              </td>
              <td><?= esc($d['location']) ?></td>
              <td>
                <a href="<?= base_url('dashboard/developer/edit/'.$d['id']) ?>" class="btn btn-sm btn-warning">Edit</a>
                <a href="<?= base_url('dashboard/developer/delete/'.$d['id']) ?>" 
                   class="btn btn-sm btn-danger" 
                   onclick="return confirm('Delete this developer?')">Delete</a>
              </td>
            </tr>
          <?php endforeach ?>
        </tbody>
      </table>
    </div>

    <!-- ✅ Tampilkan pager di bawah tabel -->
    <div class="card-body">
      <?= $pager->links('developers', 'bootstrap') ?>
    </div>

  </div>
</div>

<?= $this->endSection() ?>
