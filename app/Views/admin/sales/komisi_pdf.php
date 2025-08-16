<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Pengajuan Komisi</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      font-size: 12px;
      margin: 40px;
      color: #000;
    }

    .header,
    .footer {
      text-align: center;
      margin-bottom: 30px;
    }

    .header img {
      max-height: 60px;
      margin-bottom: 10px;
    }

    .header h1 {
      font-size: 20px;
      color: #d0860f;
      margin: 5px 0;
    }

    .header small {
      font-size: 12px;
      color: #888;
    }

    .info-table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 20px;
    }

    .info-table td {
      padding: 6px 10px;
      border-bottom: 1px solid #ccc;
      vertical-align: top;
    }

    .info-table tr td:first-child {
      width: 30%;
      font-weight: bold;
    }

    .signature-table {
      width: 100%;
      text-align: center;
      margin-top: 30px;
    }

    .signature-table td {
      padding: 20px 10px;
    }

    .signature-table td small {
      display: block;
      margin-top: 5px;
      color: #777;
    }

    .no-print {
      display: block;
    }

    @media print {
      .no-print {
        display: none !important;
      }

      body {
        -webkit-print-color-adjust: exact !important;
        print-color-adjust: exact !important;
      }

      .header,
      .footer {
        position: static !important;
      }
    }
  </style>
</head>
<body>

  <!-- HEADER -->
  <div class="header">
    <?php if (!empty($settings['site_logo'])): ?>
      <img src="<?= base_url('uploads/' . $settings['site_logo']) ?>" alt="Logo">
    <?php endif; ?>
    <h1><?= esc($settings['site_name'] ?? 'Property Place') ?></h1>
    <small><?= esc($settings['tagline'] ?? 'Pilihan tepat mencari properti terbaik') ?></small>
  </div>

  <hr>

  <!-- INFO UTAMA -->
  <table class="info-table">
    <tr>
      <td>No. Booking</td>
      <td>#<?= esc($komisi['booking_code']) ?></td>
    </tr>
    <tr>
      <td>Tanggal Pengajuan</td>
      <td><?= date('d/m/Y H:i', strtotime($komisi['tanggal_ajuan'])) ?></td>
    </tr>
    <tr>
      <td>Status</td>
      <td><?= ucfirst($komisi['status']) ?></td>
    </tr>
    <tr>
      <td>Sales</td>
      <td><?= esc($komisi['sales_name']) ?> (<?= esc($komisi['sales_username']) ?>)</td>
    </tr>
    <tr>
      <td>Pembeli</td>
      <td><?= esc($komisi['buyer_name']) ?></td>
    </tr>
    <tr>
      <td>Unit</td>
      <td><?= esc($komisi['property_title'] ?? '-') ?> / <?= esc($komisi['type_name'] ?? '-') ?> / <?= esc($komisi['unit_number'] ?? '-') ?></td>
    </tr>
    <tr>
      <td>Harga Properti</td>
      <td>Rp <?= number_format((float)$komisi['price'], 0, ',', '.') ?></td>
    </tr>
    <tr>
      <td>Persentase Komisi</td>
      <td><?= $komisi['komisi_persen'] ? $komisi['komisi_persen'] . '%' : '-' ?></td>
    </tr>
    <tr>
      <td>Nominal Komisi</td>
      <td><?= $komisi['komisi_nominal'] ? 'Rp ' . number_format($komisi['komisi_nominal'], 0, ',', '.') : '-' ?></td>
    </tr>
    <tr>
      <td>Catatan</td>
      <td><?= $komisi['catatan'] ?: '-' ?></td>
    </tr>
  </table>

  <p>Demikian pengajuan ini dibuat untuk diproses sesuai prosedur yang berlaku.</p>

  <!-- TTD -->
  <table class="signature-table">
    <tr>
      <td>Diajukan Oleh,</td>
      <td>Disetujui Oleh,</td>
      <td>Direktur Keuangan</td>
      <td>Direktur Utama</td>
    </tr>
    <tr>
      <td>( <?= esc($admin) ?> )</td>
      <td>( ............................ )</td>
      <td>( ............................ )</td>
      <td>( ............................ )</td>
    </tr>
  </table>

  <!-- TOMBOL CETAK -->
  <?php if (!empty($preview_mode)): ?>
    <div class="no-print" style="text-align:center; margin: 40px 0;">
      <button onclick="window.print()" style="padding: 10px 20px; font-size: 16px;">Cetak PDF</button>
    </div>
  <?php endif; ?>

  <!-- FOOTER -->
  <div class="footer">
    <small><?= base_url() ?> | <?= esc($settings['site_name'] ?? '') ?> &copy; <?= date('Y') ?></small>
  </div>

</body>
</html>
