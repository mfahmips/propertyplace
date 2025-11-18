<?= $this->extend('admin/layout/default') ?>
<?= $this->section('content') ?>

<div class="container py-4">
  <h4 class="mb-4"><i class="bi bi-palette me-2"></i> Pengaturan Tema Warna</h4>

  <?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      <i class="bi bi-check-circle me-2"></i><?= session()->getFlashdata('success') ?>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  <?php endif; ?>

  <form action="<?= base_url('dashboard/settings/theme-colors/save') ?>" method="post" class="card p-4 shadow-sm border-0">
    <?= csrf_field() ?>

    <div class="row g-4">
      <!-- Warna Utama -->
      <div class="col-md-4">
        <label class="form-label fw-semibold">🎨 Warna Utama</label>
        <input type="color" name="theme_primary_color"
               value="<?= esc($settings['theme_primary_color'] ?? '#B86C3A') ?>"
               class="form-control form-control-color"
               id="primaryColor"
               title="Warna utama elemen navigasi & tombol">
      </div>

      <!-- Warna Hover Utama -->
      <div class="col-md-4">
        <label class="form-label fw-semibold">🟠 Warna Hover Utama</label>
        <input type="color" name="theme_primary_hover"
               value="<?= esc($settings['theme_primary_hover'] ?? '#8D4E29') ?>"
               class="form-control form-control-color"
               id="primaryHover"
               title="Warna utama saat di-hover">
      </div>

      <!-- Warna Background -->
      <div class="col-md-4">
        <label class="form-label fw-semibold">⬛ Background</label>
        <input type="color" name="theme_background_color"
               value="<?= esc($settings['theme_background_color'] ?? '#20242A') ?>"
               class="form-control form-control-color"
               id="backgroundColor"
               title="Warna latar belakang halaman">
      </div>

      <!-- Warna Panel -->
      <div class="col-md-4">
        <label class="form-label fw-semibold">📋 Warna Panel</label>
        <input type="color" name="theme_panel_color"
               value="<?= esc($settings['theme_panel_color'] ?? '#DAD3C5') ?>"
               class="form-control form-control-color"
               id="panelColor"
               title="Warna panel, sidebar, atau navbar">
      </div>

      <!-- Warna Card -->
      <div class="col-md-4">
        <label class="form-label fw-semibold">📦 Warna Card</label>
        <input type="color" name="theme_card_color"
               value="<?= esc($settings['theme_card_color'] ?? '#FFFFFF') ?>"
               class="form-control form-control-color"
               id="cardColor"
               title="Warna dasar elemen card, kontainer, atau modal">
      </div>

      <!-- Warna Teks -->
      <div class="col-md-4">
        <label class="form-label fw-semibold">🔤 Warna Teks</label>
        <input type="color" name="theme_text_color"
               value="<?= esc($settings['theme_text_color'] ?? '#20242A') ?>"
               class="form-control form-control-color"
               id="textColor"
               title="Warna teks utama">
      </div>

      <!-- Warna Teks Sekunder -->
      <div class="col-md-4">
        <label class="form-label fw-semibold">💬 Warna Teks Sekunder</label>
        <input type="color" name="theme_muted_text_color"
               value="<?= esc($settings['theme_muted_text_color'] ?? '#9B9B9B') ?>"
               class="form-control form-control-color"
               id="mutedTextColor"
               title="Warna teks sekunder atau hint text">
      </div>
    </div>

    <div class="text-end mt-4">
      <button type="submit" class="btn btn-primary px-4">
        <i class="bi bi-save me-1"></i> Simpan Tema
      </button>
    </div>
  </form>
</div>

<!-- =========================
     🎨 LIVE PREVIEW SYSTEM
========================= -->
<script>
document.querySelectorAll('input[type="color"]').forEach(input => {
  input.addEventListener('input', e => {
    const name = e.target.name;
    let cssVar = '';
    switch (name) {
      case 'theme_primary_color': cssVar = '--primary-color'; break;
      case 'theme_primary_hover': cssVar = '--primary-hover'; break;
      case 'theme_background_color': cssVar = '--bg-color'; break;
      case 'theme_panel_color': cssVar = '--panel-bg'; break;
      case 'theme_card_color': cssVar = '--card-bg'; break;
      case 'theme_text_color': cssVar = '--text-color'; break;
      case 'theme_muted_text_color': cssVar = '--muted-text'; break;
    }
    if (cssVar) document.documentElement.style.setProperty(cssVar, e.target.value);
  });
});
</script>

<style>
  :root {
    --primary-color: <?= esc($settings['theme_primary_color'] ?? '#B86C3A') ?>;
    --primary-hover: <?= esc($settings['theme_primary_hover'] ?? '#8D4E29') ?>;
    --bg-color: <?= esc($settings['theme_background_color'] ?? '#20242A') ?>;
    --panel-bg: <?= esc($settings['theme_panel_color'] ?? '#DAD3C5') ?>;
    --card-bg: <?= esc($settings['theme_card_color'] ?? '#FFFFFF') ?>;
    --text-color: <?= esc($settings['theme_text_color'] ?? '#20242A') ?>;
    --muted-text: <?= esc($settings['theme_muted_text_color'] ?? '#9B9B9B') ?>;
  }

  body {
    background-color: var(--bg-color);
    color: var(--text-color);
    transition: background-color 0.3s ease, color 0.3s ease;
  }

  .card, .panel, .modal-content {
    background-color: var(--card-bg);
    color: var(--text-color);
    border: 1px solid rgba(255,255,255,0.05);
    transition: background-color 0.3s ease;
  }

  .btn-primary {
    background-color: var(--primary-color);
    border: none;
    color: #fff;
    transition: background 0.3s ease;
  }

  .btn-primary:hover {
    background-color: var(--primary-hover);
    color: #fff;
  }
</style>

<?= $this->endSection() ?>
