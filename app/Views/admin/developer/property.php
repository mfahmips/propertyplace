<?= $this->extend('admin/layout/default') ?>
<?= $this->section('content') ?>

<div class="container-fluid">
  <!-- Judul dan Breadcrumb -->
  <div class="page-title-box">
    <h4 class="mb-0"><?= esc($title ?? 'Property Listing') ?></h4>
    <br>
    <ol class="breadcrumb mb-0">
      <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Dashboard</a></li>
      <li class="breadcrumb-item"><a href="<?= base_url('dashboard/developer') ?>">Developer</a></li>
      <li class="breadcrumb-item active"><?= esc($filterDeveloper['name'] ?? 'Property Listing') ?></li>
    </ol>
  </div>

  <!-- CARD PROPERTY LIST -->
  <div class="card">
    <div class="card-body">

      <!-- Header: Create, Export, Import -->
      <div class="mb-3 d-flex justify-content-between align-items-center flex-wrap gap-2">
        <!-- Tombol Create Property -->
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createPropertyModal">
          + Create Property<?= isset($filterDeveloper['name']) ? ' for ' . esc($filterDeveloper['name']) : '' ?>
        </button>

        <?php if (isset($filterDeveloper) && !empty($filterDeveloper['slug'])): ?>
  <div class="d-flex align-items-center gap-2">
    <!-- Export Data -->
    <a href="<?= base_url('dashboard/developer/' . esc($filterDeveloper['slug']) . '/export') ?>" 
       class="btn btn-success d-flex align-items-center gap-1">
      <i class="bi bi-download"></i> Export Data
    </a>

    <!-- Import Data (via Modal) -->
    <button type="button" 
            class="btn btn-info text-white d-flex align-items-center gap-1" 
            data-bs-toggle="modal" 
            data-bs-target="#importPropertyModal">
      <i class="bi bi-upload"></i> Import Data
    </button>
  </div>
<?php endif; ?>
</div>

<!-- Modal Import -->
<?php if (isset($filterDeveloper) && !empty($filterDeveloper['slug'])): ?>
<div class="modal fade" id="importPropertyModal" tabindex="-1" aria-labelledby="importPropertyLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow-lg">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title w-100 text-center" id="importPropertyLabel">
          <i class="bi bi-upload me-2"></i> Import Data Properti Developer
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>

      <form action="<?= base_url('dashboard/developer/' . esc($filterDeveloper['slug']) . '/import') ?>" 
            method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>
        <div class="modal-body">
          <div class="alert alert-info small d-flex align-items-start gap-2">
            <i class="bi bi-info-circle text-info fs-5"></i>
            <div>
              Pastikan file berformat <strong>.xlsx</strong> 
              dan menggunakan template hasil <em>Export</em> sebelumnya.
            </div>
          </div>

          <div class="mb-3">
            <label for="file" class="form-label fw-semibold">Pilih File Excel</label>
            <input type="file" name="file" id="file" class="form-control" accept=".xlsx,.xls" required>
          </div>
        </div>

        <div class="modal-footer d-flex justify-content-between">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
            <i class="bi bi-x-circle"></i> Batal
          </button>
          <button type="submit" class="btn btn-primary">
            <i class="bi bi-cloud-upload"></i> Import Sekarang
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
<?php endif; ?>


      <!-- Table Property -->
      <div class="table-responsive">
        <table class="table table-striped table-borderless align-middle">
          <thead class="table-light">
            <tr>
              <th>Image</th>
              <th>Name</th>
              <th>Details</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php if (!empty($properties)): ?>
              <?php foreach ($properties as $p): ?>
                <tr>
                  <td>
                    <?php 
                      $thumbnail = $p['thumbnail'] ?? '';
                      $thumbPath = FCPATH . 'uploads/property/thumbnail/' . $thumbnail;
                      if (!empty($thumbnail) && file_exists($thumbPath)): 
                    ?>
                      <img 
                        src="<?= base_url('uploads/property/thumbnail/' . esc($thumbnail)) ?>"
                        width="80" class="img-thumbnail rounded shadow-sm" alt="Thumbnail <?= esc($p['title']) ?>">
                    <?php else: ?>
                      <span class="text-muted">No Image</span>
                    <?php endif; ?>
                  </td>

                  <td><?= esc($p['title']) ?></td>

                  <td>
                    <a href="<?= base_url('dashboard/developer/' . esc($filterDeveloper['slug']) . '/' . esc($p['slug'])) ?>" 
                       class="btn btn-sm btn-secondary">
                      Details
                    </a>
                  </td>

                  <td>
                    <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editPropertyModal<?= $p['id'] ?>">
                      Edit
                    </button>
                    <a href="<?= base_url('dashboard/developer/' . esc($filterDeveloper['slug']) . '/property/' . esc($p['id']) . '/delete') ?>" 
                       class="btn btn-sm btn-danger"
                       onclick="return confirm('Delete this property?')">
                      Delete
                    </a>
                  </td>
                </tr>
              <?php endforeach ?>
            <?php else: ?>
              <tr>
                <td colspan="4" class="text-center text-muted">No property found.</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-4">
          <?= $pager->links('properties', 'bootstrap') ?>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal Create -->
  <div class="modal fade" id="createPropertyModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content">
        <form action="<?= base_url('dashboard/developer/' . esc($filterDeveloper['slug']) . '/property/store') ?>" 
              method="post" enctype="multipart/form-data">
          <?= csrf_field() ?>
          <div class="modal-header">
            <h5 class="modal-title">
              Create Property<?= isset($filterDeveloper['name']) ? ' for ' . esc($filterDeveloper['name']) : '' ?>
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>

          <div class="modal-body">
            <div class="mb-3">
              <label class="form-label">Property Name</label>
              <input type="text" name="title" class="form-control" required>
            </div>

            <div class="mb-3">
              <label class="form-label">Thumbnail</label>
              <input type="file" name="thumbnail" class="form-control" accept="image/*" required>
              <small class="text-muted">Thumbnail akan digunakan sebagai gambar utama properti.</small>
            </div>
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary">Save</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Modal Edit -->
  <?php foreach ($properties as $p): ?>
    <div class="modal fade" id="editPropertyModal<?= $p['id'] ?>" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
          <form action="<?= base_url('dashboard/developer/' . esc($filterDeveloper['slug']) . '/property/' . esc($p['slug']) . '/update') ?>" 
                method="post" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <div class="modal-header">
              <h5 class="modal-title">Edit Property: <?= esc($p['title']) ?></h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
              <div class="mb-3">
                <label class="form-label">Property Name</label>
                <input type="text" name="title" class="form-control" value="<?= esc($p['title']) ?>" required>
              </div>

              <div class="mb-3">
                <label class="form-label">Edit Thumbnail</label>
                <input type="file" name="thumbnail" class="form-control" accept="image/*">
                <small class="text-muted">Kosongkan jika tidak ingin mengganti thumbnail.</small>

                <?php if (!empty($p['thumbnail']) && file_exists(FCPATH . 'uploads/property/thumbnail/' . $p['thumbnail'])): ?>
                  <div class="mt-3">
                    <img src="<?= base_url('uploads/property/thumbnail/' . esc($p['thumbnail'])) ?>" width="120" class="img-thumbnail">
                  </div>
                <?php else: ?>
                  <p class="text-muted fst-italic mt-2">Thumbnail belum tersedia.</p>
                <?php endif; ?>
              </div>
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
              <button type="submit" class="btn btn-primary">Update</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  <?php endforeach; ?>
</div>

<?= $this->endSection() ?>
