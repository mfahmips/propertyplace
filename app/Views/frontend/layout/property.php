<section class="space overflow-hidden">
    <div class="sec-bg-shape2-1 spin shape-mockup d-xl-block d-none" data-top="6%" data-left="4%">
        <img src="<?= base_url('assets/img/shape/section_shape_2_1.jpg') ?>" alt="img">
    </div>
    <div class="sec-bg-shape2-2 wave-anim shape-mockup d-xl-block d-none" data-bg-src="<?= base_url('assets/img/shape/section_shape_2_2.jpg') ?>" data-top="12%" data-right="4%">
    </div>
    <div class="sec-bg-shape2-3 jump shape-mockup d-xl-block d-none" data-bottom="0" data-left="3%">
        <img src="<?= base_url('assets/img/shape/section_shape_2_3.jpg') ?>" alt="img">
    </div>

    <div class="container">
        <div class="row justify-content-center align-items-center">
            <div class="col-xxl-6 col-lg-8">
                <div class="title-area text-center">
                    <span class="sub-title">Best Project</span>
                    <h2 class="sec-title text-theme">Ongoing Projects</h2>
                    <p class="text-theme">Quis nulla blandit vulputate morbi adipiscing sem vestibulum. Nulla turpis integer dui sed posuere sem. Id molestie mi arcu gravida lorem potenti.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid p-lg-0">
        <div class="slider-area project-slider4 slider-drag-wrap">
            <div class="swiper th-slider" data-slider-options='{"breakpoints":{"0":{"slidesPerView":1},"576":{"slidesPerView":"1"},"768":{"slidesPerView":"1"},"992":{"slidesPerView":"2"},"1200":{"slidesPerView":"2.5"},"1500":{"slidesPerView":"2.5","spaceBetween":"64"}},"grabCursor":"true","slideToClickedSlide":"true","centeredSlides": "true"}'>
                <div class="swiper-wrapper">
                    <?php foreach ($properties as $property): ?>
                        <div class="swiper-slide">
                            <div class="portfolio-card style4">
                                <div class="portfolio-img">
                                    <?php if (!empty($property['thumbnail']) && file_exists(FCPATH . 'uploads/property/thumbnail/' . $property['thumbnail'])): ?>
                                        <img src="<?= base_url('uploads/property/thumbnail/' . esc($property['thumbnail'])) ?>" alt="<?= esc($property['title']) ?>">
                                    <?php else: ?>
                                        <img src="<?= base_url('images/placeholder-600x400.png') ?>" alt="Thumbnail belum tersedia">
                                    <?php endif ?>
                                </div>

                                <div class="portfolio-content">
                                    <h3 class="portfolio-title">
                                        <a href="<?= base_url('property/' . $property['slug']) ?>"><?= esc($property['title']) ?></a>
                                    </h3>
                                    <p class="portfolio-location"><?= esc($property['developer_name']) ?></p>
                                    <div class="property-card-meta">
                                        <span><img src="<?= base_url('assets/frontend/img/icon/property-icon1-1.svg') ?>" alt="Bed"> 
                                            Bed <?= isset($property['bedroom']) ? esc($property['bedroom']) : '-' ?>
                                        </span>
                                        <span><img src="<?= base_url('assets/frontend/img/icon/property-icon1-2.svg') ?>" alt="Bath"> 
                                            Bath <?= isset($property['bathroom']) ? esc($property['bathroom']) : '-' ?>
                                        </span>
                                        <span><img src="<?= base_url('assets/frontend/img/icon/property-icon1-3.svg') ?>" alt="Size"> 
                                            <?= isset($property['size']) ? esc($property['size']) . ' sqft' : '-' ?>
                                        </span>
                                    </div>

                                    <p class="portfolio-text">
                                        <?= esc(mb_strimwidth(strip_tags($property['description'] ?? 'Deskripsi belum tersedia'), 0, 100, '...')) ?>
                                    </p>

                                    <p class="portfolio-price">Harga Mulai
                                        <?= esc($property['price_text'] ?? 'Harga tidak tersedia') ?>an
                                    </p>

                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="slider-pagination style3 d-sm-block d-none"></div>
            </div>
        </div>

        <div class="btn-wrap justify-content-center mt-55">
            <a href="<?= base_url('property') ?>" class="th-btn style4 th-btn-icon">Browse All Projects</a>
        </div>
    </div>
</section>
