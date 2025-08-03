<?= $this->extend('admin/layout/default') ?>
<?= $this->section('content') ?>

<div class="container-fluid">
  <div class="page-title-box">
    <h4 class="mb-0"><?= esc($title) ?></h4>
    <ol class="breadcrumb mb-0">
      <?php foreach($breadcrumb as $item): ?>
        <li class="breadcrumb-item<?= isset($item['url']) ? '' : ' active' ?>">
          <?php if(isset($item['url'])): ?>
            <a href="<?= esc($item['url']) ?>"><?= esc($item['label']) ?></a>
          <?php else: ?>
            <?= esc($item['label']) ?>
          <?php endif ?>
        </li>
      <?php endforeach ?>
    </ol>
  </div>

<?php if (session('role') === 'sales') : ?>

<div class="card">
  <div class="card-body">

    <div class="d-flex flex-column align-items-center gap-3 mb-3">
      <button class="btn btn-success w-50" data-bs-toggle="modal" data-bs-target="#modalAbsenMasuk">
        Absen Masuk
      </button>
      <button class="btn btn-warning w-50" data-bs-toggle="modal" data-bs-target="#modalAbsenPulang">
        Absen Pulang
      </button>
    </div>

    <!-- Modal Absen Masuk -->
    <div class="modal fade" id="modalAbsenMasuk" tabindex="-1" aria-labelledby="modalAbsenMasukLabel" aria-hidden="true">
      <div class="modal-dialog">
        <form action="<?= base_url('dashboard/SalesActivity/absensi/masuk') ?>" method="post" class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modalAbsenMasukLabel">Form Absen Masuk</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
          </div>
          <div class="modal-body">

            <div class="mb-3">
              <label for="status_kehadiran" class="form-label">Status Kehadiran</label>
              <select name="status" id="status_kehadiran" class="form-select" required>
                <option value="masuk">Hadir</option>
                <option value="setengah_hari">Setengah Hari</option>
                <option value="sakit">Sakit</option>
                <option value="izin">Izin</option>
                <option value="tidak_masuk">Tidak Masuk</option>
              </select>
            </div>

            <div class="mb-3">
              <label for="lokasi_pameran_masuk" class="form-label">Lokasi Pameran</label>
              <select name="lokasi_pameran" id="lokasi_pameran_masuk" class="form-select" required>
                <option value="">-- Pilih Lokasi --</option>
                <?php foreach ($lokasiPameran as $lok) : ?>
                  <option value="<?= esc($lok['lokasi']) ?>"><?= esc($lok['lokasi']) ?></option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="mb-3" id="kamera_masuk_group">
              <label class="form-label">Kamera Masuk</label>
              <video id="videoMasuk" autoplay playsinline class="w-100 border rounded"></video>
              <input type="hidden" name="foto_base64_masuk" id="foto_base64_masuk">
              <button type="button" class="btn btn-outline-primary mt-2 w-100" onclick="ambilFotoMasuk()">Ambil Foto</button>
              <img id="preview_masuk" class="img-fluid mt-2 d-none border rounded" alt="Preview Masuk">
            </div>

          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-success">Submit Absen Masuk</button>
          </div>
        </form>
      </div>
    </div>

    <!-- Modal Absen Pulang -->
    <div class="modal fade" id="modalAbsenPulang" tabindex="-1" aria-labelledby="modalAbsenPulangLabel" aria-hidden="true">
      <div class="modal-dialog">
        <form action="<?= base_url('dashboard/SalesActivity/absensi/pulang') ?>" method="post" class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modalAbsenPulangLabel">Form Absen Pulang</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
          </div>
          <div class="modal-body">

            <div class="mb-3">
              <label class="form-label">Kamera Pulang</label>
              <video id="videoPulang" autoplay playsinline class="w-100 border rounded"></video>
              <input type="hidden" name="foto_base64_pulang" id="foto_base64_pulang">
              <button type="button" class="btn btn-outline-warning mt-2 w-100" onclick="ambilFotoPulang()">Ambil Foto</button>
              <img id="preview_pulang" class="img-fluid mt-2 d-none border rounded" alt="Preview Pulang">
            </div>

            <div class="mb-3">
              <label for="database_pameran" class="form-label">Database</label>
              <input type="text" name="database_pameran" id="database_pameran" class="form-control" required>
            </div>

          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-warning">Submit Absen Pulang</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
let streamMasuk, streamPulang;

function ambilFotoMasuk() {
  const video = document.getElementById('videoMasuk');
  const canvas = document.createElement('canvas');
  canvas.width = video.videoWidth;
  canvas.height = video.videoHeight;
  canvas.getContext('2d').drawImage(video, 0, 0);
  const dataUrl = canvas.toDataURL('image/jpeg');
  document.getElementById('foto_base64_masuk').value = dataUrl;
  document.getElementById('preview_masuk').src = dataUrl;
  document.getElementById('preview_masuk').classList.remove('d-none');
}

