<?= $this->extend('frontend/layout/default') ?>

<?= $this->section('content') ?>

<!--==============================
Property Page Area
==============================-->
    <section class="space-top space-extra-bottom">
        <div class="container">
            <div class="slider-area property-slider1">
                <div class="swiper th-slider mb-4" id="propertySlider" data-slider-options='{"effect":"fade","loop":true,"thumbs":{"swiper":".property-thumb-slider"},"autoplayDisableOnInteraction":"true"}'>
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <div class="property-slider-img">
                                <img src="<?= base_url('assets/frontend/img/property/property_inner_1.jpg' ) ?>" alt="img">
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="property-slider-img">
                                <img src="<?= base_url('assets/frontend/img/property/property_inner_2.jpg' ) ?>" alt="img">
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="property-slider-img">
                                <img src="<?= base_url('assets/frontend/img/property/property_inner_3.jpg' ) ?>" alt="img">
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="property-slider-img">
                                <img src="<?= base_url('assets/frontend/img/property/property_inner_4.jpg' ) ?>" alt="img">
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="property-slider-img">
                                <img src="<?= base_url('assets/frontend/img/property/property_inner_5.jpg' ) ?>" alt="img">
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="property-slider-img">
                                <img src="<?= base_url('assets/frontend/img/property/property_inner_1.jpg' ) ?>" alt="img">
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="property-slider-img">
                                <img src="<?= base_url('assets/frontend/img/property/property_inner_2.jpg' ) ?>" alt="img">
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="property-slider-img">
                                <img src="<?= base_url('assets/frontend/img/property/property_inner_3.jpg' ) ?>" alt="img">
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="property-slider-img">
                                <img src="<?= base_url('assets/frontend/img/property/property_inner_4.jpg' ) ?>" alt="img">
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="property-slider-img">
                                <img src="<?= base_url('assets/frontend/img/property/property_inner_5.jpg' ) ?>" alt="img">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="swiper th-slider property-thumb-slider" data-slider-options='{"effect":"slide","loop":true,"breakpoints":{"0":{"slidesPerView":2},"576":{"slidesPerView":"2"},"768":{"slidesPerView":"3"},"992":{"slidesPerView":"3"},"1200":{"slidesPerView":"4"}},"autoplayDisableOnInteraction":"true"}'>
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <div class="property-slider-img">
                                <img src="<?= base_url('assets/frontend/img/property/property_inner_5.jpg' ) ?>" alt="Image">
                            </div>
                        </div>
                    </div>
                </div>

                <button data-slider-prev="#propertySlider" class="slider-arrow style3 slider-prev"><img src="<?= base_url('assets/frontend/img/icon/arrow-left.svg' ) ?>" alt="icon"></button>
                <button data-slider-next="#propertySlider" class="slider-arrow style3 slider-next"><img src="<?= base_url('assets/frontend/img/icon/arrow-right.svg' ) ?>" alt="icon"></button>
            </div>
            <div class="row gx-30">
                <div class="col-xxl-8 col-lg-7">
                    <div class="property-page-single">
                        <div class="page-content">
                            <h2 class="page-title">About This Property</h2>
                            <p class="mb-30">voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur</p>
                            <p class="mb-30"> Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur</p>
                            <h2 class="page-title mb-20">Property Overview</h2>
                            <ul class="property-grid-list">
                                <li>
                                    <div class="property-grid-list-icon">
                                        <img src="<?= base_url('assets/frontend/img/icon/property-single-icon1-1.svg' ) ?>" alt="img">
                                    </div>
                                    <div class="property-grid-list-details">
                                        <h4 class="property-grid-list-title">ID NO.</h4>
                                        <p class="property-grid-list-text">#1234</p>
                                    </div>
                                </li>
                                <li>
                                    <div class="property-grid-list-icon">
                                        <img src="<?= base_url('assets/frontend/img/icon/property-single-icon1-2.svg' ) ?>" alt="img">
                                    </div>
                                    <div class="property-grid-list-details">
                                        <h4 class="property-grid-list-title">Type</h4>
                                        <p class="property-grid-list-text">Residencial</p>
                                    </div>
                                </li>
                                <li>
                                    <div class="property-grid-list-icon">
                                        <img src="<?= base_url('assets/frontend/img/icon/property-single-icon1-3.svg' ) ?>" alt="img">
                                    </div>
                                    <div class="property-grid-list-details">
                                        <h4 class="property-grid-list-title">Room</h4>
                                        <p class="property-grid-list-text">6</p>
                                    </div>
                                </li>
                                <li>
                                    <div class="property-grid-list-icon">
                                        <img src="<?= base_url('assets/frontend/img/icon/property-single-icon1-4.svg' ) ?>" alt="img">
                                    </div>
                                    <div class="property-grid-list-details">
                                        <h4 class="property-grid-list-title">Bedroom</h4>
                                        <p class="property-grid-list-text">4</p>
                                    </div>
                                </li>
                                <li>
                                    <div class="property-grid-list-icon">
                                        <img src="<?= base_url('assets/frontend/img/icon/property-single-icon1-5.svg' ) ?>" alt="img">
                                    </div>
                                    <div class="property-grid-list-details">
                                        <h4 class="property-grid-list-title">Bath</h4>
                                        <p class="property-grid-list-text">2</p>
                                    </div>
                                </li>
                                <li>
                                    <div class="property-grid-list-icon">
                                        <img src="<?= base_url('assets/frontend/img/icon/property-single-icon1-6.svg' ) ?>" alt="img">
                                    </div>
                                    <div class="property-grid-list-details">
                                        <h4 class="property-grid-list-title">Purpose</h4>
                                        <p class="property-grid-list-text">For Rent</p>
                                    </div>
                                </li>
                                <li>
                                    <div class="property-grid-list-icon">
                                        <img src="<?= base_url('assets/frontend/img/icon/property-single-icon1-7.svg' ) ?>" alt="img">
                                    </div>
                                    <div class="property-grid-list-details">
                                        <h4 class="property-grid-list-title">Sqft</h4>
                                        <p class="property-grid-list-text">4000</p>
                                    </div>
                                </li>
                                <li>
                                    <div class="property-grid-list-icon">
                                        <img src="<?= base_url('assets/frontend/img/icon/property-single-icon1-8.svg' ) ?>" alt="img">
                                    </div>
                                    <div class="property-grid-list-details">
                                        <h4 class="property-grid-list-title">Parking</h4>
                                        <p class="property-grid-list-text">Yes</p>
                                    </div>
                                </li>
                                <li>
                                    <div class="property-grid-list-icon">
                                        <img src="<?= base_url('assets/frontend/img/icon/property-single-icon1-9.svg' ) ?>" alt="img">
                                    </div>
                                    <div class="property-grid-list-details">
                                        <h4 class="property-grid-list-title">Elevator</h4>
                                        <p class="property-grid-list-text">Yes</p>
                                    </div>
                                </li>
                                <li>
                                    <div class="property-grid-list-icon">
                                        <img src="<?= base_url('assets/frontend/img/icon/property-single-icon1-10.svg' ) ?>" alt="img">
                                    </div>
                                    <div class="property-grid-list-details">
                                        <h4 class="property-grid-list-title">Wifi</h4>
                                        <p class="property-grid-list-text">Yes</p>
                                    </div>
                                </li>
                            </ul>
                            <div class="row align-items-center justify-content-between">
                                <div class="col-lg-auto">
                                    <h3 class="page-title mt-50 mb-30">Floor Plan</h3>
                                </div>
                                <div class="col-lg-auto">
                                    <ul class="nav nav-tabs property-tab mt-50" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active" id="floor-tab1" data-bs-toggle="tab" data-bs-target="#floor-tab1-pane" type="button" role="tab" aria-controls="floor-tab1-pane" aria-selected="true">First Floor</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="floor-tab2" data-bs-toggle="tab" data-bs-target="#floor-tab2-pane" type="button" role="tab" aria-controls="floor-tab2-pane" aria-selected="false">Second Floor</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="floor-tab3" data-bs-toggle="tab" data-bs-target="#floor-tab3-pane" type="button" role="tab" aria-controls="floor-tab3-pane" aria-selected="false">Third Floor</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="floor-tab4" data-bs-toggle="tab" data-bs-target="#floor-tab4-pane" type="button" role="tab" aria-controls="floor-tab4-pane" aria-selected="false">Top Garden </button>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="tab-content">
                                <div class="tab-pane fade show active" id="floor-tab1-pane" role="tabpanel" aria-labelledby="floor-tab1" tabindex="0">
                                    <div class="property-grid-plan">
                                        <div class="property-grid-thumb">
                                            <img src="<?= base_url('assets/frontend/img/property/property_inner_10.jpg' ) ?>" alt="img">
                                        </div>
                                        <div class="property-grid-details">
                                            <h4 class="property-grid-title">First Floor </h4>
                                            <p class="property-grid-text">doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="floor-tab2-pane" role="tabpanel" aria-labelledby="floor-tab2" tabindex="0">
                                    <div class="property-grid-plan">
                                        <div class="property-grid-thumb">
                                            <img src="<?= base_url('assets/frontend/img/property/property_inner_10.jpg' ) ?>" alt="img">
                                        </div>
                                        <div class="property-grid-details">
                                            <h4 class="property-grid-title">Second Floor </h4>
                                            <p class="property-grid-text">doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="floor-tab3-pane" role="tabpanel" aria-labelledby="floor-tab3" tabindex="0">
                                    <div class="property-grid-plan">
                                        <div class="property-grid-thumb">
                                            <img src="<?= base_url('assets/frontend/img/property/property_inner_10.jpg' ) ?>" alt="img">
                                        </div>
                                        <div class="property-grid-details">
                                            <h4 class="property-grid-title">Third Floor </h4>
                                            <p class="property-grid-text">doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="floor-tab4-pane" role="tabpanel" aria-labelledby="floor-tab4" tabindex="0">
                                    <div class="property-grid-plan">
                                        <div class="property-grid-thumb">
                                            <img src="<?= base_url('assets/frontend/img/property/property_inner_10.jpg' ) ?>" alt="img">
                                        </div>
                                        <div class="property-grid-details">
                                            <h4 class="property-grid-title">Top Garden </h4>
                                            <p class="property-grid-text">doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <h3 class="page-title mt-50 mb-30">Property Video</h3>
                            <div class="video-box2 mb-30">
                                <img src="<?= base_url('assets/frontend/img/property/property_inner_3.jpg' ) ?>" alt="img">
                                <a href="https://www.youtube.com/watch?v=_sI_Ps7JSEk" class="play-btn style4 popup-video"><i class="fa-sharp fa-solid fa-play"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-4 col-lg-5">
                    <aside class="sidebar-area">
                        <div class="widget widget-property-contact">
                            <h4 class="widget_subtitle">For Rent</h4>
                            <h4 class="widget_price">$45, 000, 000</h4>
                            <p class="widget_text">I am interested in this property</p>
                            <form action="#" class="widget-property-contact-form">
                                <div class="form-group">
                                    <input type="text" class="form-control style-border" placeholder="Name">
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control style-border" placeholder="Email Address">
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control style-border" placeholder="Phone Number">
                                </div>
                                <button class="th-btn style-white th-btn-icon mt-15">Request Al Video</button>
                            </form>
                        </div>
                        <div class="widget  ">
                            <h3 class="widget_title">Featured Listing</h3>
                            <div class="recent-post-wrap">
                                <div class="recent-post">
                                    <div class="media-img">
                                        <a href="blog-details.html"><img src="<?= base_url('assets/frontend/img/blog/recent-post-1-1.jpg' ) ?>" alt="Blog Image"></a>
                                    </div>
                                    <div class="media-body">
                                        <h4 class="post-title"><a class="text-inherit" href="blog-details.html">Exploring The Green Spaces Of Realar Residence</a></h4>
                                        <div class="recent-post-meta">
                                            <a href="blog.html"><i class="far fa-calendar"></i>22/6/2025</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="recent-post">
                                    <div class="media-img">
                                        <a href="blog-details.html"><img src="<?= base_url('assets/frontend/img/blog/recent-post-1-2.jpg' ) ?>" alt="Blog Image"></a>
                                    </div>
                                    <div class="media-body">
                                        <h4 class="post-title"><a class="text-inherit" href="blog-details.html">Harmony With Nature Of Realar Residence</a></h4>
                                        <div class="recent-post-meta">
                                            <a href="blog.html"><i class="far fa-calendar"></i>25/6/2025</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="recent-post">
                                    <div class="media-img">
                                        <a href="blog-details.html"><img src="<?= base_url('assets/frontend/img/blog/recent-post-1-3.jpg' ) ?>" alt="Blog Image"></a>
                                    </div>
                                    <div class="media-body">
                                        <h4 class="post-title"><a class="text-inherit" href="blog-details.html">Exploring The Green Spaces Of Realar Residence</a></h4>
                                        <div class="recent-post-meta">
                                            <a href="blog.html"><i class="far fa-calendar"></i>27/6/2025</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="widget widget_banner  " data-bg-src="<?= base_url('assets/frontend/img/widget/widget-banner.png' ) ?>">
                            <div class="widget-banner text-center">
                                <h3 class="title">Need Help? We Are Here To Help You</h3>
                                <div class="logo"><img src="<?= base_url('assets/frontend/img/logo.svg' ) ?>" alt="img"></div>
                                <h4 class="subtitle">You Get Online support</h4>
                                <h5 class="link"><a href="tel:256214203215">+256 214 203 215</a></h5>
                                <a href="blog-details.html" class="th-btn style-border th-btn-icon">Read More</a>
                            </div>
                        </div>
                    </aside>
                </div>
            </div>
        </div>
    </section><!--==============================
	Footer Area

 <?= $this->endSection() ?>