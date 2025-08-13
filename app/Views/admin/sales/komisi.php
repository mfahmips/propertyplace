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
    <h4 class="mb-0"><?= esc($title ?? 'Pengajuan Komisi') ?></h4>
    <ol class="breadcrumb mb-0">
      <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Dashboard</a></li>
      <li class="breadcrumb-item">Sales Activity</li>
      <li class="breadcrumb-item active">Komisi</li>
    </ol>
  </div>

  <?php if ($isSales): ?>
  <!-- Tombol Ajukan Komisi -->
  <div class="card">
    <div class="card-body d-flex flex-column align-items-center gap-3">
      <button class="btn btn-primary w-50" data-bs-toggle="modal" data-bs-target="#modalAjukanKomisi">Ajukan Komisi</button>
    </div>
  </div>

  <!-- Modal Ajukan Komisi -->
  <div class="modal fade" id="modalAjukanKomisi" tabindex="-1" aria-labelledby="modalAjukanKomisiLabel" aria-hidden="true">
    <div class="modal-dialog">
      <form action="<?= base_url('dashboard/SalesActivity/komisi/save') ?>" method="post" enctype="multipart/form-data" class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalAjukanKomisiLabel">Form Pengajuan Komisi</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="property_id" class="form-label">Property</label>
            <select name="property_id" id="property_id" class="form-select" required>
              <option value="">-- Pilih Property --</option>
              <?php foreach ($properties as $prop): ?>
                <option value="<?= $prop['id'] ?>"><?= esc($prop['title']) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="mb-3">
            <label for="harga" class="form-label">Harga</label>
            <input type="number" step="0.01" name="harga" class="form-control" required>
          </div>
          <div class="mb-3">
            <label for="file_bukti" class="form-label">Upload Bukti</label>
            <input type="file" name="file_bukti" class="form-control">
          </div>
          <div class="mb-3">
            <label for="keterangan" class="form-label">Keterangan</label>
            <textarea name="keterangan" class="form-control" rows="3"></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button class="btn btn-primary w-100">Submit Pengajuan</button>
        </div>
      </form>
    </div>
  </div>
  <?php endif; ?>

  <?php if ($isSales): ?>
    <!-- Riwayat Pengajuan Sales -->
    <?php foreach ($pengajuan as $item): ?>
      <?php $status = strtolower($item['status']); ?>
      <?php 
        $prop = array_filter($properties, fn($p) => $p['id'] == $item['property_id']);
      ?>
      <div class="card mt-4">
        <div class="card-body">
          <h5 class="mb-3">Progress Pengajuan Komisi</h5>

          <div class="row d-flex justify-content-center">
            <div class="col-12">
              <ul id="progressbar" class="text-center">
                <li class="step0 <?= in_array($status, ['diajukan','diproses','disetujui','ditolak','cair']) ? 'active' : '' ?>"></li>
                <li class="step0 <?= in_array($status, ['diproses','disetujui','ditolak','cair']) ? 'active' : '' ?>"></li>
                <li class="step0 <?= in_array($status, ['disetujui','ditolak','cair']) ? ($status == 'ditolak' ? 'reject' : 'active') : '' ?>"></li>
                <li class="step0 <?= ($status === 'cair') ? 'active' : '' ?>"></li>
              </ul>
            </div>
          </div>

          <div class="row justify-content-between text-center mt-3">
            <div class="col step-text">
              <i class="fas fa-paper-plane fa-2x <?= in_array($status, ['diajukan', 'diproses', 'disetujui', 'ditolak', 'cair']) ? 'text-success' : 'text-muted' ?>"></i>
              <p class="<?= in_array($status, ['diajukan', 'diproses', 'disetujui', 'ditolak', 'cair']) ? 'text-success' : 'text-muted' ?>">Diajukan</p>
            </div>
            <div class="col step-text">
              <i class="fas fa-spinner fa-2x <?= in_array($status, ['diproses', 'disetujui', 'ditolak', 'cair']) ? 'text-success' : 'text-muted' ?>"></i>
              <p class="<?= in_array($status, ['diproses', 'disetujui', 'ditolak', 'cair']) ? 'text-success' : 'text-muted' ?>">Diproses</p>
            </div>
            <div class="col step-text">
              <?php if ($status === 'ditolak') : ?>
                <i class="fas fa-times-circle fa-2x text-danger"></i>
                <p class="text-danger">Ditolak</p>
              <?php else : ?>
                <i class="fas fa-check-circle fa-2x <?= in_array($status, ['disetujui', 'cair']) ? 'text-success' : 'text-muted' ?>"></i>
                <p class="<?= in_array($status, ['disetujui', 'cair']) ? 'text-success' : 'text-muted' ?>">Disetujui</p>
              <?php endif ?>
            </div>
            <div class="col step-text">
              <i class="fas fa-hand-holding-usd fa-2x <?= $status === 'cair' ? 'text-success' : 'text-muted' ?>"></i>
              <p class="<?= $status === 'cair' ? 'text-success' : 'text-muted' ?>">Cair</p>
            </div>
          </div>

          <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4 g-4 mt-4 text-center">
            <div class="col">
              <p><strong>Property:</strong><br>
                <?= esc($prop[array_key_first($prop)]['title'] ?? 'Property ID: '.$item['property_id']) ?>
              </p>
            </div>
            <div class="col">
              <p><strong>Harga:</strong><br>
                Rp <?= number_format($item['harga'], 0, ',', '.') ?>
              </p>
            </div>
            <div class="col">
              <p><strong>Diajukan:</strong><br>
                <?= date('d/m/Y', strtotime($item['tanggal_pengajuan'] ?? $item['created_at'])) ?>
              </p>
            </div>
            <div class="col">
              <p><strong>Bukti:</strong><br>
                <?php if (!empty($item['file_bukti'])): ?>
                  <a href="<?= base_url('uploads/user/komisi/' . $item['file_bukti']) ?>" target="_blank" class="btn btn-sm btn-outline-primary">Lihat</a>
                <?php else: ?>
                  <span class="text-muted">-</span>
                <?php endif ?>
              </p>
            </div>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  <?php endif; ?>


  <?php if ($isAdmin): ?>
  <div class="card mt-4">
    <div class="card-body">
      <h5 class="mb-3">Semua Pengajuan Komisi</h5>
      <div class="table-responsive">
        <table class="table table-hover table-centered">
          <thead class="table-light">
            <tr>
              <th>Tanggal</th>
              <th>Sales</th>
              <th>Property</th>
              <th>Status</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($pengajuan as $idx => $item): ?>
              <?php $modalId = 'detailModal_' . $idx; ?>
              <tr>
                <td><?= date('d/m/Y', strtotime($item['tanggal_pengajuan'] ?? $item['created_at'])) ?></td>
                <td><?= esc($item['user_name'] ?? 'User ID: '.$item['user_id']) ?></td>
                <td>
                  <?php 
                    $prop = array_filter($properties, fn($p) => $p['id'] == $item['property_id']);
                    echo esc($prop[array_key_first($prop)]['title'] ?? 'Property ID: '.$item['property_id']);
                  ?>
                </td>
                <td>
                  <span class="badge bg-<?= $item['status'] === 'disetujui' ? 'success' : ($item['status'] === 'ditolak' ? 'danger' : ($item['status'] === 'cair' ? 'primary' : 'warning')) ?>">
                    <?= ucfirst($item['status']) ?>
                  </span>
                </td>
                <td>
                  <button class="btn btn-sm btn-outline-info" data-bs-toggle="modal" data-bs-target="#<?= $modalId ?>">
                    Detail
                  </button>
                </td>
              </tr>

              
            <?php endforeach ?>
          </tbody>
        </table>
        <!-- Modal Detail Komisi -->
