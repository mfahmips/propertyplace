<?= $this->extend('admin/layout/default') ?>
<?= $this->section('content') ?>

<!-- Container -->
<div class="container-fluid">

  <!-- Welcome -->
  <div class="row">
    <div class="col-12 mb-4">
      <h5>Selamat Datang,</h5>
      <h1 class="text-white"><?= esc($username) ?>!</h1>
      <p class="text-muted mt-3">Hari ini : <?= tanggal_indo(date('Y-m-d')) ?></p>
    </div>
  </div>

  <div class="row">

    <?php if (in_array(session('role'), ['admin', 'managemen'])): ?>

      <!-- Total Cards -->
      <div class="col-md-6 col-xl-4">
        <div class="card"><div class="card-body">
          <div class="row">
            <div class="col-8">
              <p class="text-muted mb-0">Total Developer</p>
              <h3 class="text-dark mt-2 mb-0"><?= esc($totalDeveloper) ?></h3>
            </div>
            <div class="col-4 text-end">
              <div class="avatar-md bg-soft-primary rounded">
                <iconify-icon icon="solar:home-2-outline" class="fs-32 avatar-title text-primary"></iconify-icon>
              </div>
            </div>
          </div>
        </div></div>
      </div>

      <div class="col-md-6 col-xl-4">
        <div class="card"><div class="card-body">
          <div class="row">
            <div class="col-8">
              <p class="text-muted mb-0">Total Properti</p>
              <h3 class="text-dark mt-2 mb-0"><?= esc($totalProperty) ?></h3>
            </div>
            <div class="col-4 text-end">
              <div class="avatar-md bg-soft-primary rounded">
                <iconify-icon icon="solar:buildings-outline" class="fs-32 avatar-title text-primary"></iconify-icon>
              </div>
            </div>
          </div>
        </div></div>
      </div>

      <div class="col-md-6 col-xl-4">
        <div class="card"><div class="card-body">
          <div class="row">
            <div class="col-8">
              <p class="text-muted mb-0">Total User</p>
              <h3 class="text-dark mt-2 mb-0"><?= esc($totalUser) ?></h3>
            </div>
            <div class="col-4 text-end">
              <div class="avatar-md bg-soft-primary rounded">
                <iconify-icon icon="solar:user-outline" class="fs-32 avatar-title text-primary"></iconify-icon>
              </div>
            </div>
          </div>
        </div></div>
      </div>

    <?php elseif (session('role') === 'sales'): ?>

      <div class="container">
      <div class="row">


        <!-- Kolom Form Filter -->
        <div class="d-flex justify-content-center">
          <form method="get"
                class="filter-wrapper d-flex flex-wrap align-items-center gap-2 p-2 px-3 rounded">
            
            <div class="input-group" style="flex: 1 1">
            <span class="input-group-text bg-transparent border-0">
              <i class="fa-solid fa-magnifying-glass"></i>
            </span>
            <input type="text" name="search" class="form-control border-0"
                   placeholder="Search ..." value="<?= esc($search ?? '') ?>">
          </div>

            <select name="developer_id" class="form-select border-0" style="flex: 1 1">
              <option value="">Pilih Developer</option>
              <?php foreach ($developers as $dev): ?>
                <option value="<?= $dev['id'] ?>" <?= ($developerId ?? '') == $dev['id'] ? 'selected' : '' ?>>
                  <?= esc($dev['name']) ?>
                </option>
              <?php endforeach ?>
            </select>

            <button type="submit" class="btn btn-outline-dark rounded-pill px-4 py-1" style="flex-shrink: 0;">
              Search
            </button>
          </form>
        </div>

        <!-- Card Properti -->
        <?php foreach ($properties as $property): ?>
          <div class="col-sm-6 col-md-4 col-lg-3">
            <!-- Card property -->
          </div>
        <?php endforeach; ?>

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

      <!-- Property Cards -->
      <div id="property-list" class="row mt-4">
        <?php foreach ($properties as $property): ?>
          <div class="col-sm-6 col-md-4 col-lg-3 mb-4">
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
              </div>
            </div>

            <!-- Modal Detail -->
            <div class="modal fade" id="modalDetail<?= $property['id'] ?>" tabindex="-1" aria-hidden="true">
              <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title"><?= esc($property['title']) ?> - <?= esc($property['developer_name']) ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                  </div>
                  <div class="modal-body">
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

                    <div class="mt-2">
                      <?php foreach ($property['Types'] as $type): ?>
                        <p><strong>Tipe Unit :</strong> <?= esc($type['type_unit']) ?> - <?= esc($type['name']) ?></p>
                      <?php endforeach; ?>
                    </div>
                  </div>
                </div>
              </div>
            </div>

          </div>
        <?php endforeach ?>
      </div>

      <!-- Pagination -->
      <div id="pagination-links" class="d-flex justify-content-center mt-2 mb-4">
        <?= $pager->links('property', 'bootstrap') ?>
      </div>

    <?php endif; ?>

  </div>
</div>

<!-- Swiper CDN -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css"/>
<script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>

<!-- Swiper Init + AJAX Pagination -->
<script>
function initSwipers() {
  document.querySelectorAll('.swiper').forEach(function (el) {
    new Swiper(el, {
      loop: true,
      pagination: { el: el.querySelector('.swiper-pagination') },
    });
  });
}
document.addEventListener("DOMContentLoaded", function () {
  initSwipers();
  const paginationContainer = document.querySelector('#pagination-links');
  paginationContainer?.addEventListener('click', function (e) {
    if (e.target.tagName === 'A') {
      e.preventDefault();
      fetch(e.target.href)
        .then(res => res.text())
        .then(html => {
          const doc = new DOMParser().parseFromString(html, 'text/html');
          document.querySelector('#property-list').innerHTML = doc.querySelector('#property-list').innerHTML;
          paginationContainer.innerHTML = doc.querySelector('#pagination-links').innerHTML;
          initSwipers();
        });
    }
  });
});
</script>

<!-- Lengkapi Profil Modal -->
<?php if (!empty($profileIncomplete)) : ?>
<div class="modal fade" id="profileReminderModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Profil Anda Belum Lengkap</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <p>Mohon lengkapi profil terlebih dahulu untuk menggunakan sistem secara optimal.</p>
      </div>
      <div class="modal-footer">
        <a href="<?= base_url('dashboard/user/profile/' . session('slug')) ?>" class="btn btn-light w-100">Lengkapi Profil</a>
      </div>
    </div>
  </div>
</div>
<script> new bootstrap.Modal(document.getElementById('profileReminderModal')).show(); </script>
<?php endif; ?>

<!-- Absen Toast -->
<?php if (session()->getFlashdata('absen_masuk_success')): ?>
<div class="position-fixed top-50 start-50 translate-middle p-3" style="z-index:1060;">
  <div id="absenToast" class="toast text-white bg-success border-0 shadow-lg" role="alert" data-bs-delay="5000" data-bs-autohide="true">
    <div class="d-flex">
      <div class="toast-body fs-5">💪 Selamat bertugas, tetap semangat, yakin closing!!!</div>
      <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
    </div>
  </div>
</div>
<script> new bootstrap.Toast(document.getElementById('absenToast')).show(); </script>
<?php endif; ?>

<?= $this->endSection() ?>
