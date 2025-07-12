<!doctype html>
<html lang="en" class="no-js" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title><?= esc($settings['site_name'] ?? 'My Site') ?></title>
    <meta name="author" content="PropertyPlace">
    <meta name="description" content="Realar - Real Estate Apartment Complex HTML Template">
    <meta name="keywords" content="PropertyPlace, Real Estate, Apartment, Listing">
    <meta name="robots" content="INDEX,FOLLOW">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="57x57" href="<?= base_url('uploads/' . ($settings['site_icon'] ?? 'default-icon.png')) ?>">
    <link rel="apple-touch-icon" sizes="60x60" href="<?= base_url('uploads/' . ($settings['site_icon'] ?? 'default-icon.png')) ?>">
    <link rel="apple-touch-icon" sizes="72x72" href="<?= base_url('uploads/' . ($settings['site_icon'] ?? 'default-icon.png')) ?>">
    <link rel="apple-touch-icon" sizes="76x76" href="<?= base_url('uploads/' . ($settings['site_icon'] ?? 'default-icon.png')) ?>">
    <link rel="apple-touch-icon" sizes="114x114" href="<?= base_url('uploads/' . ($settings['site_icon'] ?? 'default-icon.png')) ?>">
    <link rel="apple-touch-icon" sizes="120x120" href="<?= base_url('uploads/' . ($settings['site_icon'] ?? 'default-icon.png')) ?>">
    <link rel="apple-touch-icon" sizes="144x144" href="<?= base_url('uploads/' . ($settings['site_icon'] ?? 'default-icon.png')) ?>">
    <link rel="apple-touch-icon" sizes="152x152" href="<?= base_url('uploads/' . ($settings['site_icon'] ?? 'default-icon.png')) ?>">
    <link rel="apple-touch-icon" sizes="180x180" href="<?= base_url('uploads/' . ($settings['site_icon'] ?? 'default-icon.png')) ?>">
    <link rel="icon" type="image/png" sizes="192x192" href="<?= base_url('uploads/' . ($settings['site_icon'] ?? 'default-icon.png')) ?>">
    <link rel="icon" type="image/png" sizes="32x32" href="<?= base_url('uploads/' . ($settings['site_icon'] ?? 'default-icon.png')) ?>">
    <link rel="icon" type="image/png" sizes="96x96" href="<?= base_url('uploads/' . ($settings['site_icon'] ?? 'default-icon.png')) ?>">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= base_url('uploads/' . ($settings['site_icon'] ?? 'default-icon.png')) ?>">
    <link rel="manifest" href="<?= base_url('assets/frontend/img/favicons/manifest.json') ?>">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="<?= base_url('uploads/' . ($settings['site_icon'] ?? 'default-icon.png')) ?>">
    <meta name="theme-color" content="#ffffff">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&family=Outfit:wght@100..900&display=swap" rel="stylesheet">

    <!-- CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/frontend/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/frontend/css/fontawesome.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/frontend/css/magnific-popup.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/frontend/css/swiper-bundle.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/frontend/css/jquery.datetimepicker.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/frontend/css/style.css') ?>">
</head>

<body class="">

    <!--********************************
   		Code Start From Here 
	******************************** -->
    <div class="cursor-follower"></div>

    <!-- slider drag cursor -->
    <div class="slider-drag-cursor"><i class="fas fa-angle-left me-2"></i> DRAG <i class="fas fa-angle-right ms-2"></i></div>

    <!--==============================
    Preloader
==============================-->
    <div class="preloader ">
        <div id="preloader" class="preloader-inner">
            <div class="txt-loading">
                <span data-text-preloader="P" class="letters-loading">
                    P </span>
                <span data-text-preloader="R" class="letters-loading">
                    R </span>
                <span data-text-preloader="O" class="letters-loading">
                    O </span>
                <span data-text-preloader="P" class="letters-loading">
                    P
                </span>
                <span data-text-preloader="E" class="letters-loading">
                    E
                </span>
                <span data-text-preloader="R" class="letters-loading">
                    R
                </span>
                <span data-text-preloader="T" class="letters-loading">
                    T
                </span>
                <span data-text-preloader="Y" class="letters-loading">
                    Y
                </span>
                <br/>
                <span data-text-preloader="P" class="letters-loading">
                    P
                </span>
                <span data-text-preloader="L" class="letters-loading">
                    L
                </span>
                <span data-text-preloader="A" class="letters-loading">
                    A
                </span>
                <span data-text-preloader="C" class="letters-loading">
                    C
                </span>
                <span data-text-preloader="E" class="letters-loading">
                    E
                </span>
            </div>
        </div>
    </div>
    
    <?= $this->include('frontend/layout/partials/sidebar') ?>

    <?= $this->include('frontend/layout/partials/header') ?>

    <?= $this->renderSection('content') ?>

    <?= $this->include('frontend/layout/partials/footer') ?>

    <!-- JS -->
    <script src="<?= base_url('assets/frontend/js/vendor/jquery-3.7.1.min.js') ?>"></script>
    <script src="<?= base_url('assets/frontend/js/swiper-bundle.min.js') ?>"></script>
    <script src="<?= base_url('assets/frontend/js/bootstrap.min.js') ?>"></script>
    <script src="<?= base_url('assets/frontend/js/jquery.magnific-popup.min.js') ?>"></script>
    <script src="<?= base_url('assets/frontend/js/jquery.counterup.min.js') ?>"></script>
    <script src="<?= base_url('assets/frontend/js/jquery-ui.min.js') ?>"></script>
    <script src="<?= base_url('assets/frontend/js/imagesloaded.pkgd.min.js') ?>"></script>
    <script src="<?= base_url('assets/frontend/js/isotope.pkgd.min.js') ?>"></script>
    <script src="<?= base_url('assets/frontend/js/gsap.min.js') ?>"></script>
    <script src="<?= base_url('assets/frontend/js/jquery.datetimepicker.min.js') ?>"></script>
    <script src="<?= base_url('assets/frontend/js/threesixty.min.js') ?>"></script>
    <script src="<?= base_url('assets/frontend/js/panolens.min.js') ?>"></script>
    <script src="<?= base_url('assets/frontend/js/main.js') ?>"></script>

</body>
</html>
