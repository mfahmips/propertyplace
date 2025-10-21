<!--==============================
	Footer Area
==============================-->
    <footer class="footer-wrapper footer-default" style="background-color: #202429;">
        <div class="widget-area">
            <div class="container">
                    <div class="col-md-12">
                        <div class="widget footer-widget">
                            <div class="th-widget-about">
                                <div class="about-logo">
                                    <a href="index.html"><img src="<?= base_url('uploads/' . ($settings['site_logo'] ?? 'default-logo.png')) ?>" alt="Logo" style="max-height: 60px;"></a>
                                </div>
                                <p class="about-text"><?= esc($tagline) ?></p>
                                <div class="th-social style5" stye="color: #DAD3C5">
                                    <a href="https://www.instagram.com/"><i class="fab fa-instagram"></i></a>
                                    <a href="https://www.facebook.com/"><i class="fab fa-facebook-f"></i></a>
                                    <a href="https://www.twitter.com/"><i class="fab fa-tiktok"></i></a>
                                    <a href="https://www.youtube.com/"><i class="fab fa-youtube"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
        <div class="copyright-wrap" style="background-color: #DAD3C5; text-align: center;">
            <div class="container">
                <div class="row gy-3 align-items-center justify-content-center">
                    <div class="col-lg-12">
                        <p class="copyright-text" style="color: #202429; margin: 0;">
                            Copyright <i class="fal fa-copyright"></i> 
                            <?= date('Y') ?> <?= esc($settings['site_name'] ?? 'PropertyPlace') ?>, All rights reserved.
                        </p>
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
