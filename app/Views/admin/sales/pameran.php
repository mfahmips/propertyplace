<?= $this->extend('admin/layout/default') ?>
<?= $this->section('content') ?>


<div class="container-fluid">
  <div class="page-title-box">
    <h4 class="mb-0"><?= isset($title) ? esc($title) : 'Daftar Properti' ?></h4>
    <ol class="breadcrumb mb-0">
      <?php foreach ($breadcrumb as $item): ?>
        <li class="breadcrumb-item<?= isset($item['url']) ? '' : ' active' ?>">
          <?php if (isset($item['url'])): ?>
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
<div class="d-flex justify-content-between align-items-center mb-3">
    <button class="btn btn-primary" onclick="resetForm(); new bootstrap.Modal(document.getElementById('modalPameran')).show();">
        <i class="fa fa-plus me-1"></i> Tambah Pameran
    </button>
</div>
<div class="table-responsive">
        <table class="table table-hover table-centere">
          <thead class="table-light">
            <tr>
                        <th scope="col">Lokasi</th>
                        <th scope="col">Status</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pameran as $p) : ?>
                        <tr>
                            <td><?= esc($p['lokasi']) ?></td>
                            <td>
                                <span class="badge bg-<?= $p['status'] === 'aktif' ? 'success' : 'secondary' ?>">
                                    <?= esc(ucfirst($p['status'])) ?>
                                </span>
                            </td>
                            <td>
                                <div class="d-flex flex-wrap flex-sm-nowrap gap-2">
                                <button class="btn btn-sm btn-warning" onclick='editPameran(<?= json_encode($p) ?>)'>Edit</button>
                                <a href="<?= base_url('dashboard/SalesActivity/pameran/delete/' . $p['id']) ?>" class="btn btn-sm btn-danger"
                                   onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Tambah/Edit Pameran -->
<div class="modal fade" id="modalPameran" tabindex="-1" aria-labelledby="modalPameranLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="<?= base_url('dashboard/SalesActivity/pameran/save') ?>" method="post" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalPameranLabel">Form Pameran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="id" id="pameran_id">

                <div class="mb-3">
                    <label for="lokasi" class="form-label">Lokasi</label>
                    <input type="text" name="lokasi" id="lokasi" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" id="status" class="form-select">
                        <option value="aktif">Aktif</option>
                        <option value="selesai">Selesai</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- Script Modal -->
<script>
function resetForm() {
    document.getElementById('pameran_id').value = '';
    document.getElementById('lokasi').value = '';
    document.getElementById('status').value = 'aktif';
}

function editPameran(data) {
    document.getElementById('pameran_id').value = data.id;
    document.getElementById('lokasi').value = data.lokasi;
    document.getElementById('status').value = data.status;
    new bootstrap.Modal(document.getElementById('modalPameran')).show();
}
</script>

<?= $this->endSection() ?>
