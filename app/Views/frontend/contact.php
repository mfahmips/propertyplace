<?= $this->extend('frontend/layout/default') ?>

<?= $this->section('content') ?>
<!--==============================
Contact Area  
==============================-->
    <div class="space">
        <div class="container">
            <div class="title-area text-center">
                <span class="sub-title">Get In Touch</span>
                <h2 class="sec-title text-theme">Our Contact Information</h2>
            </div>
            <div class="row gy-4 justify-content-center">
                <div class="col-xl-4 col-lg-6">
                    <div class="about-contact-grid style2">
                        <div class="about-contact-icon">
                            <i class="fal fa-location-dot"></i>
                        </div>
                        <div class="about-contact-details">
                            <h6 class="about-contact-details-title">Our Address</h6>
                            <p class="about-contact-details-text">2690 Hiltona Street Victoria</p>
                            <p class="about-contact-details-text">Road, New York, Canada</p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-6">
                    <div class="about-contact-grid style2">
                        <div class="about-contact-icon">
                            <i class="fal fa-phone"></i>
                        </div>
                        <div class="about-contact-details">
                            <h6 class="about-contact-details-title">Phone Number</h6>
                            <p class="about-contact-details-text"><a href="tel:01234567890">+01 234 567 890</a></p>
                            <p class="about-contact-details-text"><a href="tel:01234567890">+09 876 543 210</a></p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-6">
                    <div class="about-contact-grid style2">
                        <div class="about-contact-icon">
                            <i class="fal fa-envelope"></i>
                        </div>
                        <div class="about-contact-details">
                            <h6 class="about-contact-details-title">Email Address</h6>
                            <p class="about-contact-details-text"><a href="mailto:mailinfo00@realar.com">mailinfo00@realar.com</a></p>
                            <p class="about-contact-details-text"><a href="mailto:support24@realar.com">support24@realar.com</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><!--==============================
Contact Area   
==============================-->
    <div class="space contact-area-3 z-index-common" data-bg-src="assets/img/bg/contact-bg-1-1.png" data-overlay="title" data-opacity="3" id="contact-sec">
        <div class="contact-bg-shape3-1 spin shape-mockup " data-bottom="5%" data-left="12%">
            <img src="assets/img/shape/section_shape_2_1.jpg" alt="img">
        </div>
        <div class="container">
            <div class="row gx-35">
                <div class="col-lg-6">
                    <div class="appointment-wrap2 bg-white me-xxl-5">
                        <h2 class="form-title text-theme">Schedule a visit</h2>
                        <form action="mail.php" method="POST" class="appointment-form ajax-contact">
                            <div class="row">
                                <div class="form-group style-border style-radius col-12">
                                    <input type="text" class="form-control" name="name" id="name" placeholder="Your Name*">
                                    <i class="fal fa-user"></i>
                                </div>
                                <div class="form-group style-border style-radius col-12">
                                    <input type="email" class="form-control" name="email" id="email" placeholder="Your Email*">
                                    <i class="fal fa-envelope"></i>
                                </div>
                                <div class="form-group style-border style-radius col-md-12">
                                    <select name="subject" id="subject" class="form-select">
                                        <option value="" disabled selected hidden>Select Service Type</option>
                                        <option value="Real Estate">Real Estate</option>
                                        <option value="Apartment">Apartment</option>
                                        <option value="Residencial">Residencial</option>
                                        <option value="Deluxe">Deluxe</option>
                                    </select>
                                    <i class="fal fa-angle-down"></i>
                                </div>
                                <div class="col-12 form-group style-border style-radius">
                                    <i class="far fa-comments"></i>
                                    <textarea placeholder="Type Your Message" class="form-control"></textarea>
                                </div>
                                <div class="col-12 form-btn mt-4">
                                    <button class="th-btn">Submit Message <span class="btn-icon"><img src="assets/img/icon/paper-plane.svg" alt="img"></span></button>
                                </div>
                            </div>
                            <p class="form-messages mb-0 mt-3"></p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="location-map contact-sec-map z-index-common">
            <div class="contact-map">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3644.7310056272386!2d89.2286059153658!3d24.00527418490799!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39fe9b97badc6151%3A0x30b048c9fb2129bc!2sAngfuztheme!5e0!3m2!1sen!2sbd!4v1651028958211!5m2!1sen!2sbd" allowfullscreen="" loading="lazy"></iframe>
            </div>
            <div class="location-map-address bg-theme">
                <div class="thumb">
                    <img src="assets/img/property/property_inner_1.jpg" alt="img">
                </div>
                <div class="media-body">
                    <h4 class="title">Address:</h4>
                    <p class="text">Brooklyn, New York 11233, United States</p>
                    <h4 class="title">Post Code:</h4>
                    <p class="text">12345</p>
                </div>
            </div>
        </div>
    </div>

    <?= $this->endSection() ?>