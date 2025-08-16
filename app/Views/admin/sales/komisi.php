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
      <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAjukanKomisi">Ajukan Komisi</button>
    </div>
  </div>

  <!-- Modal Ajukan Komisi -->
<div class="modal fade" id="modalAjukanKomisi" tabindex="-1" aria-labelledby="modalAjukanKomisiLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-md">
    <div class="modal-content">
      <form action="<?= base_url('dashboard/SalesActivity/komisi/save') ?>" method="post">
        <div class="modal-header border-0 pb-0">
          <h5 class="modal-title" id="modalAjukanKomisiLabel">Form Pengajuan Komisi</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
        </div><hr>

        <div class="modal-body">
          <?php if (!empty($bookings)): ?>
            <div class="mb-2">
              <label for="booking_id" class="form-label">Pilih Booking Unit</label>
              <select name="booking_id" id="booking_id" class="form-select" required>
                <option value="">-- Pilih Booking --</option>
                <?php foreach ($bookings as $b): ?>
                  <option value="<?= $b['id'] ?>">
                    <?= esc($b['buyer_name'] ?? 'Tanpa Nama') ?>
                    (<?= esc($b['property_title'] ?? '-') ?> / <?= esc($b['type_name'] ?? '-') ?>)
                  </option>

                <?php endforeach; ?>
              </select>
            </div>
          <?php else: ?>
            <div class="alert alert-warning mb-0">
              Anda belum bisa mengajukan <strong>Komisi</strong>
            </div>
          <?php endif; ?>
        </div>

        <div class="modal-footer border-0 pt-0">
          <button type="submit" class="btn btn-primary w-100"
                  <?= empty($bookings) ? 'disabled' : '' ?>>
            Ajukan
          </button>
        </div>
      </form>
    </div>
  </div>
