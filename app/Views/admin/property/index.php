<?= $this->extend('admin/layout/default') ?>
<?= $this->section('content') ?>

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

      <div class="mb-3">
        <?php if (session('role') === 'admin') : ?>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createPropertyModal">
                + Create Property<?= isset($filterDeveloper['name']) ? ' for ' . esc($filterDeveloper['name']) : '' ?>
            </button>
        <?php endif; ?>

      </div>

      <div class="table-responsive">
        <table class="table table-striped table-borderless">
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
              <?php foreach($properties as $p): ?>
                <tr>
                  <td>
                    <?php 
                      $thumbnail = $p['thumbnail'] ?? '';
                      $thumbPath = FCPATH . 'uploads/property/thumbnail/' . $thumbnail;
                      if (!empty($thumbnail) && file_exists($thumbPath)): 
                    ?>
                      <div class="d-inline-block text-center">
                        <img 
                          src="<?= base_url('uploads/property/thumbnail/' . esc($thumbnail)) ?>"
                          width="80"
                          class="img-thumbnail"
                          alt="Thumbnail <?= esc($p['title']) ?>">
                      </div>
                    <?php else: ?>
                      <div class="text-muted" style="font-size: 0.85rem;">Belum Tersedia</div>
                    <?php endif; ?>
                  </td>

                  <td><?= esc($p['title']) ?></td>

                  <td>
                    <a href="<?= isset($filterDeveloper) ? base_url('dashboard/developer/' . esc($filterDeveloper['slug']) . '/property/' . esc($p['slug']) . '/detail') : '#' ?>" 
                       class="btn btn-sm btn-secondary">
                       Details
                    </a>

                  </td>

                  <td>
                    <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editPropertyModal<?= $p['id'] ?>">
                      Edit
                    </button>
                    <a href="<?= isset($filterDeveloper) ? base_url('dashboard/developer/' . esc($filterDeveloper['slug']) . '/property/' . esc($p['id']) . '/delete') : '#' ?>" 
   class="btn btn-sm btn-danger"
   onclick="return confirm('Delete this property?')">
   Delete
</a>

                  </td>
                </tr>
              <?php endforeach ?>
            <?php else: ?>
              <tr>
                <td colspan="5" class="text-center text-muted">No property found.</td>
              </tr>
            <?php endif ?>
          </tbody>

        </table>

        <div class="d-flex justify-content-center mt-4">
          <?= $pager->links() ?>
        </div>

      </div>
    </div>
  </div>
</div>

<!-- MODAL CREATE PROPERTY -->
<div class="modal fade" id="createPropertyModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <form action="<?= isset($filterDeveloper) ? base_url('dashboard/developer/' . esc($filterDeveloper['slug']) . '/property/store') : '#' ?>"  method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>
        <div class="modal-header">
          <h5 class="modal-title">Create Property for <?= isset($filterDeveloper) ? esc($filterDeveloper['name']) : '#' ?>"</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">

          <input type="hidden" name="developer_id" value="<?= isset($filterDeveloper) ? esc($filterDeveloper['id']) : '#' ?>">

          <div class="mb-3">
            <label class="form-label">Property</label>
            <input type="text" name="title" class="form-control" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Thumbnail</label>
            <input type="file" name="thumbnail" class="form-control" accept="image/*" required>
            <small class="text-muted">Thumbnail akan digunakan sebagai gambar utama.</small>
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


<!-- MODAL EDIT PROPERTY -->
<?php foreach($properties as $p): ?>
<div class="modal fade" id="editPropertyModal<?= $p['id'] ?>" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <form action="<?= isset($filterDeveloper) ? base_url('dashboard/developer/' . esc($filterDeveloper['slug']) . '/property/' . esc($p['slug']) . '/update') : '#' ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>
        <div class="modal-header">
          <h5 class="modal-title">Edit Property: <?= esc($p['title']) ?></h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">

          <input type="hidden" name="developer_id" value="<?= isset($filterDeveloper) ? esc($filterDeveloper['id']) : '#' ?>">

          <div class="mb-3">
            <label class="form-label">Judul Property</label>
            <input type="text" name="title" class="form-control" value="<?= esc($p['title']) ?>" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Edit Thumbnail</label>

            <input type="file" name="thumbnail" class="form-control" accept="image/*">
            <small class="text-muted">Kosongkan jika tidak ingin mengganti thumbnail.</small>

            <?php if (!empty($p['thumbnail']) && file_exists(FCPATH . 'uploads/property/thumbnail/' . $p['thumbnail'])): ?>
              <!-- Tambahkan mt-3 untuk jarak atas -->
              <div class="mt-3">
                <img src="<?= base_url('uploads/property/thumbnail/' . esc($p['thumbnail'])) ?>" width="120" class="img-thumbnail">
              </div>
            <?php else: ?>
              <p class="text-muted fst-italic mt-2">Thumbnail belum tersedia.</p>
            <?php endif ?>
          </div>


        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kembali</button>
          <button type="submit" class="btn btn-primary">Update</button>
        </div>

      </form>
    </div>
  </div>
</div>
<?php endforeach; ?>


<?= $this->endSection() ?>
