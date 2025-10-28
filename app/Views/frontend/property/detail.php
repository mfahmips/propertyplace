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
About Area  
==============================-->
    <div class="overflow-hidden space" id="about-sec">
        <div class="sec-bg-shape2-1 spin shape-mockup d-xl-block d-none" data-bottom="9%" data-right="13%">
            <img src="<?= base_url('assets/frontend/img/shape/section_shape_2_1.jpg') ?>" alt="img">
        </div>
        <div class="container">
            <div class="row align-items-center flex-row-reverse">
                <div class="col-xl-7 mb-50 mb-xl-0">
                    <div class="img-box2">
                        <div class="slider-area">
                            <div class="swiper th-slider about-thumb-slider" id="aboutSlider1" data-slider-options='{"breakpoints":{"0":{"slidesPerView":1},"576":{"slidesPerView":"1"},"768":{"slidesPerView":"1","effect":"fade"},"992":{"slidesPerView":"3"},"1200":{"slidesPerView":"3"}},"effect":"coverflow","coverflowEffect":{"rotate":"0","stretch":"350","depth":"215","modifier":"1"},"centeredSlides":"true"}'>
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide">
                                        <div class="img1">
                                            <img src="<?= base_url('assets/frontend/img/normal/about_2_1.png') ?>" alt="About">
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="img1">
                                            <img src="<?= base_url('assets/frontend/img/normal/about_2_2.png') ?>" alt="About">
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="img1">
                                            <img src="<?= base_url('assets/frontend/img/normal/about_2_3.png') ?>" alt="About">
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="img1">
                                            <img src="<?= base_url('assets/frontend/img/normal/about_2_1.png') ?>" alt="About">
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="img1">
                                            <img src="<?= base_url('assets/frontend/img/normal/about_2_2.png') ?>" alt="About">
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="img1">
                                            <img src="<?= base_url('assets/frontend/img/normal/about_2_3.png') ?>" alt="About">
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <button data-slider-next="#aboutSlider1" class="slider-arrow slider-next"><img src="<?= base_url('assets/frontend/img/icon/arrow-right.svg') ?>" alt="icon"></button>
                        </div>
                        <div class="about-tag">
                            <div class="about-experience-tag">
                                <span class="circle-title-anime">Realar Living Solutions</span>
                            </div>
                            <a href="https://www.youtube.com/watch?v=_sI_Ps7JSEk" class="play-btn popup-video"><i class="fa-sharp fa-solid fa-play"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-5">
                    <div class="title-area mb-32">
                        <h2 class="sec-title style2">About Us</h2>
                        <p class="sec-text">We are a real estate firm with over 20 years of expertise, and our main goal is to provide amazing locations to our partners and clients. Within the luxury real estate market, our agency offers customized solutions. We are a real estate firm with over 20 years of expertise. Our main goal is to provide amazing locations to our partners and clients.</p>
                    </div>
                    <div class="about-wrap2">
                        <div class="checklist style2">
                            <ul>
                                <li><img src="assets/img/icon/checkmark.svg" alt="img">Quality real estate services</li>
                                <li><img src="assets/img/icon/checkmark.svg" alt="img">100% Satisfaction guarantee</li>
                                <li><img src="assets/img/icon/checkmark.svg" alt="img">Highly professional team</li>
                                <li><img src="assets/img/icon/checkmark.svg" alt="img">Dealing always on time</li>
                            </ul>
                        </div>
                        <div class="call-btn">
                            <div class="icon-btn">
                                <img src="assets/img/icon/phone.svg" alt="img">
                            </div>
                            <div class="btn-content">
                                <h6 class="btn-title">Call Us 24/7</h6>
                                <span class="btn-text"><a href="tel:0123456789">+01 234 56789</a></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<!--======== / Hero Section ========--><!--==============================
Property Area 2  
==============================-->
    <?php if (!empty($relatedProperties)): ?>
 <!--==============================
Property Area 4  
==============================-->
    <section class="space overflow-hidden">
        <div class="container">
            <div class="row justify-content-center align-items-center">
                <div class="col-xxl-6 col-lg-8">
                    <div class="title-area text-center">
                        <span class="sub-title">Related Property</span>
                        <h2 class="sec-title text-theme"><?= esc($property['developer_name']) ?></h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid p-lg-0">
            <div class="slider-area project-slider4 slider-drag-wrap">
                <div class="swiper th-slider" data-slider-options='{"breakpoints":{"0":{"slidesPerView":1},"576":{"slidesPerView":"1"},"768":{"slidesPerView":"1"},"992":{"slidesPerView":"2"},"1200":{"slidesPerView":"2.5"},"1500":{"slidesPerView":"2.5","spaceBetween":"64"}},"grabCursor":"true","slideToClickedSlide":"true","centeredSlides": "true"}'>
                    <div class="swiper-wrapper">
                        <?php foreach ($relatedProperties as $rel): ?>
                        <div class="swiper-slide">
                            <div class="portfolio-card style4">
                                <div class="portfolio-img">
                                    <img src="<?= base_url('uploads/property/thumbnail/' . $rel['thumbnail']) ?>" 
                                 alt="<?= esc($rel['title']) ?>">
                                </div>
                                <div class="portfolio-content">
                                    <h3 class="portfolio-title"><a href="<?= base_url('property/' . $rel['slug']) ?>"><?= esc($rel['title']) ?></a></h3>
                                    <p class="portfolio-location"><?= esc($rel['location'] ?? 'Tidak tersedia') ?></p>
                                    <div class="property-card-meta">
                                        <span><img src="<?= base_url('assets/frontend/img/icon/property-icon1-1.svg') ?>" alt="img"><?= esc($rel['bedrooms'] ?? '-') ?></span>
                                        <span><img src="<?= base_url('assets/frontend/img/icon/property-icon1-2.svg') ?>" alt="img"><?= esc($rel['bathrooms'] ?? '-') ?></span>
                                        <span><img src="<?= base_url('assets/frontend/img/icon/property-icon1-3.svg') ?>" alt="img"><?= esc($rel['land_area'] ?? '-') ?> sqft</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="slider-pagination style3 d-sm-block d-none"></div>
                </div>
            </div>
            <div class="btn-wrap justify-content-center mt-55">
                <a href="property.html" class="th-btn style4 th-btn-icon">Browse All Projects</a>
            </div>
        </div>

    </section>
    <?php endif; ?>


<?= $this->include('frontend/layout/developer') ?>

 <?= $this->endSection() ?>