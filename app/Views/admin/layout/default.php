<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title><?= esc($settings['site_name'] ?? 'My Site') ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Darkone: An advanced, fully responsive admin dashboard template packed with features to streamline your analytics and management needs." />
    <meta name="author" content="StackBros" />
    <meta name="keywords" content="Darkone, admin dashboard, responsive template, analytics, modern UI, management tools" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="robots" content="index, follow" />
    <meta name="theme-color" content="#ffffff">

    <!-- App favicon -->
    <link rel="shortcut icon" href="<?= base_url('uploads/' . ($settings['site_icon'] ?? 'default-icon.png')) ?>" sizes="320x320" type="image/png">

    <!-- Google Font Family link -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Play:wght@400;700&display=swap" rel="stylesheet">

    <!-- Vendor css -->
    <link href="<?= base_url('assets/admin/css/vendor.min.css') ?>" rel="stylesheet" type="text/css" />

    <!-- Icons css -->
    <link href="<?= base_url('assets/admin/css/icons.min.css') ?>" rel="stylesheet" type="text/css" />
    <!-- Font Awesome v6 via CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />


    <!-- App css -->
    <link href="<?= base_url('assets/admin/css/style.min.css') ?>" rel="stylesheet" type="text/css" />
    <style>
      /* Fix: Cegah scroll shift saat modal tampil */
      body.modal-open {
          overflow: hidden !important;
          padding-right: 0 !important;
      }

      /* Matikan animasi geser default Bootstrap */
      .modal.fade .modal-dialog {
          transform: none !important;
          transition: none !important;
      }

      /* Tambahan kenyamanan: blur backdrop */
      .modal-backdrop {
          backdrop-filter: blur(3px);
          background-color: rgba(0, 0, 0, 0.6);
      }

      /* Hindari horizontal scroll tersembunyi */
      html, body {
          overflow-x: hidden;
      }
    </style>


    <!-- Theme Config js -->
    <script src="<?= base_url('assets/admin/js/config.js') ?>"></script>
</head>

<body>

    <div class="preloader">
    <div id="preloader" class="preloader-inner text-center">
        <!-- Kutipan -->
        <div class="quote-text" id="quoteText">Loading quotes...</div>

        <!-- Loading Bar -->
        <div class="preloader-bar mt-4">
            <div class="preloader-bar-fill" id="preloaderProgress"></div>
        </div>

        <!-- Loading Text per huruf -->
        <div class="loading-letter-group mt-3" id="loadingLetters">
            <!-- huruf-huruf akan dimasukkan lewat JS -->
        </div>
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
    max-width: 80%;
    width: 100%;
    padding: 20px;
    text-align: center;
}

.quote-text {
    font-size: 16px;
    color: #dad3c5;
    font-weight: 500;
    line-height: 1.6;
    max-width: 600px;
    margin-bottom: 10px;
    animation: fadeIn 1s ease-in-out;
}

.preloader-bar {
    width: 100%;
    max-width: 240px;
    height: 6px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 4px;
    overflow: hidden;
}

.preloader-bar-fill {
    height: 100%;
    width: 0%;
    background: linear-gradient(90deg, #B86C3A, #DAD3C5);
    transition: width 0.3s ease;
}

.loading-letter-group {
    display: flex;
    justify-content: center;
    gap: 4px;
    margin-top: 16px;
}

.loading-letter {
    font-size: 14px;
    color: #dad3c5;
    opacity: 0;
    animation: fadeInLetter 0.4s forwards;
}

@keyframes fadeInLetter {
    from { opacity: 0; transform: translateY(6px); }
    to { opacity: 1; transform: translateY(0); }
}

</style>

<script>
    const quotes = [
        "Jualan properti itu bukan soal harga, tapi soal nilai yang Anda bawa.",
        "Kepercayaan adalah komisi terbaik dalam setiap penjualan rumah.",
        "Bukan hanya menjual rumah, Anda sedang membangun mimpi orang lain.",
        "Sukses menjual properti dimulai dari keyakinan pada diri sendiri.",
        "Lokasi bisa jadi segalanya, tapi integritas adalah segalanya juga.",
        "Jangan jual rumah—jual gaya hidup yang menyertainya.",
        "Setiap properti punya cerita. Ceritakan dengan penuh semangat.",
        "Menjadi agen properti sukses itu bukan bakat, tapi konsistensi.",
        "Koneksi membangun jaringan, pelayanan membangun karier.",
        "Percaya diri adalah fondasi pertama dari penjualan apa pun."
    ];

    const quoteEl = document.getElementById("quoteText");
    const loadingBar = document.getElementById("preloaderProgress");
    const loadingLetters = document.getElementById("loadingLetters");

    // Set kutipan acak
    quoteEl.textContent = quotes[Math.floor(Math.random() * quotes.length)];

    // Isi huruf loading per span
    const loadingText = "Loading...";
    loadingText.split("").forEach((char, i) => {
        const span = document.createElement("span");
        span.classList.add("loading-letter");
        span.textContent = char;
        span.style.animationDelay = `${i * 0.1}s`;
        loadingLetters.appendChild(span);
    });

    // Bar progresif
    let progress = 0;
    const interval = setInterval(() => {
        progress += Math.floor(Math.random() * 10) + 5;
        if (progress > 100) progress = 100;

        loadingBar.style.width = progress + "%";

        if (progress === 100) {
            setTimeout(() => {
                document.querySelector(".preloader").style.display = "none";
            }, 700);
            clearInterval(interval);
        }
    }, 300);
</script>


    <!-- Header -->
    <?= $this->include('admin/layout/partials/header') ?>

    <!-- Sidebar -->
    <?= $this->include('admin/layout/partials/sidebar') ?>

    <!-- Content -->
    <div class="content">
        <div class="page-content">
        <?= $this->renderSection('content') ?>
        
    </div>

    <!-- Vendor Javascript -->
    <script src="<?= base_url('assets/admin/js/vendor.min.js') ?>"></script>

    <!-- App Javascript -->
    <script src="<?= base_url('assets/admin/js/app.js') ?>"></script>

    <!-- Vector Map Js -->
    <script src="<?= base_url('assets/admin/vendor/jsvectormap/js/jsvectormap.min.js') ?>"></script>
    <script src="<?= base_url('assets/admin/vendor/jsvectormap/maps/world-merc.js') ?>"></script>
    <script src="<?= base_url('assets/admin/vendor/jsvectormap/maps/world.js') ?>"></script>

    <!-- Dashboard Js -->
    <script src="<?= base_url('assets/admin/js/pages/dashboard.js') ?>"></script>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const modalEl = document.getElementById('profileReminderModal');
        if (modalEl) {
            const modal = new bootstrap.Modal(modalEl, {
                backdrop: 'static',
                keyboard: false
            });
            modal.show();

            // Antisipasi Bootstrap yang kadang tambah padding-right ke <body>
            document.body.style.paddingRight = '0px';
            document.body.style.overflow = 'hidden';
        }
    });
    </script>

</body>
</html>