</div>


  <?php endif; ?>

  <?php if ($isSales): ?>
    <!-- Riwayat Pengajuan Komisi Sales -->
    <?php foreach ($pengajuan as $item): ?>
      <?php $status = strtolower($item['status']); ?>

      <?php
        function isAktif($current, $target) {
          $statusList = ['diajukan', 'diproses', 'disetujui', 'selesai'];
          return array_search($current, $statusList) >= array_search($target, $statusList);
        }
        ?>
        <?php if ($status !== 'ditolak'): ?>
        <div class="card mt-4">
          <div class="card-body">
            <h5 class="mb-3">Progress Pengajuan Komisi</h5>

            <!-- Garis & Bulatan -->
            <ul id="progressbar" class="d-flex justify-content-between list-unstyled px-0">
              <?php 
                $steps = ['diajukan', 'diproses', 'disetujui', 'selesai'];
                foreach ($steps as $i => $step): 
                  $stepClass = '';
                  if ($status === $step) {
                      $stepClass = 'active';
                  } elseif (isAktif($status, $step)) {
                      $stepClass = 'passed';
                  }
              ?>
                <li class="step0 <?= $stepClass ?>">
                  <div class="circle"><?= $i + 1 ?></div>
                </li>
              <?php endforeach; ?>
            </ul>



            <!-- Label & Spinner -->
            <div class="row row-cols-2 row-cols-md-4 text-center mt-2 g-4">
              <div class="col">
                <?php if (isAktif($status, 'diajukan')): ?>
                  <i class="fas fa-paper-plane fa-2x text-primary"></i>
                  <p class="text-primary">Diajukan</p>
                <?php else: ?>
                  <div class="spinner-border text-muted" role="status"><span class="visually-hidden">Loading...</span></div>
                  <p class="text-muted">Diajukan</p>
                <?php endif ?>
              </div>

              <div class="col">
                <?php if (isAktif($status, 'diproses')): ?>
                  <i class="fas fa-cogs fa-2x text-primary"></i>
                  <p class="text-primary">Diproses</p>
                <?php else: ?>
                  <div class="spinner-border text-muted" role="status"><span class="visually-hidden">Loading...</span></div>
                  <p class="text-muted">Diproses</p>
                <?php endif ?>
              </div>

              <div class="col">
                <?php if (isAktif($status, 'disetujui')): ?>
                  <i class="fas fa-check-circle fa-2x text-primary"></i>
                  <p class="text-primary">Disetujui</p>
                <?php else: ?>
                  <div class="spinner-border text-muted" role="status"><span class="visually-hidden">Loading...</span></div>
                  <p class="text-muted">Disetujui</p>
                <?php endif ?>
              </div>

              <div class="col">
                <?php if (isAktif($status, 'selesai')): ?>
                  <i class="fas fa-flag-checkered fa-2x text-primary"></i>
                  <p class="text-primary">Selesai</p>
                <?php else: ?>
                  <div class="spinner-border text-muted" role="status"><span class="visually-hidden">Loading...</span></div>
                  <p class="text-muted">Selesai</p>
                <?php endif ?>
              </div>
            </div>

        <?php endif ?>

          <div class="mt-4">
            <p>Catatan Admin : <strong><?= $item['catatan'] ?: '<i class="text-muted">-</i>' ?></strong></p>
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
                <th>Status</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($pengajuan as $item): ?>
              <tr>
                <td><?= date('d/m/Y', strtotime($item['tanggal_ajuan'])) ?></td>
                <td><?= esc($item['user_name']) ?></td>
                <td>
                  <span class="badge bg-<?= $item['status'] === 'disetujui' ? 'success' : ($item['status'] === 'ditolak' ? 'danger' : 'warning') ?>">
                    <?= ucfirst($item['status']) ?>
                  </span>
                </td>
                
                <td>
                  <button class="btn btn-sm btn-primary"
                        data-bs-toggle="modal"
                        data-bs-target="#modalKomisi<?= $item['id'] ?>">
                  Data Booking
                </button>
                  <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#modalUpdateKomisi<?= $item['id'] ?>">Edit</button>


                </td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>

          <!-- Modal Detail Komisi -->
                <div class="modal fade" id="modalKomisi<?= $item['id'] ?>" tabindex="-1" aria-labelledby="modalKomisiLabel<?= $item['id'] ?>" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">

                      <div class="modal-header">
                        <h5 class="modal-title">Detail Pengajuan Komisi</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                      </div>

                      <div class="modal-body">
                        <!-- Informasi Booking -->
                        <div class="mb-3">
                          <h6 class="mb-2">Data Booking</h6>
                          <div class="row g-3">
                            <div class="col-md-6">
                              <div class="small text-muted">Kode Booking</div>
                              <div class="fw-semibold">#<?= esc($item['booking_code']) ?></div>
                            </div>
                            <div class="col-md-6">
                              <div class="small text-muted">Nama Pembeli</div>
                              <div class="fw-semibold"><?= esc($item['buyer_name']) ?></div>
                            </div>
                            <div class="col-md-6">
                              <div class="small text-muted">Property / Tipe</div>
                              <div class="fw-semibold"><?= esc($item['property_title'] ?? '-') ?> / <?= esc($item['type_name'] ?? '-') ?></div>
                            </div>
                            <div class="col-md-6">
                              <div class="small text-muted">No. Unit</div>
                              <div class="fw-semibold"><?= esc($item['unit_number'] ?? '-') ?></div>
                            </div>
                            <div class="col-md-6">
                              <div class="small text-muted">Harga</div>
                              <div class="fw-semibold">Rp <?= number_format((float)$item['price'], 0, ',', '.') ?></div>
                            </div>
                            <div class="col-md-6">
                              <div class="small text-muted">Tanggal Ajuan</div>
                              <div class="fw-semibold"><?= $item['tanggal_ajuan'] ? date('d/m/Y H:i', strtotime($item['tanggal_ajuan'])) : '-' ?></div>
                            </div>
                          </div>
                        </div>
                        <hr>

                        <!-- Informasi Komisi -->
                        <div class="mb-3">
                          <h6 class="mb-2">Data Komisi</h6>
                          <div class="row g-3">
                            <div class="col-md-4">
                              <div class="small text-muted">Persentase</div>
                              <div class="fw-semibold"><?= $item['komisi_persen'] ?>%</div>
                            </div>
                            <div class="col-md-4">
                              <div class="small text-muted">Nominal Komisi</div>
                              <div class="fw-semibold">Rp <?= number_format((float)$item['komisi_nominal'], 0, ',', '.') ?></div>
                            </div>
                            <div class="col-md-4">
                              <div class="small text-muted">Status</div>
                              <div class="fw-semibold text-<?= $item['status'] === 'disetujui' ? 'success' : ($item['status'] === 'ditolak' ? 'danger' : 'warning') ?>">
                                <?= ucfirst($item['status']) ?>
                              </div>
                            </div>
                            <div class="col-12">
                              <div class="small text-muted">Catatan</div>
                              <div class="fst-italic"><?= $item['catatan'] ?: '<span class="text-muted">-</span>' ?></div>
                            </div>
                          </div>
                        </div>

                        <!-- Tombol Cetak -->
                        <div class="modal-footer">
                          <a href="<?= base_url('dashboard/SalesActivity/komisi/preview/' . $item['id']) ?>" class="btn btn-outline-primary" target="_blank">
                            <i class="fas fa-print me-1"></i> Download Pengajuan (PDF)
                          </a>
                        </div>
                      </div>

                    </div>
                  </div>
                </div>


          <!-- Modal Update Komisi -->
          <div class="modal fade" id="modalUpdateKomisi<?= $item['id'] ?>" tabindex="-1" aria-labelledby="modalUpdateKomisiLabel<?= $item['id'] ?>" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
              <div class="modal-content">
                <form action="<?= base_url('dashboard/SalesActivity/komisi/update') ?>" method="post">
                  <div class="modal-header">
                    <h5 class="modal-title" id="modalUpdateKomisiLabel<?= $item['id'] ?>">Update Komisi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                  </div>
                  <div class="modal-body">
                    <input type="hidden" name="id" value="<?= $item['id'] ?>">

                    <div class="mb-2">
                      <label for="status<?= $item['id'] ?>" class="form-label">Status</label>
                      <select name="status" id="status<?= $item['id'] ?>" class="form-select" required>
                        <option value="diajukan" <?= $item['status'] === 'diajukan' ? 'selected' : '' ?>>Diajukan</option>
                        <option value="diproses" <?= $item['status'] === 'diproses' ? 'selected' : '' ?>>Diproses</option>
                        <option value="disetujui" <?= $item['status'] === 'disetujui' ? 'selected' : '' ?>>Disetujui</option>
                        <option value="ditolak" <?= $item['status'] === 'ditolak' ? 'selected' : '' ?>>Ditolak</option>
                        <option value="selesai" <?= $item['status'] === 'selesai' ? 'selected' : '' ?>>Selesai</option>
                      </select>
                    </div>

                    <div class="mb-2">
                      <label for="komisi_persen<?= $item['id'] ?>" class="form-label">Persentase Komisi (%)</label>
                      <input type="number" step="0.1" class="form-control" id="komisi_persen<?= $item['id'] ?>" name="komisi_persen" value="<?= $item['komisi_persen'] ?>">
                    </div>

                    <div class="mb-2">
                      <label for="komisi_nominal<?= $item['id'] ?>" class="form-label">Nominal Komisi</label>
                      <input type="number" class="form-control" id="komisi_nominal<?= $item['id'] ?>" name="komisi_nominal" value="<?= $item['komisi_nominal'] ?>">
                    </div>

                    <div class="mb-2">
                      <label for="catatan<?= $item['id'] ?>" class="form-label">Catatan</label>
                      <textarea class="form-control" id="catatan<?= $item['id'] ?>" name="catatan" rows="3"><?= $item['catatan'] ?></textarea>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="submit" class="btn btn-success w-100">Simpan</button>
                  </div>
                </form>
              </div>
            </div>
          </div>


        </div>
      </div>
    </div>
  <?php endif; ?>
