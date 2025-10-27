<?= $this->extend('frontend/layout/default') ?>
<?= $this->section('content') ?>

<!--======== / Hero Section ========--><!--==============================
Counter Area  
==============================-->
    <div class="bg-light overflow-hidden pt-60 pb-60">
        <div class="container">
            <div class="counter-card-wrap">
                <div class="counter-card style4">
                    <div class="media-body">
                        <h2 class="box-number text-theme"><span class="counter-number text-theme">850</span>+</h2>
                        <p class="box-text text-theme">Elegant Apartments</p>
                    </div>
                </div>
                <div class="counter-card style4">
                    <div class="media-body">
                        <h2 class="box-number text-theme"><span class="counter-number text-theme">950</span>+</h2>
                        <p class="box-text text-theme">Luxury Houses</p>
                    </div>
                </div>
                <div class="counter-card style4">
                    <div class="media-body">
                        <h2 class="box-number text-theme"><span class="counter-number text-theme">18</span>k+</h2>
                        <p class="box-text text-theme">Satisfied Guests</p>
                    </div>
                </div>
                <div class="counter-card style4">
                    <div class="media-body">
                        <h2 class="box-number text-theme"><span class="counter-number text-theme">2</span>k+</h2>
                        <p class="box-text text-theme">Happy Owners</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
<!--==============================
Property Area 2  
==============================-->
    <section class="space overflow-hidden" id="property-sec">

        <div class="container th-container2">
            <div class="row justify-content-center align-items-center">
                <div class="col-xxl-12">
                    <div class="title-area text-center mb-25">
                        <span class="sub-title3 justify-content-center">Properties</span>
                        <h2 class="sec-title"><?= esc($developer['name']) ?></h2>
                    </div>
                </div>
            </div>
            <div class="tab-content property-tab-content position-relative">
                <div class="tab-pane fade show active" id="rent-tab-pane" role="tabpanel" aria-labelledby="rent-tab" tabindex="0">
                    <div class="slider-area property-slider11 slider-drag-wrap">
                      <div class="swiper th-slider"
                           data-slider-options='{"paginationType":"progressbar","breakpoints":{"0":{"slidesPerView":1},"576":{"slidesPerView":"1"},"768":{"slidesPerView":"2"},"992":{"slidesPerView":"2"},"1200":{"slidesPerView":"3"},"1500":{"slidesPerView":"4"}},"spaceBetween":"32","grabCursor":"true","slideToClickedSlide":"true"}'>
                        <div class="swiper-wrapper">

                          <?php if (!empty($properties)): ?>
                            <?php foreach ($properties as $property): ?>
                              <div class="swiper-slide">
                                <div class="property-card9">
                                  <div class="property-card-thumb img-shine">
                                    <?php
                                      // ambil thumbnail langsung dari tabel properties
                                      $path = FCPATH . 'uploads/property/thumbnail/' . $property['thumbnail'];
                                      if (!empty($property['thumbnail']) && file_exists($path)) {
                                          $imageUrl = base_url('uploads/property/thumbnail/' . $property['thumbnail']);
                                      } else {
                                          $imageUrl = base_url('uploads/property/default.jpg');
                                      }
                                    ?>
                                    <img src="<?= $imageUrl ?>" alt="<?= esc($property['title']) ?>">
                                  </div>

                                  <div class="property-card-details">
                                    <h4 class="property-card-title">
                                      <a href="<?= base_url('property/' . $property['slug']) ?>">
                                        <?= esc($property['title']) ?>
                                      </a>
                                    </h4>

                                    <p class="property-card-location">
                                      <i class="far fa-map-marker-alt me-2"></i>
                                      <?= esc($property['location'] ?? 'Lokasi belum tersedia') ?>
                                    </p>

                                    <div class="property-card-meta">
                                      <span><img src="<?= base_url('assets/frontend/img/icon/property-icon1-1.svg') ?>" alt="icon"> 
                                        <?= esc($property['bedrooms'] ?? '0') ?> Bed
                                      </span>
                                      <span><img src="<?= base_url('assets/frontend/img/icon/property-icon1-2.svg') ?>" alt="icon"> 
                                        <?= esc($property['bathrooms'] ?? '0') ?> Bath
                                      </span>
                                      <span><img src="<?= base_url('assets/frontend/img/icon/property-icon1-3.svg') ?>" alt="icon"> 
                                        <?= esc($property['land_area'] ?? '0') ?> m²
                                      </span>
                                    </div>

                                    <div class="btn-wrap">
                                      <a href="<?= base_url('property/' . $property['slug']) ?>" class="th-btn style-border2 th-btn-icon">Details</a>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            <?php endforeach; ?>
                          <?php else: ?>
                            <div class="swiper-slide text-center">
                              <div class="alert alert-warning">Belum ada properti untuk developer ini.</div>
                            </div>
                          <?php endif; ?>

                        </div>

                        <div class="slider-pagination slider-pagination-progressbar3"></div>
                        <button data-slider-prev=".property-slider11" class="slider-arrow slider-prev">
                          <img src="<?= base_url('assets/frontend/img/icon/arrow-left.svg') ?>" alt="icon">
                        </button>
                        <button data-slider-next=".property-slider11" class="slider-arrow slider-next">
                          <img src="<?= base_url('assets/frontend/img/icon/arrow-right.svg') ?>" alt="icon">
                        </button>
                      </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

<?= $this->endSection() ?>
