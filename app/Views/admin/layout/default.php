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
