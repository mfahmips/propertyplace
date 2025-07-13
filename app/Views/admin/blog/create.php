<?= $this->extend('admin/layout/default') ?>
<?= $this->section('content') ?>

<?php if (session()->getFlashdata('success')): ?>
  <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
  <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
<?php endif; ?>

<div class="container-fluid">
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

  <div class="card">
    <div class="card-body">
      <form method="post" action="<?= base_url('dashboard/blog/store') ?>" enctype="multipart/form-data">
        <?= csrf_field() ?>

        <div class="mb-3">
          <label for="title" class="form-label">Judul</label>
          <input type="text" class="form-control" name="title" id="title" required>
        </div>

        <!-- Quill Editor -->
        <div class="mb-3">
          <label for="content" class="form-label">Konten</label>
          <!-- Textarea untuk menyimpan isi (DISUBMIT) -->
          <textarea id="snow-editor" name="content" rows="10" class="form-control" placeholder="Tuliskan isi pikiranmu..."></textarea>

        </div>



        <div class="mb-3">
          <label class="form-label">Cover Image</label>
          <input type="file" name="cover_image" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="<?= base_url('dashboard/blog') ?>" class="btn btn-secondary">Kembali</a>
      </form>
    </div>
  </div>
</div>


<!-- Integrasi QuillJS -->
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<script>
  var quill = new Quill('#snow-editor', {
    theme: 'snow'
  });
</script>







<?= $this->endSection() ?>
