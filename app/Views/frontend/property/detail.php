<?= $this->extend('frontend/layout/default') ?>

<?= $this->section('content') ?>

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

<?= $this->include('frontend/layout/developer') ?>

 <?= $this->endSection() ?>