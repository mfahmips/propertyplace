<?= $this->extend('admin/layout/default') ?>
<?= $this->section('content') ?>

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

  <?php if (session()->getFlashdata('errors')): ?>
    <div class="alert alert-danger">
      <ul class="mb-0">
        <?php foreach (session()->getFlashdata('errors') as $error): ?>
          <li><?= esc($error) ?></li>
        <?php endforeach ?>
      </ul>
    </div>
  <?php endif ?>

  <div class="card">
    <div class="card-body">
      <form action="<?= isset($document)
          ? base_url('dashboard/property/' . $property['slug'] . '/document/update/' . $document['id'])
          : base_url('dashboard/property/' . $property['slug'] . '/document/store')
        ?>"
        method="post" enctype="multipart/form-data">

        <div class="mb-3">
          <label class="form-label">Title</label>
          <input type="text" name="title" class="form-control" required
                 value="<?= old('title', $document['title'] ?? '') ?>">
        </div>

        <div class="mb-3">
          <label class="form-label">Type</label>
          <select name="type" class="form-select" required onchange="toggleInputs(this.value)">
            <option value="">-- Select Type --</option>
            <option value="pdf" <?= old('type', $document['type'] ?? '') === 'pdf' ? 'selected' : '' ?>>PDF</option>
            <option value="video" <?= old('type', $document['type'] ?? '') === 'video' ? 'selected' : '' ?>>Video</option>
          </select>
        </div>

        <div class="mb-3" id="pdfInput" style="display: none;">
          <label class="form-label">Upload PDF</label>
          <?php if (!empty($document['file_path'])): ?>
            <p>
              Current File:
              <a href="<?= base_url('uploads/property/documents/' . $document['file_path']) ?>" target="_blank">
                View PDF
              </a>
            </p>
          <?php endif ?>
          <input type="file" name="file" class="form-control" accept="application/pdf">
        </div>

        <div class="mb-3" id="videoInput" style="display: none;">
          <label class="form-label">Video URL</label>
          <input type="url" name="video_url" class="form-control" placeholder="https://..."
                 value="<?= old('video_url', $document['video_url'] ?? '') ?>">
        </div>

        <button class="btn btn-success"><?= isset($document) ? 'Update' : 'Save' ?></button>
        <a href="<?= base_url('dashboard/property/' . $property['slug'] . '/documents') ?>" class="btn btn-secondary">Cancel</a>
      </form>

      <hr>

      <h5 class="mt-5">Uploaded Documents</h5>

      <?php if (!empty($documents)): ?>
        <?php foreach ($documents as $doc): ?>
          <div class="card mb-3">
            <div class="card-body">
              <h5 class="card-title"><?= esc($doc['title']) ?></h5>

              <?php if ($doc['type'] === 'pdf'): ?>
                <a href="<?= base_url('uploads/property/documents/' . $doc['file_path']) ?>" target="_blank" class="btn btn-outline-primary btn-sm">View PDF</a>
              <?php else: ?>
                <div class="ratio ratio-16x9 mb-2">
                  <iframe src="<?= esc($doc['video_url']) ?>" frameborder="0" allowfullscreen></iframe>
                </div>
              <?php endif ?>

              <a href="<?= base_url('dashboard/property/' . $property['slug'] . '/documents?edit=' . $doc['id']) ?>"
                 class="btn btn-warning btn-sm">Edit</a>

              <a href="<?= base_url('dashboard/property/' . $property['slug'] . '/document/delete/' . $doc['id']) ?>"
                 class="btn btn-danger btn-sm"
                 onclick="return confirm('Are you sure you want to delete this document?')">Delete</a>
            </div>
          </div>
        <?php endforeach ?>
      <?php else: ?>
        <p class="text-muted">No documents uploaded yet.</p>
      <?php endif ?>
    </div>
  </div>
</div>

<script>
  function toggleInputs(value) {
    document.getElementById('pdfInput').style.display = (value === 'pdf') ? 'block' : 'none';
    document.getElementById('videoInput').style.display = (value === 'video') ? 'block' : 'none';
  }

  // Set state on page load
  window.addEventListener('DOMContentLoaded', function () {
    const selectedType = document.querySelector('[name="type"]').value;
    toggleInputs(selectedType);
  });
</script>

<?= $this->endSection() ?>
