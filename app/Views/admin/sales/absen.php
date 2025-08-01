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

  <div class="card">
    <div class="card-body">
    <div class="table-responsive">
        <table class="table table-striped table-borderless">
            <thead class="table-light">
                <tr>
                    <th>Nama Sales</th>
                    <th>Tanggal</th>
                    <th>Masuk</th>
                    <th>Pulang</th>
                    <th>Lokasi Pameran</th>
                    <th>Database</th>
                    <th>Status</th>
                    <th>Foto Masuk</th>
                    <th>Foto Pulang</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($absensi)) : ?>
                    <?php $no = 1; foreach ($absensi as $row) : ?>
                        <tr>
                            <td><?= esc($row['name']) ?></td>
                            <td><?= esc($row['tanggal']) ?></td>
                            <td><?= esc($row['waktu_masuk']) ?></td>
                            <td><?= esc($row['waktu_keluar']) ?: '-' ?></td>
                            <td><?= esc($row['lokasi_pameran']) ?></td>
                            <td><?= esc($row['database_pameran']) ?></td>
                            <td>
                                <span class="badge bg-<?= $row['status'] === 'pulang' ? 'success' : 'warning' ?>">
                                    <?= esc(ucfirst($row['status'])) ?>
                                </span>
                            </td>
                            <td>
                                <?php if (!empty($row['foto_masuk'])) : ?>
                                    <img src="<?= base_url('uploads/absensi/' . $row['foto_masuk']) ?>" alt="Foto Masuk" width="50" height="50" style="object-fit:cover;" class="rounded">
                                <?php else : ?>
                                    <small class="text-muted">-</small>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if (!empty($row['foto_pulang'])) : ?>
                                    <img src="<?= base_url('uploads/absensi/' . $row['foto_pulang']) ?>" alt="Foto Pulang" width="50" height="50" style="object-fit:cover;" class="rounded">
                                <?php else : ?>
                                    <small class="text-muted">-</small>
                                <?php endif; ?>
                            </td>
                        </tr>
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

<?= $this->endSection() ?>