function ambilFotoPulang() {
  const video = document.getElementById('videoPulang');
  const canvas = document.createElement('canvas');
  canvas.width = video.videoWidth;
  canvas.height = video.videoHeight;
  canvas.getContext('2d').drawImage(video, 0, 0);
  const dataUrl = canvas.toDataURL('image/jpeg');
  document.getElementById('foto_base64_pulang').value = dataUrl;
  document.getElementById('preview_pulang').src = dataUrl;
  document.getElementById('preview_pulang').classList.remove('d-none');
}

document.getElementById('modalAbsenMasuk').addEventListener('shown.bs.modal', async function () {
  if (['masuk', 'setengah_hari'].includes(document.getElementById('status_kehadiran').value)) {
    try {
      streamMasuk = await navigator.mediaDevices.getUserMedia({ video: { facingMode: 'environment' }, audio: false });
      document.getElementById('videoMasuk').srcObject = streamMasuk;
    } catch (err) {
      alert('Tidak dapat mengakses kamera.');
    }
  }
});

document.getElementById('modalAbsenMasuk').addEventListener('hidden.bs.modal', function () {
  if (streamMasuk) {
    streamMasuk.getTracks().forEach(track => track.stop());
  }
});

document.getElementById('modalAbsenPulang').addEventListener('shown.bs.modal', async function () {
  try {
    streamPulang = await navigator.mediaDevices.getUserMedia({ video: { facingMode: 'environment' }, audio: false });
    document.getElementById('videoPulang').srcObject = streamPulang;
  } catch (err) {
    alert('Tidak dapat mengakses kamera.');
  }
});

document.getElementById('modalAbsenPulang').addEventListener('hidden.bs.modal', function () {
  if (streamPulang) {
    streamPulang.getTracks().forEach(track => track.stop());
  }
});

// Sembunyikan kamera jika status bukan masuk/setengah hari
document.getElementById('status_kehadiran').addEventListener('change', function () {
  const kamera = document.getElementById('kamera_masuk_group');
  if (['masuk', 'setengah_hari'].includes(this.value)) {
    kamera.classList.remove('d-none');
  } else {
    kamera.classList.add('d-none');
    document.getElementById('foto_base64_masuk').value = '';
    document.getElementById('preview_masuk').classList.add('d-none');
    if (streamMasuk) streamMasuk.getTracks().forEach(track => track.stop());
  }
});
</script>




<!-- Tabel Riwayat Absensi -->
<?php if (!empty($riwayatAbsen)) : ?>
    <div class="card mt-4">
        <div class="card-body">
            <h5 class="mb-3">Riwayat Absensi</h5>
            <div class="table-responsive">
                <table class="table table-hover table-centere">
                    <thead class="table-light">
                        <tr>
                            <th>Tanggal</th>
                            <th>Lokasi</th>
                            
                            <th>Waktu Masuk</th>
                            <th>Foto Masuk</th>
                            <th>Waktu Pulang</th>
                            <th>Foto Pulang</th>
                            <th>Database</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($riwayatAbsen as $absen): ?>
                            <tr>
                                <td><?= date('d/m/Y', strtotime($absen['tanggal'])) ?></td>
                                <td><?= esc($absen['lokasi_pameran']) ?: '-' ?></td>
                                <td>
                                    <?= $absen['waktu_masuk'] ? date('H:i', strtotime($absen['waktu_masuk'])) : '-' ?>
                                </td>

                                <td>
                                    <?php if (!empty($absen['foto_masuk'])) : ?>
                                        <a href="<?= base_url('uploads/user/absensi/checkin/' . $absen['foto_masuk']) ?>" target="_blank">Lihat</a>
                                    <?php else : ?>
                                        <span class="text-muted">-</span>
                                    <?php endif ?>
                                </td>
                                <td>
                                    <?= $absen['waktu_keluar'] ? date('H:i', strtotime($absen['waktu_keluar'])) : '-' ?>
                                </td>

                                <td>
                                    <?php if (!empty($absen['foto_pulang'])) : ?>
                                        <a href="<?= base_url('uploads/user/absensi/checkout/' . $absen['foto_pulang']) ?>" target="_blank">Lihat</a>
                                    <?php else : ?>
                                        <span class="text-muted">-</span>
                                    <?php endif ?>
                                </td>
                                <td><?= esc($absen['database_pameran']) ?: '-' ?></td>
                                <td>
                                    <?php
                                        $status = $absen['status'] ?? 'tidak_diketahui';
                                        $statusLabel = ucwords(str_replace('_', ' ', $status));
                                        $badgeClass = match($status) {
                                            'masuk' => 'success',
                                            'setengah_hari' => 'warning',
                                            'sakit' => 'danger',
                                            'izin' => 'info',
                                            'tidak_masuk' => 'dark',
                                            default => 'secondary',
                                        };
                                    ?>
                                    <span class="badge bg-<?= $badgeClass ?>"><?= esc($statusLabel) ?></span>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php endif; ?>