<div class="modal fade" id="<?= $modalId ?>" tabindex="-1" aria-labelledby="<?= $modalId ?>Label" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered"> <!-- modal-md untuk ukuran medium -->
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalDetailLabel<?= $item['id'] ?>">Detail Pengajuan Komisi</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
      </div>
      <div class="modal-body">

        <!-- Gambar bukti -->
        <div class="mb-3">
          <a href="<?= base_url('uploads/user/komisi/' . $item['file_bukti']) ?>" class="btn btn-sm btn-outline-primary" download>Download Bukti</a>
        </div>

        <!-- Detail -->
  
        <div class="table-responsive">
          <table class="table table-borderless table-dark table-centered">
            <tbody>
              <tr>
                <th scope="col">Sales</th>
                <td><?= esc($item['user_name']) ?></td>
              </tr>
              <tr>
                <th scope="col">Property</th>
                <td><?= esc($prop[array_key_first($prop)]['title'] ?? 'Property ID: '.$item['property_id']) ?></td>
              </tr>
              
              <tr>
                <th scope="col">Harga</th>
                <td>Rp <?= number_format($item['harga'], 0, ',', '.') ?></td>
              </tr>
              <tr>
                <th scope="col">Keterangan</th>
                <td><?= $item['keterangan'] ? esc($item['keterangan']) : '<span class="text-muted">-</span>' ?></td>
              </tr>
            </tbody>
          </table>
        </div>

        <!-- Form Update Status dan Komisi % -->
        <form action="<?= base_url('dashboard/SalesActivity/komisi/update') ?>" method="post">
          <input type="hidden" name="id" value="<?= $item['id'] ?>">

          <div class="row">
            <!-- Status -->
            <div class="col-md-6 mb-3">
              <label for="status<?= $item['id'] ?>" class="form-label">Update Status</label>
              <select name="status" id="status<?= $item['id'] ?>" class="form-select" required>
                <option value="diajukan" <?= $item['status'] == 'diajukan' ? 'selected' : '' ?>>Diajukan</option>
                <option value="diproses" <?= $item['status'] == 'diproses' ? 'selected' : '' ?>>Diproses</option>
                <option value="disetujui" <?= $item['status'] == 'disetujui' ? 'selected' : '' ?>>Disetujui</option>
                <option value="ditolak" <?= $item['status'] == 'ditolak' ? 'selected' : '' ?>>Ditolak</option>
                <option value="cair" <?= $item['status'] == 'cair' ? 'selected' : '' ?>>Cair</option>
              </select>
            </div>

            <!-- Komisi -->
            <div class="col-md-6 mb-3">
              <label for="komisi<?= $item['id'] ?>" class="form-label">Komisi (%)</label>
              <input type="number" step="0.01" name="komisi" id="komisi<?= $item['id'] ?>" class="form-control" value="<?= esc($item['komisi'] ?? '') ?>" placeholder="Misal: 2.5">
            </div>
          </div>
          <div class="modal-footer">
              <button type="submit" class="btn btn-success">Simpan</button>
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
          </div>
        </form>


      </div>
    </div>
  </div>
