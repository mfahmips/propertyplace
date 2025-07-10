<header class="th-header header-default" style="background-color: #202429;">
    <div class="sticky-wrapper">
        <!-- Main Menu Area -->
        <div class="menu-area">
            <div class="container">
                <div class="row align-items-center justify-content-between">
                    <div class="col-auto">
                        <div class="header-logo">
                            <a href="<?= base_url('/') ?>">
                                <img src="<?= base_url('uploads/' . ($settings['site_logo'] ?? 'default-logo.png')) ?>" alt="Logo" style="max-height: 60px;">
                            </a>
                        </div>
                    </div>
                    <div class="col-auto">
                        <nav class="main-menu d-none d-lg-inline-block">
                            <ul>
                                <li><a href="<?= base_url('/') ?>" style="color: #DAD3C5;">Home</a></li>
                                <li style="color: #DAD3C5;"><a href="<?= base_url('/about') ?>" style="color: #DAD3C5;">About Us</a></li>

                                <li class="menu-item-has-children">
                                    <a href="#" >Properties</a>
                                    <ul class="sub-menu" style="background-color: #DAD3C5;">
                                        <li><a href="<?= base_url('/property') ?>" style="color: #B86C3A;">All Properties</a></li>
                                        <li><a href="<?= base_url('/property/detail/sample') ?>" style="color: #B86C3A;">Property Details</a></li>
                                    </ul>
                                </li>

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

                        <!-- Mobile button -->
                        <div class="header-button d-flex d-lg-none">
                            <button type="button" class="th-menu-toggle sidebar-btn">
                                <span class="line"></span>
                                <span class="line"></span>
                                <span class="line"></span>
                            </button>
                        </div>
                    </div>

                    <div class="col-auto d-none d-xxl-block">
                        <div class="header-button"  style="color: #DAD3C5;">
                            <a href="<?= base_url('/contact') ?>" class="th-btn style-border th-btn-icon"  style="color: #DAD3C5;">Request A Visit</a>
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
