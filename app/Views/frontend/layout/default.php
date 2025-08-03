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
    <div class="preloader">
    <div id="preloader" class="preloader-inner text-center">
        <!-- Kutipan Inspiratif -->
        <div class="preloader-quote" id="preloaderQuote">
            "Loading..."
        </div>

        <!-- Progress Bar -->
        <div class="preloader-bar mt-4">
            <div class="preloader-bar-fill" id="preloaderProgress"></div>
        </div>

        <!-- Loading Text -->
        <div class="loading-text mt-3" id="loadingText">Loading...</div>
    </div>
</div>


    <style>
 .preloader {
    position: fixed;
    inset: 0;
    z-index: 9999;
    background-color: #0f0f1a;
    display: flex;
    justify-content: center;
    align-items: center;
}

.preloader-inner {
    display: flex;
    flex-direction: column;
    align-items: center;
    max-width: 600px;
    padding: 0 40px;
    text-align: center;
}

.preloader-quote {
    font-size: 22px;
    color: #dad3c5;
    font-style: italic;
    font-weight: 500;
    opacity: 0.95;
    min-height: 80px;
    line-height: 1.6;
}

.preloader-bar {
    width: 80%;
    height: 10px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 5px;
    overflow: hidden;
    margin-top: 20px;
}

.preloader-bar-fill {
    height: 100%;
    width: 0%;
    background: linear-gradient(90deg, #B86C3A, #DAD3C5);
    transition: width 0.3s ease;
}

.loading-text {
    font-size: 18px;
    color: #dad3c5;
    font-weight: 500;
    margin-top: 14px;
    opacity: 0.85;
}

    </style>

<script>
    const quotes = [
        "Investasi properti adalah warisan terbaik untuk masa depan.",
        "Beli tanah, mereka tidak membuatnya lagi. – Mark Twain",
        "Properti hari ini, keamanan finansial esok hari.",
        "Jangan menunggu beli properti. Beli properti dan tunggu.",
        "Properti adalah aset yang tumbuh bahkan saat Anda tidur.",
        "Nilai properti naik, tetapi waktu tidak bisa dibeli kembali.",
        "Satu rumah bisa mengubah masa depan sebuah generasi.",
        "Orang kaya membeli properti bukan karena butuh, tapi karena tahu nilainya."
    ];

    // Random quote
    const randomQuote = quotes[Math.floor(Math.random() * quotes.length)];
    document.getElementById("preloaderQuote").textContent = randomQuote;

    let progress = 0;
    const progressBar = document.getElementById("preloaderProgress");
    const loadingText = document.getElementById("loadingText");

    // Interval lambat
    const interval = setInterval(() => {
        progress += Math.floor(Math.random() * 4) + 1; // max 4%
        if (progress > 100) progress = 100;

        progressBar.style.width = progress + "%";

        if (progress >= 80 && progress < 100) {
            loadingText.textContent = "Almost done...";
        }

        if (progress === 100) {
            loadingText.textContent = "Selesai!";
            clearInterval(interval);

            // Delay sebelum hilang
            setTimeout(() => {
                document.querySelector(".preloader").style.opacity = "0";
                setTimeout(() => {
                    document.querySelector(".preloader").style.display = "none";
                }, 500);
            }, 1000); // Delay 1 detik saat selesai
        }
    }, 250); // interval update tiap 250ms (lebih lambat)
</script>





    
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
