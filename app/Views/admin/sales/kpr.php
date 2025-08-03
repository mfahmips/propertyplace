<?= $this->extend('admin/layout/default') ?>
<?= $this->section('content') ?>

<div class="container-fluid">
  <div class="page-title-box">
    <h4 class="mb-0"><?= esc($title) ?></h4>
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
      <form id="kprForm" method="post" action="javascript:void(0);">
        <div class="form-group">
          <label>Harga Properti (Rp)</label>
          <input type="number" name="price" class="form-control" required>
        </div>
        <div class="form-group mt-2">
          <label>Uang Muka (DP) (Rp)</label>
          <input type="number" name="dp" class="form-control" required>
        </div>
        <div class="form-group mt-2">
          <label>Suku Bunga (%)</label>
          <input type="number" step="0.01" name="rate" class="form-control" required>
        </div>
        <div class="form-group mt-2">
          <label>Tenor (Tahun)</label>
          <input type="number" name="tenor" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Hitung Cicilan</button>
      </form>

      <div class="mt-4" id="hasilCicilan" style="display:none;">
          <h5 class="mb-3">Hasil Perhitungan KPR</h5>
          <table class="table table-bordered">
            <tbody>
              <tr>
                <th>Harga Properti</th>
                <td id="tabelHarga"></td>
              </tr>
              <tr>
                <th>Uang Muka (DP)</th>
                <td id="tabelDP"></td>
              </tr>
              <tr>
                <th>Suku Bunga</th>
                <td id="tabelBunga"></td>
              </tr>
              <tr>
                <th>Tenor</th>
                <td id="tabelTenor"></td>
              </tr>
              <tr>
                <th>Cicilan per Bulan</th>
                <td id="tabelCicilan"></td>
              </tr>
            </tbody>
          </table>
        </div>

    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
  const form = document.getElementById('kprForm');

  form.addEventListener('submit', function(e) {
    e.preventDefault();

    const formData = new FormData(form);

    fetch("<?= site_url('dashboard/KPRCalculator/kpr-calculate') ?>", {
      method: "POST",
      body: formData
    })
    .then(response => response.json())
    .then(data => {
      if (data.cicilan) {
        document.getElementById('tabelHarga').textContent = 'Rp ' + Number(formData.get('price')).toLocaleString('id-ID');
        document.getElementById('tabelDP').textContent = 'Rp ' + Number(formData.get('dp')).toLocaleString('id-ID');
        document.getElementById('tabelBunga').textContent = formData.get('rate') + ' %';
        document.getElementById('tabelTenor').textContent = formData.get('tenor') + ' Tahun';
        document.getElementById('tabelCicilan').textContent = 'Rp ' + data.cicilan;

        document.getElementById('hasilCicilan').style.display = 'block';
      } else if (data.error) {
        alert("Kesalahan: " + data.error);
      }
    })
    .catch(error => {
      console.error("Terjadi kesalahan:", error);
      alert("Terjadi kesalahan saat menghitung cicilan.");
    });
  });
});
</script>


<?= $this->endSection() ?>