</div>

<style>
#progressbar {
  counter-reset: step;
  width: 100%;
  position: relative;
}

#progressbar li {
  position: relative;
  text-align: center;
  flex: 1;
}

#progressbar li::after {
  content: '';
  position: absolute;
  width: 100%;
  height: 2px;
  background-color: lightgray;
  top: 15px;
  left: -50%;
  z-index: 1;
}

#progressbar li:first-child::after {
  content: none;
}

#progressbar .circle {
  width: 30px;
  height: 30px;
  margin: 0 auto;
  background-color: lightgray;
  color: #fff;
  border-radius: 50%;
  line-height: 30px;
  font-weight: bold;
  z-index: 2;
  position: relative;
}

/* Step sudah dilewati */
#progressbar li.passed .circle {
  background-color: #28a745;
  border: 2px solid #28a745;
}

/* Step sedang aktif */
#progressbar li.active .circle {
  background-color: #6f42c1;
  border: 2px solid #6f42c1;
}

/* Line warna hijau untuk step yang sudah dilewati */
#progressbar li.passed::after {
  background-color: #28a745;
}


.step-number {
  position: absolute;
  top: -25px;
  left: 50%;
  transform: translateX(-50%);
  color: #fff;
  font-weight: bold;
  background: #6c757d;
  border-radius: 10px;
  padding: 2px 8px;
  font-size: 12px;
}



</style>

<?= $this->endSection() ?>
