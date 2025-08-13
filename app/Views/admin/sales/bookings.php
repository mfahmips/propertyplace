<?= $this->extend('admin/layout/default') ?>
<?= $this->section('content') ?>

<?php if (session()->getFlashdata('success')): ?>
  <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
  <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
<?php endif; ?>

<?php
  $isSales = session('role') === 'sales';
  $isAdmin = session('role') === 'admin';
?>

<div class="container-fluid">
  <div class="page-title-box">
    <h4 class="mb-0"><?= esc($title ?? 'Booking Unit') ?></h4>
    <ol class="breadcrumb mb-0">
      <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Dashboard</a></li>
      <li class="breadcrumb-item">Sales Activity</li>
      <li class="breadcrumb-item active">Booking</li>
    </ol>
  </div>

  <?php if ($isSales): ?>
  <div class="card">
    <div class="card-body d-flex flex-column align-items-center gap-3">
      <button class="btn btn-primary w-50" data-bs-toggle="modal" data-bs-target="#modalBooking">Booking Unit Baru</button>
    </div>
  </div>

  <div class="modal fade" id="modalBooking" tabindex="-1" aria-labelledby="modalBookingLabel" aria-hidden="true">
    <div class="modal-dialog">
      <form action="<?= base_url('dashboard/SalesActivity/bookings/save') ?>" method="post" enctype="multipart/form-data" class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Form Booking Unit</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="property_id" class="form-label">Property</label>
            <select name="property_id" id="property_id" class="form-select" required>
              <option value="">-- Pilih Property --</option>
              <?php foreach ($properties as $prop): ?>
                <option value="<?= $prop['id'] ?>"><?= esc($prop['title']) ?></option>
              <?php endforeach ?>
            </select>
          </div>
          <div class="mb-3">
            <label for="type_id" class="form-label">Tipe Unit</label>
            <select name="type_id" id="type_id" class="form-select" required>
              <option value="">-- Pilih Tipe --</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="unit_number" class="form-label">No Unit (Opsional)</label>
            <input type="text" name="unit_number" class="form-control" placeholder="Misal: A1, 10B">
          </div>
          <div class="mb-3">
            <label for="buyer_name" class="form-label">Nama Pembeli</label>
            <input type="text" name="buyer_name" class="form-control" required>
          </div>
          <div class="mb-3">
            <label for="buyer_phone" class="form-label">No. HP Pembeli</label>
            <input type="text" name="buyer_phone" class="form-control" required>
          </div>
          <div class="mb-3">
            <label for="buyer_email" class="form-label">Email Pembeli (Opsional)</label>
            <input type="email" name="buyer_email" class="form-control">
          </div>
          <div class="mb-3">
            <label for="price" class="form-label">Harga Booking</label>
            <input type="number" name="price" class="form-control">
          </div>
          <div class="mb-3">
            <label for="deposit_amount" class="form-label">Jumlah DP</label>
            <input type="number" name="deposit_amount" class="form-control">
          </div>
          <div class="mb-3">
            <label for="deposit_receipt" class="form-label">Upload Bukti DP</label>
            <input type="file" name="deposit_receipt" class="form-control">
          </div>
        </div>
        <div class="modal-footer">
          <button class="btn btn-primary w-100">Simpan Booking</button>
        </div>
      </form>
    </div>
  </div>
  <?php endif; ?>

  <div class="row mt-4">
    <?php if (!empty($bookings)): ?>
      <?php foreach ($bookings as $item): ?>
        <?php 
          $status = strtolower($item['status'] ?? ''); 
          $badge = match($status) {
            'pending'   => 'bg-secondary',
            'reserved'  => 'bg-warning',
            'confirmed' => 'bg-success',
            'cancelled', 'expired' => 'bg-danger',
            default     => 'bg-light'
          };
        ?>
        <div class="col-12 col-md-6 col-xl-4 mb-4">
          <div class="card h-100 pricing-basic">
            <div class="card-body d-flex flex-column">
              <h4 class="fw-bold"><?= esc($item['property_title']) ?></h4>
              <p class="mb-1">Rp<?= number_format($item['price'], 0, ',', '.') ?> 
                Tipe: <?= esc($item['type_name']) ?>
              </p>
              <p class="mb-1">Dipesan oleh: <strong><?= esc($item['buyer_name']) ?></strong></p>
              <p class="mb-1">No. HP: <?= esc($item['buyer_phone']) ?></p>
              <p class="mb-3">Email: <?= esc($item['buyer_email'] ?: '-') ?></p>
              <ul class="mb-3 ps-3">
                <li>No. Unit: <?= esc($item['unit_number'] ?: '-') ?></li>
                <li>Harga Booking: Rp <?= number_format($item['deposit_amount'] ?? 0, 0, ',', '.') ?></li>
                <li>Status: <span class="badge <?= $badge ?>"><?= ucfirst($status) ?></span></li>
                <li>Metode Bayar: <?= esc($item['payment_plan'] ?? '-') ?></li>
                <li>Catatan: <?= esc($item['notes'] ?? '-') ?></li>
              </ul>
              <div class="mt-auto mb-3">
                <?php if (!empty($item['deposit_receipt'])): ?>
                  <a href="<?= base_url($item['deposit_receipt']) ?>" class="btn btn-outline-primary w-100" target="_blank">
                    Lihat Bukti DP
                  </a>
                <?php else: ?>
                  <button class="btn btn-outline-secondary w-100" disabled>Tidak ada bukti</button>
                <?php endif; ?>
              </div>

              <?php if ($isAdmin): ?>
                <form action="<?= base_url('dashboard/SalesActivity/bookings/update') ?>" method="post">
                  <input type="hidden" name="id" value="<?= $item['id'] ?>">
                  <div class="row">
                    <div class="col-md-6 mb-3">
                      <label class="form-label">Status Booking</label>
                      <select name="status" class="form-select" required>
                        <?php
                          $statusOptions = ['pending', 'reserved', 'confirmed', 'cancelled', 'expired'];
                          foreach ($statusOptions as $opt):
                        ?>
                          <option value="<?= $opt ?>" <?= $opt === $item['status'] ? 'selected' : '' ?>>
                            <?= ucfirst($opt) ?>
                          </option>
                        <?php endforeach ?>
                      </select>
                    </div>
                    <div class="col-md-6 mb-3 d-flex align-items-end">
                      <button class="btn btn-success w-100">Update</button>
                    </div>
                  </div>
                </form>
              <?php endif; ?>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <div class="col-12">
        <div class="alert alert-warning text-center">Belum ada data booking.</div>
      </div>
    <?php endif; ?>
  </div>
</div>

<script>
document.getElementById('property_id')?.addEventListener('change', function () {
  const propertyId = this.value;
  const typeSelect = document.getElementById('type_id');

  fetch(`<?= base_url('dashboard/SalesActivity/getTypesByProperty') ?>/${propertyId}`)
    .then(res => res.json())
    .then(result => {
      typeSelect.innerHTML = '';
      if (!result.success || result.data.length === 0) {
        typeSelect.innerHTML = '<option value="">Tidak ada unit</option>';
        return;
      }

      typeSelect.innerHTML = '<option value="">-- Pilih Tipe --</option>';
      result.data.forEach(type => {
        const opt = document.createElement('option');
        opt.value = type.id;
        opt.textContent = type.name;
        typeSelect.appendChild(opt);
      });
    })
    .catch(err => {
      console.error(err);
      typeSelect.innerHTML = '<option value="">Error memuat tipe</option>';
    });
});
</script>

<?= $this->endSection() ?>
