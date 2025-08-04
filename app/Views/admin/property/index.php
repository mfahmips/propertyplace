<?= $this->extend('admin/layout/default') ?>
<?= $this->section('content') ?>

<div class="container-fluid">
  <div class="page-title-box">
    <h4 class="mb-0"><?= esc($title ?? 'Property Listing') ?></h4><br>
    <ol class="breadcrumb mb-0">
      <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Dashboard</a></li>
      <li class="breadcrumb-item active">Property Listing</li>
    </ol>
  </div>

  <?php $role = session('role'); ?>

  <?php if (in_array($role, ['sales'])): ?>
  <div class="row g-4">


  <div class="d-flex justify-content-center">
  <form method="get"
        class="filter-wrapper d-flex flex-wrap align-items-center gap-2 p-2 px-3 rounded"
        style="max-width: 700px; width: 100%;">
    
    <!-- Input Search -->
    <div class="input-group" style="flex: 1 1">
            <span class="input-group-text bg-transparent border-0">
              <i class="fa-solid fa-magnifying-glass"></i>
            </span>
            <input type="text" name="search" class="form-control border-0"
                   placeholder="Search ..." value="<?= esc($search ?? '') ?>">
          </div>

    <!-- Dropdown Developer -->
    <select name="developer_id" class="form-select border-0"
            style="flex: 1 1">
      <option value="">Pilih Developer</option>
      <?php foreach ($developers as $dev): ?>
        <option value="<?= $dev['id'] ?>" <?= ($developerId ?? '') == $dev['id'] ? 'selected' : '' ?>>
          <?= esc($dev['name']) ?>
        </option>
      <?php endforeach ?>
    </select>

    <!-- Tombol -->
    <button type="submit" class="btn btn-outline-dark rounded-pill px-4 py-1" style="flex-shrink: 0;">
      Search
    </button>
  </form>
</div>


<style>
.filter-wrapper {
  background-color: #1D2329;
  border: 1px solid #333;
  box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
}

/* Warna input dan dropdown */
.filter-wrapper input::placeholder,
.filter-wrapper select option {
  color: rgba(255, 255, 255, 0.7);
}

.filter-wrapper .form-control,
.filter-wrapper .form-select {
  min-height: 38px;
  box-shadow: none;
}

.filter-wrapper input::placeholder {
  color: rgba(255, 255, 255, 0.5); /* Putih redup */
  font-weight: 400;
}

/* Responsive mobile */
@media (max-width: 576px) {
  .filter-wrapper {
    flex-direction: column;
    align-items: stretch;
    border-radius: 20px;
  }

  .filter-wrapper button {
    width: 100%;
    margin-top: 5px;
  }
}

