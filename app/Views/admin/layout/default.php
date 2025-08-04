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
    "Closing bukan kebetulan, tapi kebiasaan.",
    "Sales hebat bukan yang banyak janji, tapi yang banyak aksi.",
    "Setiap properti adalah peluang.",
    "Konsisten menjual, konsisten sukses.",
    "Bicara properti, bicara masa depan.",
    "Keraguan membunuh lebih banyak deal daripada penolakan.",
    "Sukses jual rumah, sukses bangun mimpi.",
    "Kunci properti? Percaya diri dan follow-up.",
    "Bukan soal harga, tapi solusi.",
    "Jangan jual rumah, jual harapan.",
    "Follow-up hari ini, closing esok hari.",
    "Properti bagus hanya dimiliki yang cepat ambil keputusan.",
    "Prospek bukan untuk dikoleksi, tapi dikonversi.",
    "Setiap ‘tidak’ mendekatkan ke ‘ya’.",
    "Sales bukan sekadar pekerjaan, tapi misi.",
    "Punya target? Kejar sampai dapat.",
    "Kamu bukan hanya menjual rumah, kamu mengubah hidup.",
    "Properti dijual setiap hari, kamu tinggal pilih ambil bagian.",
    "Kunci penjualan? Percaya produk, percaya diri.",
    "Jangan tunggu motivasi, jadilah motivasi.",
    "Kalau belum closing, belum berhenti.",
    "Satu hari tanpa action, satu deal melayang.",
    "Pelanggan puas, branding jalan.",
    "Kerja keras + kerja cerdas = properti terjual.",
    "Yang cepat menang, yang tanggap closing.",
    "Bantu orang punya rumah, rezeki datang sendiri.",
    "Pendengar yang baik, closer yang tangguh.",
    "Satu rumah terjual, satu keluarga bahagia.",
    "Uang ada, kemauan harus dibangun.",
    "Dekati hati, baru tawarkan harga.",
    "Semua orang butuh rumah, tugasmu bantu mereka temukan.",
    "Layanan luar biasa = repeat buyer.",
    "Tanya bukan untuk jual, tapi untuk tahu kebutuhan.",
    "Bukan jual rumah besar, tapi bantu impian besar.",
    "Sabar saat prospek, semangat saat deal.",
    "Emosi jual, logika beli.",
    "Jangan jual cepat, jual tepat.",
    "Kunci rumah impian? Kamu yang pegang.",
    "Buat klien percaya, dompet terbuka.",
    "Nilai rumah terukur, nilai pelayanan tak ternilai.",
    "Follow-up bukan ganggu, tapi perhatian.",
    "Prospek bukan statistik, tapi manusia.",
    "Setiap obrolan bisa jadi closing.",
    "Jangan jual, bantu mereka beli.",
    "Tawarkan solusi, bukan desakan.",
    "Temui klien, bukan alasan.",
    "Pahami kebutuhan, bukan hanya target.",
    "Pekerjaanmu bukan menjual, tapi mempermudah keputusan.",
    "Kepercayaan dibangun dari pelayanan, bukan harga.",
    "Tepat sasaran, hemat tenaga.",
    "Bangun pagi, kejar closing.",
    "Jangan takut ditolak, takutlah tidak mencoba.",
    "Ragu-ragu bikin rugi.",
    "Bicara properti, bicara aksi.",
    "Sukses milik yang gigih.",
    "Target ada untuk dilewati.",
    "Berhenti menunda, mulai bergerak.",
    "Disiplin hari ini, reward bulan depan.",
    "Closing tidak datang, closing dikejar.",
    "Setiap minggu harus punya cerita sukses.",
    "Modalmu: niat, relasi, semangat.",
    "Tim hebat bukan tanpa masalah, tapi penuh solusi.",
    "Mulai dari nol, selesaikan dengan deal.",
    "Gagal hari ini, bangkit esok hari.",
    "Jadwal penuh = dompet tebal.",
    "Main aman? Bukan mental sales.",
    "Ambil risiko, ambil hasil.",
    "Lawan malas, menangkan rezeki.",
    "Satu tindakan kecil lebih kuat dari 100 rencana.",
    "Gagal follow-up = gagal closing.",
    "Fokus hari ini, bonus akhir bulan.",
    "Semangat pagi, semangat jualan.",
    "Bekerja seperti pengusaha, bukan karyawan.",
    "Yang beda itu servis, bukan harga.",
    "Satu rumah, satu langkah menuju kebebasan finansial.",
    "Banyak prospek, banyak peluang.",
    "Kuasai produk, kuasai pasar.",
    "Selalu siap, selalu sigap.",
    "Rumah impian klien, jadi kenyataan berkatmu.",
    "Penjualan adalah skill, bukan hoki.",
    "Tiap chat balasan = potensi transaksi.",
    "Penolakan bukan akhir, tapi awal evaluasi.",
    "Semakin banyak ketemu orang, semakin dekat closing.",
    "Jualan properti, jalan ke kemerdekaan finansial.",
    "Berani ambil alih, berani hasil lebih.",
    "Fokus pada hasil, bukan alasan.",
    "Bukan siapa cepat, tapi siapa konsisten.",
    "Prospek panas jangan dibiarkan dingin.",
    "Bangun kepercayaan, closing mengalir.",
    "Bukan hanya rumah dijual, tapi nilai.",
    "Kamu dibayar seberapa besar kamu membantu.",
    "Setiap hari adalah hari jual.",
    "Buat dirimu dicari, bukan mencari.",
    "Klien yang puas adalah promosi gratis.",
    "Jualan itu permainan emosi dan solusi.",
    "Jangan tunggu kondisi ideal, jadilah profesional.",
    "Tugasmu bukan meyakinkan, tapi membuat paham.",
    "Kapan pun, di mana pun, properti tetap peluang.",
    "Tentukan goal, jangan tunggu momentum.",
    "Sales properti sejati tak pernah kehabisan cara."
];

const quoteEl = document.getElementById("quoteText");
const loadingBar = document.getElementById("preloaderProgress");
const loadingLetters = document.getElementById("loadingLetters");

if (quoteEl) {
  quoteEl.textContent = quotes[Math.floor(Math.random() * quotes.length)];
}

// Optional: animasi loading
const loadingText = "Loading...";
if (loadingLetters) {
  loadingText.split("").forEach((char, i) => {
    const span = document.createElement("span");
    span.classList.add("loading-letter");
    span.textContent = char;
    span.style.animationDelay = `${i * 0.2}s`;
    loadingLetters.appendChild(span);
  });
}

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

    <!-- Sidebar -->
    <?= $this->include('admin/layout/partials/footer') ?>

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
