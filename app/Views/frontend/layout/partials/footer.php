<!--==============================
	Footer Area
==============================-->
    <footer class="footer-wrapper footer-default" style="background: linear-gradient(to bottom left, #c4552e, #2a0f0b);">
        <div class="widget-area" style="padding-top: 50px; padding-bottom: 50px;">
            <div class="container">
                    <div class="col-md-12" style="text-align: center;">
                        <div class="widget footer-widget" style="margin-bottom: 20px;">

                                <h2 class="brand-title">
                                  <span class="orange">PROPERTY</span><span class="cream">PLACE</span>
                                </h2>

                                <style>
                                .brand-title {
                                  font-family: 'Outfit', sans-serif;
                                  font-size: 2rem;
                                  font-weight: 800;
                                  letter-spacing: 1px;
                                  text-transform: uppercase;
                                  margin: 0;
                                }

                                .brand-title .orange {
                                  color: #C4552E; /* oranye */
                                }

                                .brand-title .cream {
                                  color: #DAD3C5; /* krem terang */
                                }
                                </style>

                                <p class="about-text" style="color: #DAD3C5;"><?= esc($tagline) ?></p>
                                <div class="th-social style5 text-center">
                                  <?php if (!empty($settings['instagram'])): ?>
                                    <a href="https://www.instagram.com/<?= esc($settings['instagram']) ?>" target="_blank">
                                      <i class="fab fa-instagram"></i>
                                    </a>
                                  <?php endif; ?>

                                  <?php if (!empty($settings['facebook'])): ?>
                                    <a href="<?= esc($settings['facebook']) ?>" target="_blank">
                                      <i class="fab fa-facebook-f"></i>
                                    </a>
                                  <?php endif; ?>

                                  <?php if (!empty($settings['tiktok'])): ?>
                                    <a href="https://www.tiktok.com/@<?= esc($settings['tiktok']) ?>" target="_blank">
                                      <i class="fab fa-tiktok"></i>
                                    </a>
                                  <?php endif; ?>

                                  <?php if (!empty($settings['youtube'])): ?>
                                    <a href="<?= esc($settings['youtube']) ?>" target="_blank">
                                      <i class="fab fa-youtube"></i>
                                    </a>
                                  <?php endif; ?>
                                </div>

                                <style>
                                /* === Social Media Center Alignment === */
                                .th-social.style5 {
                                  display: flex;
                                  justify-content: center;
                                  align-items: center;
                                  gap: 14px;
                                  margin-top: 20px;
                                }

                                /* === Icon Style === */
                                .th-social.style5 a {
                                  display: flex;
                                  align-items: center;
                                  justify-content: center;
                                  width: 42px;
                                  height: 42px;
                                  border: 1px solid rgba(218, 211, 197, 0.6); /* warna lembut dari tema */
                                  border-radius: 50%;
                                  color: #DAD3C5;
                                  font-size: 1.2rem;
                                  transition: all 0.3s ease;
                                  text-decoration: none;
                                }

                                /* Hover Effect */
                                .th-social.style5 a:hover {
                                
                                  border-color: transparent;
                                  box-shadow: 0 0 15px rgba(196, 85, 46, 0.4);
                                  transform: translateY(-3px);
                                }
                                </style>



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