</div>
<style>
  .modal-dialog {
  max-width: 600px;
}
@media (max-width: 768px) {
  .modal-dialog {
    max-width: 95%;
  }
}

</style>

      </div>
    </div>
  </div>
<?php endif; ?>

</div>

<style>
#progressbar {
  padding: 0;
  margin-bottom: 20px;
  counter-reset: step;
  display: flex;
  justify-content: space-between;
  list-style: none;
}
#progressbar li {
  width: 25%;
  position: relative;
  text-align: center;
  font-size: 12px;
  color: gray;
}
#progressbar li:before {
  content: counter(step);
  counter-increment: step;
  width: 30px;
  height: 30px;
  line-height: 30px;
  border: 2px solid lightgray;
  display: block;
  margin: 0 auto 10px auto;
  border-radius: 50%;
  background-color: lightgray;
  color: white;
  z-index: 2;
  position: relative;
}
#progressbar li:after {
  content: '';
  position: absolute;
  width: 100%;
  height: 2px;
  background-color: lightgray;
  top: 15px;
  left: -50%;
  z-index: 1;
}
#progressbar li:first-child:after {
  content: none;
}
#progressbar li.active:before {
  background-color: #28a745;
  border-color: #28a745;
}
#progressbar li.active:after {
  background-color: #28a745;
}
#progressbar li.reject:before {
  background-color: #dc3545;
  border-color: #dc3545;
}
#progressbar li.reject:after {
  background-color: #dc3545;
}
.step-text p {
  margin-top: 4px;
  font-weight: 500;
}
</style>

<?= $this->endSection() ?>
