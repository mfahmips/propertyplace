<div class="space-top position-relative overflow-hidden" data-bg-src="assets/img/hero/hero_bg_4_1.jpg">
        <div class="container">
            <div class="row justify-content-between">
                <div class="col-xxl-4 col-xl-5 mb-xl-0 mb-30">
                    <div class="title-area mb-0 text-lg-start text-center">
                        <h2 class="sec-title text-theme">1,230+ Companies Trust by us.</h2>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="title-area mb-0 text-lg-start text-center">
                        <p class="sec-text mb-0">Turning homes become dreams as your go-to real estate agent. You can rely on us to help you safely home. 745,000 houses and flats for sale, rent, or mortgage.</p>
                    </div>
                    <div class="btn-wrap mt-35 justify-content-lg-start justify-content-center">
                        <a href="about.html" class="th-btn style4 th-btn-icon">Request a Visit</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--==============================
Client Area  
==============================-->
    <div class="client-area-1 space" data-bg-src="assets/img/hero/hero_bg_4_1.jpg">
        <div class="container">
            <div class="slider-area client-slider3">
                <div class="swiper th-slider has-shadow" id="clientSlider1" data-slider-options='{"breakpoints":{"0":{"slidesPerView":2},"576":{"slidesPerView":"3"},"768":{"slidesPerView":"4"},"992":{"slidesPerView":"5"},"1200":{"slidesPerView":"6"}}}'>
                    <div class="swiper-wrapper">
                        <?php foreach ($developers as $dev): ?>
                        <div class="swiper-slide">
                            
                            <a href="#" class="client-card">
                                <img src="<?= base_url('uploads/developer/' . $dev['logo']) ?>" alt="<?= esc($dev['name']) ?>">
                            </a>
                            
                        </div>
                        <?php endforeach ?>
                    </div>
                </div>
            </div>
        </div>
    </div>