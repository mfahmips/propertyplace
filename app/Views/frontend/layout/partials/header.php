<!--==============================
    Mobile Menu
  ============================== -->
    <div class="th-menu-wrapper onepage-nav">
        <div class="th-menu-area text-center">
            <button class="th-menu-toggle"><i class="fal fa-times"></i></button>
            <div class="mobile-logo" style="background: linear-gradient(to bottom left, #c4552e, #2a0f0b);">
                <h2 class="brand-title" style="font-size: 1.5rem;">
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
                    <p class="about-text" style="color: #DAD3C5; font-size: 12px;"><?= esc($tagline) ?></p>
            </div>
            <div class="th-mobile-menu">
                <ul>
                                <li><a href="<?= base_url('/') ?>">Home</a></li>
                                <li><a href="<?= base_url('/about') ?>">About Us</a></li>

                                <li><a href="<?= base_url('/property') ?>">Property</a></li>
                                
                                <li class="menu-item-has-children">
                                    <a href="<?= base_url('/blog') ?>">Blog</a>
                                    <ul class="sub-menu">
                                        <li><a href="<?= base_url('/blog') ?>">Blog Page</a></li>
                                        <li><a href="<?= base_url('/blog/detail/sample') ?>">Blog Details</a></li>
                                    </ul>
                                </li>

                                <li><a href="<?= base_url('/contact') ?>">Contact Us</a></li>
                            </ul>
            </div>
        </div>
    </div><!--==============================
    Sidemenu
============================== -->
    <div class="sidemenu-wrapper sidemenu-info d-none d-lg-block ">
        <div class="sidemenu-content">
            <button class="closeButton sideMenuCls"><i class="far fa-times"></i></button>
            <div class="widget  ">
                <div class="th-widget-about">
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
                    <p class="about-text"><?= esc($tagline) ?></p>
                </div>
            </div>
            <div class="widget  ">
                <h3 class="widget_title">Get In Touch</h3>
                <div class="th-widget-contact">
                    <div class="info-box_text">
                        <div class="icon"><img src="assets/img/icon/location-dot.svg" alt="img"></div>
                        <div class="details">
                            <p>789 Inner Lane, Holy park,</p>
                            <p>California, USA</p>
                        </div>
                    </div>
                    <div class="info-box_text">
                        <div class="icon">
                            <img src="assets/img/icon/phone.svg" alt="img">
                        </div>
                        <div class="details">
                            <p><a href="tel:+0123456789" class="info-box_link">+01 234 567 890</a></p>
                            <p><a href="tel:+09876543210" class="info-box_link">+09 876 543 210</a></p>
                        </div>
                    </div>
                    <div class="info-box_text">
                        <div class="icon">
                            <img src="assets/img/icon/envelope.svg" alt="img">
                        </div>
                        <div class="details">
                            <p><a href="mailto:mailinfo00@realar.com" class="info-box_link">mailinfo00@realar.com</a></p>
                            <p><a href="mailto:support24@realar.com" class="info-box_link">support24@realar.com</a></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="widget newsletter-widget  ">
                <h3 class="widget_title">Subscribe Now</h3>
                <form class="newsletter-form">
                    <div class="form-group">
                        <input class="form-control" type="email" placeholder="Email Address" required="">
                        <button type="submit" class="th-btn"><i class="far fa-paper-plane text-theme"></i></button>
                    </div>
                </form>
                <div class="th-social style2">
                    <a href="https://www.facebook.com/"><i class="fab fa-facebook-f"></i></a>
                    <a href="https://www.twitter.com/"><i class="fab fa-twitter"></i></a>
                    <a href="https://www.linkedin.com/"><i class="fab fa-linkedin-in"></i></a>
                    <a href="https://www.behance.com/"><i class="fab fa-behance"></i></a>
                    <a href="https://www.vimeo.com/"><i class="fab fa-vimeo-v"></i></a>
                </div>
            </div>
        </div>
    </div><!--==============================
    Header Area
==============================-->
    <header class="th-header header-default onepage-nav" style="background: linear-gradient(to bottom left, #c4552e, #2a0f0b);">
        <div class="sticky-wrapper">
            <!-- Main Menu Area -->
            <div class="menu-area" style="background: linear-gradient(to bottom left, #c4552e, #2a0f0b);">
                <div class="container">
                    <div class="row align-items-center justify-content-between">
                        <div class="col-auto">
                            <div class="header-logo">
                              <a href="<?= base_url('/') ?>">
                                <img 
                                  src="<?= base_url('uploads/' . ($settings['site_logo'] ?? 'default-logo.png')) ?>"
                                  alt="<?= esc($settings['site_name'] ?? 'PropertyPlace') ?>"
                                  class="glow-logo"
                                  style="max-height:60px;">
                              </a>
                            </div>
                        </div>
                        <div class="col-auto">
                            <nav class="main-menu d-none d-lg-inline-block">
                            <ul>
                                <li><a href="<?= base_url('/') ?>" style="color: #DAD3C5;">Home</a></li>
                                <li style="color: #DAD3C5;"><a href="<?= base_url('/about') ?>" style="color: #DAD3C5;">About Us</a></li>

                                <li style="color: #DAD3C5;"><a href="<?= base_url('/property') ?>" style="color: #DAD3C5;">Property</a></li>
                                
                                <li class="menu-item-has-children">
                                    <a href="<?= base_url('/blog') ?>" style="color: #DAD3C5;">Blog</a>
                                    <ul class="sub-menu">
                                        <li><a href="<?= base_url('/blog') ?>">Blog Page</a></li>
                                        <li><a href="<?= base_url('/blog/detail/sample') ?>">Blog Details</a></li>
                                    </ul>
                                </li>

                                <li><a href="<?= base_url('/contact') ?>" style="color: #DAD3C5;">Contact Us</a></li>
                            </ul>
                            </nav>
                            <div class="header-button d-flex d-lg-none">
                                <button type="button" class="th-menu-toggle sidebar-btn" style="background-color: transparent;">
                                    <span class="line"></span>
                                    <span class="line"></span>
                                    <span class="line"></span>
                                </button>
                            </div>
                        </div>
                        <div class="col-auto d-none d-xxl-block">
                            <div class="header-button">
                                <a href="contact.html" class="th-btn style-border th-btn-icon">Request A Visit</a>
                                <button type="button" class="simple-icon sideMenuInfo sidebar-btn style2">
                                    <span class="line"></span>
                                    <span class="line"></span>
                                    <span class="line"></span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

<style>
.glow-logo {
  display: inline-block;
  border: none;
  border-radius: 0; /* pastikan tidak ada rounding yang memunculkan tepi */
  background: transparent; /* hapus latar apapun */
  transition: transform 0.4s ease, filter 0.4s ease, box-shadow 0.4s ease;
  animation: logoGlow 3s infinite ease-in-out;
  filter: drop-shadow(0 0 15px rgba(196, 85, 46, 0.4)); /* gunakan drop-shadow, bukan box-shadow */
}

/* Hover: lebih terang tanpa lingkaran tepi */
.glow-logo:hover {
  transform: scale(1.07);
  filter: drop-shadow(0 0 25px rgba(196, 85, 46, 0.7)) brightness(1.1);
}

/* Animasi glow lembut */
@keyframes logoGlow {
  0% {
    filter: drop-shadow(0 0 10px rgba(196, 85, 46, 0.2));
  }
  50% {
    filter: drop-shadow(0 0 25px rgba(196, 85, 46, 0.5));
  }
  100% {
    filter: drop-shadow(0 0 10px rgba(196, 85, 46, 0.2));
  }
}

</style>
