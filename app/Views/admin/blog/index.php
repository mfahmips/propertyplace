<?= $this->extend('admin/layout/default') ?>
<?= $this->section('content') ?>

<?php if (session()->getFlashdata('success')): ?>
  <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
<?php endif; ?>

<div class="container-fluid">
  <div class="row">
        <div class="col-12">
  <div class="page-title-box">
    <h4 class="mb-0"><?= esc($title) ?></h4>
    <ol class="breadcrumb mb-0">
      <?php foreach ($breadcrumb as $item): ?>
        <li class="breadcrumb-item<?= isset($item['url']) ? '' : ' active' ?>">
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

 <!-- Start Table -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
      <a href="<?= base_url('dashboard/blog/create') ?>" class="btn btn-primary">+ Tambah Blog</a>
    </div>

    <div class="card-body">
    <div class="table-responsive">
      <table class="table table-striped table-borderless table-centered">
        <thead class="table-light">
          <tr>
            <th>Cover</th>
            <th>Judul</th>
            <th>Slug</th>
            <th>Tanggal</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($blogs as $b): ?>
            <tr>
              <td>
                <?php if ($b['cover_image']): ?>
                  <img 
                    src="<?= base_url('uploads/blog/' . esc($b['cover_image'])) ?>" 
                    width="60" 
                    class="img-thumbnail" 
                    style="background-color:white;" 
                    alt="cover blog">
                <?php else: ?>
                  <span class="text-muted">-</span>
                <?php endif ?>
              </td>
              <td><?= esc($b['title']) ?></td>
              <td><?= esc($b['slug']) ?></td>
              <td><?= date('d M Y', strtotime($b['created_at'])) ?></td>
              <td>
                <a href="<?= base_url('dashboard/blog/edit/' . esc($b['slug'])) ?>" class="btn btn-sm btn-warning">Edit</a>
                <form action="<?= base_url('dashboard/blog/delete/' . $b['id']) ?>" method="post" style="display:inline;">
                  <?= csrf_field() ?>
                  <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Hapus blog ini?')">Hapus</button>
                </form>
              </td>
            </tr>
          <?php endforeach ?>
        </tbody>
      </table>
    </div>

    <div class="card-body">
      <?= $pager->links('blogs', 'bootstrap') ?>
    </div>
  </div>
</div>

<?= $this->endSection() ?>