<?php if (session('role') === 'admin') : ?>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-borderless">
                    <thead class="table-light">
                        <tr>
                            <th>Tanggal</th>
                            <th>Nama Sales</th>
                            <th>Lokasi Pameran</th>
                            <th>Masuk</th>
                            <th>Pulang</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($absensi)) : ?>
                            <?php foreach ($absensi as $row) : ?>
                                <tr>
                                    <td><?= esc($row['tanggal']) ?></td>
                                    <td><?= esc($row['name']) ?></td>
                                    <td><?= esc($row['lokasi_pameran']) ?></td>
                                   <td>
                                        <a href="#" data-bs-toggle="modal" data-bs-target="#modalMasuk<?= $row['id'] ?>">
                                            <?= esc($row['waktu_masuk']) ?>
                                        </a>
                                    </td>
                                    <td>
                                        <?php if (!empty($row['waktu_keluar'])): ?>
                                            <a href="#" data-bs-toggle="modal" data-bs-target="#modalPulang<?= $row['id'] ?>">
                                                <?= esc($row['waktu_keluar']) ?>
                                            </a>
                                        <?php else: ?>
                                            <span class="text-muted">-</span>
                                        <?php endif; ?>
                                    </td>

                                    <td>
                                        <?php if ($row['status'] === 'pulang'): ?>
                                            <span class="badge bg-success">Done</span>
                                        <?php elseif ($row['status'] === 'masuk'): ?>
                                            <span class="badge bg-warning text-dark">Masuk</span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">Belum Absen</span>
                                        <?php endif; ?>
                                    </td>


                                </tr>

                                <!-- Modal Detail Waktu Masuk -->
                                <div class="modal fade" id="modalMasuk<?= $row['id'] ?>" tabindex="-1" aria-labelledby="modalMasukLabel<?= $row['id'] ?>" aria-hidden="true">
                                  <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                      
                                      <div class="modal-header">
                                        <h5 class="modal-title" id="modalMasukLabel<?= $row['id'] ?>">Detail Masuk Sales</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                                      </div>
                                      
                                      <div class="modal-body text-center">
                                        <p><strong>Waktu Masuk:</strong> <?= esc($row['waktu_masuk']) ?></p>
                                        
                                        <?php if (!empty($row['foto_masuk'])): ?>
                                          <img src="<?= base_url('uploads/user/absensi/' . $row['foto_masuk']) ?>" 
                                               alt="Foto Masuk" 
                                               class="img-thumbnail rounded mb-2" 
                                               style="max-width: 200px; height: auto;">
                                        <?php else: ?>
                                          <p class="text-muted">Tidak ada foto masuk.</p>
                                        <?php endif; ?>
                                        
                                      </div>
                                      
                                      <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                      </div>

                                    </div>
                                  </div>
                                </div>

                                <!-- Modal Detail Pulang Sales -->
                                <div class="modal fade" id="modalPulang<?= $row['id'] ?>" tabindex="-1" aria-labelledby="modalPulangLabel<?= $row['id'] ?>" aria-hidden="true">
                                  <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">

                                      <div class="modal-header">
                                        <h5 class="modal-title" id="modalPulangLabel<?= $row['id'] ?>">Detail Pulang Sales</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                                      </div>

                                      <div class="modal-body text-center">
                                        <p><strong>Waktu Pulang:</strong> <?= esc($row['waktu_keluar']) ?></p>
                                        <p><strong>Database Pameran:</strong> <?= esc($row['database_pameran']) ?: '-' ?></p>

                                        <?php if (!empty($row['foto_pulang'])): ?>
                                          <img src="<?= base_url('uploads/user/absensi/' . $row['foto_pulang']) ?>" 
                                               alt="Foto Pulang" 
                                               class="img-thumbnail rounded mb-2" 
                                               style="max-width: 200px; height: auto;">
                                        <?php else: ?>
                                          <p class="text-muted">Tidak ada foto pulang.</p>
                                        <?php endif; ?>
                                      </div>

                                      <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                      </div>

                                    </div>
                                  </div>
                                </div>

                                




                        <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="10" class="text-center text-muted">Belum ada data absensi.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>



<?php endif; ?>



<?= $this->endSection() ?>
