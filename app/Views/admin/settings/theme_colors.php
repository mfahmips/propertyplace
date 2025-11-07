<?= $this->extend('admin/layout/default') ?>
<?= $this->section('content') ?>

<div class="container py-4">
  <h4 class="mb-4"><i class="bi bi-palette me-2"></i> Pengaturan Tema Warna</h4>

  <?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
  <?php endif; ?>

  <form action="<?= base_url('dashboard/settings/theme-colors/save') ?>" method="post" class="card p-4 shadow-sm">
    <?= csrf_field() ?>

    <div class="row g-4">
      <div class="col-md-4">
        <label class="form-label fw-semibold">Warna Utama</label>
        <input type="color" name="theme_primary_color"
               value="<?= esc($settings['theme_primary_color']) ?>"
               class="form-control form-control-color"
               id="primaryColor">
      </div>
      <div class="col-md-4">
        <label class="form-label fw-semibold">Warna Sekunder</label>
        <input type="color" name="theme_secondary_color"
               value="<?= esc($settings['theme_secondary_color']) ?>"
               class="form-control form-control-color"
               id="secondaryColor">
      </div>
      <div class="col-md-4">
        <label class="form-label fw-semibold">Warna Aksen</label>
        <input type="color" name="theme_accent_color"
               value="<?= esc($settings['theme_accent_color']) ?>"
               class="form-control form-control-color"
               id="accentColor">
      </div>
      <div class="col-md-4">
        <label class="form-label fw-semibold">Background</label>
        <input type="color" name="theme_background_color"
               value="<?= esc($settings['theme_background_color']) ?>"
               class="form-control form-control-color"
               id="backgroundColor">
      </div>

      <div class="col-md-4">
        <label class="form-label fw-semibold">Warna Card / Panel</label>
        <input type="color" name="theme_card_color"
               value="<?= esc($settings['theme_card_color']) ?>"
               class="form-control form-control-color"
               id="cardColor">
      </div>

    </div>

    <div class="text-end mt-4">
      <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Simpan Tema</button>
    </div>
  </form>
</div>

<script>
document.querySelectorAll('input[type="color"]').forEach(input => {
  input.addEventListener('input', e => {
    document.documentElement.style.setProperty(
      '--color-' + e.target.name.replace('theme_', '').replace('_color', ''),
      e.target.value
    );
  });
});
</script>


<?= $this->endSection() ?>
