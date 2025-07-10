<!--==============================
	Footer Area
==============================-->
    <footer class="footer-wrapper footer-default" style="background-color: #202429;">
        <div class="widget-area">
            <div class="container">
                <div class="row justify-content-between">
                    <div class="col-md-6 col-xl-auto">
                        <div class="widget footer-widget">
                            <div class="th-widget-about">
                                <div class="about-logo">
                                    <a href="index.html"><img src="<?= base_url('uploads/' . ($settings['site_logo'] ?? 'default-logo.png')) ?>" alt="Logo" style="max-height: 60px;"></a>
                                </div>
                                <p class="about-text"><?= esc($tagline) ?></p>
                                <div class="th-social style5" stye="color: #DAD3C5">
                                    <a href="https://www.facebook.com/"><i class="fab fa-facebook-f"></i></a>
                                    <a href="https://www.twitter.com/"><i class="fab fa-twitter"></i></a>
                                    <a href="https://www.linkedin.com/"><i class="fab fa-linkedin-in"></i></a>
                                    <a href="https://www.youtube.com/"><i class="fab fa-youtube"></i></a>
                                    <a href="https://www.instagram.com/"><i class="fab fa-instagram"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-auto">
                        <div class="widget footer-widget">
                            <h3 class="widget_title">Get In Touch</h3>
                            <div class="th-widget-contact">
                                <div class="info-box_text">
                                    <div class="icon"><img src="<?= base_url('assets/frontend/img/icon/location-dot.svg') ?>" alt="img"></div>
                                    <div class="details">
                                        <p>789 Inner Lane, Holy park,</p>
                                        <p>California, USA</p>
                                    </div>
                                </div>
                                <div class="info-box_text">
                                    <div class="icon">
                                        <img src="<?= base_url('assets/frontend/img/icon/phone.svg') ?>" alt="img">
                                    </div>
                                    <div class="details">
                                        <p><a href="tel:+0123456789" class="info-box_link">+01 234 567 890</a></p>
                                        <p><a href="tel:+09876543210" class="info-box_link">+09 876 543 210</a></p>
                                    </div>
                                </div>
                                <div class="info-box_text">
                                    <div class="icon">
                                        <img src="<?= base_url('assets/frontend/img/icon/envelope.svg') ?>" alt="img">
                                    </div>
                                    <div class="details">
                                        <p><a href="mailto:mailinfo00@realar.com" class="info-box_link">mailinfo00@realar.com</a></p>
                                        <p><a href="mailto:support24@realar.com" class="info-box_link">support24@realar.com</a></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-auto">
                        <div class="widget widget_nav_menu footer-widget">
                            <h3 class="widget_title">Useful Link</h3>
                            <div class="menu-all-pages-container">
                                <ul class="menu">
                                    <li><a href="about.html">About us</a></li>
                                    <li><a href="property.html">Featured Properties</a></li>
                                    <li><a href="agency.html">Our Best Services</a></li>
                                    <li><a href="contact.html">Request Visit</a></li>
                                    <li><a href="contact.html">FAQ</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-auto">
                        <div class="widget widget_nav_menu footer-widget">
                            <h3 class="widget_title">Explore</h3>
                            <div class="menu-all-pages-container">
                                <ul class="menu">
                                    <li><a href="property.html">All Properties</a></li>
                                    <li><a href="team.html">Our Agents</a></li>
                                    <li><a href="property.html">All Projects</a></li>
                                    <li><a href="about.html">Our Process</a></li>
                                    <li><a href="contact.html">Neighborhood</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="copyright-wrap" style="background-color: #DAD3C5">
            <div class="container">
                <div class="row gy-3 align-items-center">
                    <div class="col-lg-6">
                        <p class="copyright-text" stye="text-color: #202429">
                            Copyright <i class="fal fa-copyright"></i> 2025 <a href="index.html">Realar</a>, All rights reserved.</p>
                    </div>
                    <div class="col-lg-6">
                        <div class="th-social justify-content-lg-end justify-content-center">
                            <a href="https://www.facebook.com/"><i class="fab fa-facebook-f"></i></a>
                            <a href="https://www.twitter.com/"><i class="fab fa-twitter"></i></a>
                            <a href="https://www.instagram.com/"><i class="fab fa-youtube"></i></a>
                            <a href="https://www.instagram.com/"><i class="fab fa-instagram"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scroll To Top -->
    <div class="scroll-top">
        <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
            <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" style="transition: stroke-dashoffset 10ms linear 0s; stroke-dasharray: 307.919, 307.919; stroke-dashoffset: 307.919;"></path>
        </svg>
    </div>
