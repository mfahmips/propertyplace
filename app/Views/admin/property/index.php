<?= $this->extend('admin/layout/default') ?>
<?= $this->section('content') ?>

  <?php $role = session('role'); ?>

  <?php if (in_array($role, ['sales', 'admin', 'management'])): ?>
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



<?= $this->endSection() ?>