</style>


      <?php foreach ($properties as $property): ?>
        <div class="col-sm-6 col-md-4 col-lg-3">
          <div class="card h-100 shadow-sm border-0">
            <div class="ratio ratio-4x3">
              <img src="<?= base_url('uploads/property/thumbnail/' . ($property['thumbnail'] ?? 'default.jpg')) ?>"
                   class="card-img-top object-fit-cover"
                   alt="<?= esc($property['title']) ?>">
            </div>
            <div class="card-body">
              <h5 class="fw-semibold mb-1 text-center"><?= esc($property['title']) ?></h5>
              <p class="text-muted small mb-2 text-center"><?= esc($property['developer_name']) ?></p>
              <button class="btn btn-sm btn-outline-primary w-100" data-bs-toggle="modal" data-bs-target="#modalDetail<?= $property['id'] ?>">
                  Lihat Detail
              </button>
              <!-- Modal -->
              <div class="modal fade" id="modalDetail<?= $property['id'] ?>" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-xl modal-dialog-centered">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title"><?= esc($property['title']) ?> - <?= esc($property['developer_name']) ?></h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    
                    <div class="modal-body">
                      <!-- Swiper Slider -->
                      <div class="swiper mySwiper<?= $property['id'] ?>">
                        <div class="swiper-wrapper">
                          <?php foreach ($property['Types'] as $type): ?>
                            <?php
                            $images = model('PropertyTypeImagesModel')
                                ->where('property_id', $property['id'])
                                ->where('type_id', $type['id'])
                                ->findAll();
                            ?>
                            <?php foreach ($images as $img): ?>
                            <div class="swiper-slide">
                              <img src="<?= base_url('uploads/property_type_images/' . $img['image']) ?>" class="img-fluid w-100 rounded" alt="<?= esc($img['name_floor']) ?>">
                              <div class="text-muted small mt-1"><?= esc($img['name_floor']) ?></div>
                            </div>
                            <?php endforeach; ?>
                          <?php endforeach; ?>
                        </div>
                        <div class="swiper-pagination"></div>
                      </div>

                      <!-- Property Details -->
                      <div class="mt-4">
                        <?php foreach ($property['Types'] as $type): ?>
                            <p><strong>Tipe Unit:</strong> <?= esc($type['type_unit']) ?> - <?= esc($type['name']) ?></p>
                        <?php endforeach; ?>

                        <p><strong>Harga:</strong> <?= esc($property['price_text']) ?></p>
                        <p><strong>Deskripsi:</strong><br><?= esc($property['description']) ?></p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
              <script>
              <?php foreach ($properties as $p): ?>
              new Swiper(".mySwiper<?= $p['id'] ?>", {
                  loop: true,
                  pagination: {
                      el: ".swiper-pagination",
                  },
              });
              <?php endforeach; ?>
              </script>


            </div>
          </div>
        </div>
      <?php endforeach ?>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-4">
      <?= $pager->links('property', 'bootstrap') ?>
    </div>
  <?php endif; ?>

  <?php if ($role === 'admin'): ?>
  <div class="card">
    <div class="card-body">

      <div class="mb-3">
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createPropertyModal">
          + Create Property<?= isset($filterDeveloper['name']) ? ' for ' . esc($filterDeveloper['name']) : '' ?>
        </button>
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
              <?php foreach ($properties as $p): ?>
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
                    <a href="<?= base_url('dashboard/property/' . esc($p['id']) . '/delete') ?>" 
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
            <?php endif ?>
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
        <form action="<?= isset($filterDeveloper) 
            ? base_url('dashboard/developer/' . esc($filterDeveloper['slug']) . '/property/store') 
            : base_url('dashboard/property/store') ?>" method="post" enctype="multipart/form-data">

          <?= csrf_field() ?>
          <div class="modal-header">
            <h5 class="modal-title">
              Create Property<?= isset($filterDeveloper['name']) ? ' for ' . esc($filterDeveloper['name']) : '' ?>
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>

          <div class="modal-body">
            <?php if (isset($filterDeveloper)): ?>
              <input type="hidden" name="developer_id" value="<?= esc($filterDeveloper['id']) ?>">
            <?php else: ?>
              <div class="mb-3">
                <label class="form-label">Developer ID</label>
                <input type="number" name="developer_id" class="form-control" required>
              </div>
            <?php endif; ?>

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

  <!-- Modal Edit -->
  <?php foreach ($properties as $p): ?>
    <div class="modal fade" id="editPropertyModal<?= $p['id'] ?>" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
          <form action="<?= isset($filterDeveloper) 
              ? base_url('dashboard/developer/' . esc($filterDeveloper['slug']) . '/property/' . esc($p['slug']) . '/update')
              : base_url('dashboard/property/' . esc($p['id']) . '/update') ?>" 
              method="post" enctype="multipart/form-data">

            <?= csrf_field() ?>
            <div class="modal-header">
              <h5 class="modal-title">Edit Property: <?= esc($p['title']) ?></h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
              <input type="hidden" name="developer_id" 
                     value="<?= isset($filterDeveloper) ? esc($filterDeveloper['id']) : esc($p['developer_id']) ?>">

              <div class="mb-3">
                <label class="form-label">Judul Property</label>
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
                <?php endif ?>
              </div>
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kembali</button>
              <button type="submit" class="btn btn-primary">Update</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  <?php endforeach ?>
<?php endif ?>



<?= $this->endSection() ?>
