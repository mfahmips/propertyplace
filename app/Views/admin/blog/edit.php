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
      <form method="post" action="<?= base_url('dashboard/blog/update/' . $blog['id']) ?>" enctype="multipart/form-data">
    <?= csrf_field() ?>

        <div class="mb-3">
          <label for="title" class="form-label">Judul</label>
          <input type="text" class="form-control" name="title" id="title"
                 value="<?= esc($blog['title']) ?>" required>
        </div>

        <div class="mb-3">
          <label for="content" class="form-label">Konten</label>
          <input type="hidden" name="content" value="<?= set_value($blog['content']) ?>">
          <div id="snow-editor" style="min-height: 160px;"><?= set_value($blog['content']) ?></div>

          <?php $blog['content'] = form_error($blog['content']) ? set_value($blog['content']) : $blog['content'] ?>
          <input type="hidden" name="content" value="<?= html_escape($content) ?>">
          <div id="snow-editor" style="min-height: 160px;"><?= ($blog['content']) ?></div>

  
        </div>


        <div class="mb-3">
          <label class="form-label">Cover Saat Ini</label><br>
          <?php if ($blog['cover_image']): ?>
            <img src="<?= base_url('uploads/blog/' . esc($blog['cover_image'])) ?>" width="120" class="img-thumbnail" alt="Cover">
          <?php else: ?>
            <span class="text-muted">Tidak ada gambar</span>
          <?php endif ?>
        </div>

        <div class="mb-3">
          <label for="cover_image" class="form-label">Ganti Cover Image</label>
          <input type="file" class="form-control" name="cover_image" id="cover_image">
          <small class="text-muted">Kosongkan jika tidak ingin mengganti gambar.</small>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="<?= base_url('dashboard/blog') ?>" class="btn btn-secondary">Kembali</a>
      </form>
    </div>
  </div>
</div>

<!-- Integrasi QuillJS -->
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<script>
var quill = new Quill('#snow-editor', {
  theme: 'snow',
  modules: {
    toolbar: [
        [{ header: [1, 2, 3, 4, 5, 6, false] }],
        [{ font: [] }],
        ["bold", "italic"],
        ["link", "blockquote", "code-block", "image"],
        [{ list: "ordered" }, { list: "bullet" }],
        [{ script: "sub" }, { script: "super" }],
        [{ color: [] }, { background: [] }],
    ]
},
});
quill.on('text-change', function(delta, oldDelta, source) {
  document.querySelector("$blog['content']").value = quill.root.innerHTML;
});
</script>


<?= $this->endSection() ?>
