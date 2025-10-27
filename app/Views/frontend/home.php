<!doctype html>
<html lang="en" class="no-js" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title><?= esc($settings['site_name'] ?? 'PropertyPlace') ?></title>
    <meta name="author" content="PropertyPlace">
    <meta name="description" content="PropertyPlace - Real Estate Property Listing Platform">
    <meta name="keywords" content="PropertyPlace, Real Estate, Property, Apartment, Listing">
    <meta name="robots" content="INDEX,FOLLOW">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="57x57" href="<?= base_url('uploads/' . ($settings['site_icon'] ?? 'default-icon.png')) ?>">
    <link rel="apple-touch-icon" sizes="60x60" href="<?= base_url('uploads/' . ($settings['site_icon'] ?? 'default-icon.png')) ?>">
    <link rel="apple-touch-icon" sizes="72x72" href="<?= base_url('uploads/' . ($settings['site_icon'] ?? 'default-icon.png')) ?>">
    <link rel="apple-touch-icon" sizes="76x76" href="<?= base_url('uploads/' . ($settings['site_icon'] ?? 'default-icon.png')) ?>">
    <link rel="apple-touch-icon" sizes="114x114" href="<?= base_url('uploads/' . ($settings['site_icon'] ?? 'default-icon.png')) ?>">
    <link rel="apple-touch-icon" sizes="120x120" href="<?= base_url('uploads/' . ($settings['site_icon'] ?? 'default-icon.png')) ?>">
    <link rel="apple-touch-icon" sizes="144x144" href="<?= base_url('uploads/' . ($settings['site_icon'] ?? 'default-icon.png')) ?>">
    <link rel="apple-touch-icon" sizes="152x152" href="<?= base_url('uploads/' . ($settings['site_icon'] ?? 'default-icon.png')) ?>">
    <link rel="apple-touch-icon" sizes="180x180" href="<?= base_url('uploads/' . ($settings['site_icon'] ?? 'default-icon.png')) ?>">
    <link rel="icon" type="image/png" sizes="192x192" href="<?= base_url('uploads/' . ($settings['site_icon'] ?? 'default-icon.png')) ?>">
    <link rel="icon" type="image/png" sizes="32x32" href="<?= base_url('uploads/' . ($settings['site_icon'] ?? 'default-icon.png')) ?>">
    <link rel="icon" type="image/png" sizes="96x96" href="<?= base_url('uploads/' . ($settings['site_icon'] ?? 'default-icon.png')) ?>">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= base_url('uploads/' . ($settings['site_icon'] ?? 'default-icon.png')) ?>">
    <link rel="manifest" href="<?= base_url('assets/frontend/img/favicons/manifest.json') ?>">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="<?= base_url('uploads/' . ($settings['site_icon'] ?? 'default-icon.png')) ?>">
    <meta name="theme-color" content="#ffffff">
    <link rel="manifest" href="<?= base_url('assets/frontend/img/favicons/manifest.json') ?>">

    <!-- FONTS -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&family=Outfit:wght@100..900&display=swap" rel="stylesheet">

    <!-- CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/frontend/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/frontend/css/fontawesome.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/frontend/css/style.css') ?>">

<style>
  /* Lock viewport and hide scroll */
  html, body {
    margin: 0;
    padding: 0;
    height: 100%;
    overflow: hidden;
    font-family: 'Outfit', sans-serif;
    background-color: #202429;
  }

  /* HERO SECTION */
  .th-hero-wrapper {
    position: relative;
    width: 100%;
    height: 100vh; /* Full viewport */
    display: flex;
    justify-content: center;
    align-items: center;
    color: #fff;
    text-align: center;
    overflow: hidden;
  }

  .hero-video {
    position: absolute;
    top: 0; left: 0;
    width: 100%; height: 100%;
    object-fit: cover;
    z-index: 0;
    filter: brightness(0.55);
  }

  .th-hero-wrapper::after {
    content: "";
    position: absolute;
    inset: 0;
    background: linear-gradient(to bottom, rgba(32,36,41,0.2), rgba(32,36,41,0.8));
    z-index: 1;
  }

  /* CONTENT */
  .hero-style3 {
    position: relative;
    z-index: 2;
    max-width: 1100px;
    width: 100%;
    padding: 0 20px;
    animation: fadeUp 1s ease forwards;
  }

  @keyframes fadeUp {
    from { opacity: 0; transform: translateY(30px); }
    to { opacity: 1; transform: translateY(0); }
  }

  .hero-style3 h1 {
    font-size: 3rem;
    font-weight: 700;
    margin: 25px 0 40px;
    line-height: 1.2;
    color: #fff;
  }

  /* BUTTONS */
.btn-wrap {
  display: flex;
  justify-content: center;
  gap: 20px;
  flex-wrap: wrap;
}

.th-btn {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  border: none;
  color: #fff;
  background: linear-gradient(to bottom left, #c4552e, #2a0f0b);
  padding: 12px 24px;
  border-radius: 40px;
  font-weight: 600;
  text-decoration: none;
  transition: all 0.3s ease;
  box-shadow: 0 4px 10px rgba(32, 36, 41, 0.3);
}

.th-btn:hover {
  background: linear-gradient(to top right, #2a0f0b, #c4552e);
  color: #fff;
  box-shadow: 0 6px 15px rgba(196, 85, 46, 0.5);
  transform: translateY(-2px);
}

</style>
</head>

<body>

<?php if (session()->getFlashdata('error')): ?>
<div class="alert alert-warning text-center">
    <?= session()->getFlashdata('error') ?>
</div>
<?php endif; ?>

<!--==============================
Hero Area
==============================-->
<div class="th-hero-wrapper hero-3" id="hero">
  <video class="hero-video" src="<?= base_url('assets/frontend/img/hero/hero-3-video.mp4') ?>" autoplay muted loop></video>

  <div class="hero-style3 text-center">

    <h1>Experience The Harmonious<br>Blend Of Luxury</h1>

    <form class="property-search-form" style="border: 0;" method="get" action="<?= base_url('/') ?>">
    <label style="background: linear-gradient(to bottom left, #c4552e, #2a0f0b);">Property Search</label>
    <!-- ✅ Dropdown Developer -->
  <select class="form-select custom-select" name="developer" id="developerSelect">
  <option value="">Developer</option>
  <?php foreach ($developers as $dev): ?>
    <option value="<?= esc($dev['slug']) ?>" <?= ($filter_developer == $dev['slug']) ? 'selected' : '' ?>>
      <?= esc($dev['name']) ?>
    </option>
  <?php endforeach; ?>
</select>



  <!-- ✅ Dropdown Property -->
  <select class="form-select custom-select" name="property" id="propertySelect" disabled>
    <option value="">Property</option>
  </select>

  <button class="th-btn mt-3" type="submit">
    <i class="far fa-search"></i> Search
  </button>
</form>

  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
  const form = document.querySelector('.property-search-form');
  const developerSelect = document.getElementById('developerSelect');
  const propertySelect  = document.getElementById('propertySelect');

  const baseUrl = "<?= base_url() ?>"; // pastikan ini dievaluasi oleh PHP

  // 1️⃣ DISABLE PROPERTY DROPDOWN SAAT DEVELOPER BELUM DIPILIH
  propertySelect.disabled = true;

  // 2️⃣ KETIKA DEVELOPER DIPILIH, LOAD PROPERTY DENGAN AJAX
  developerSelect.addEventListener('change', async function() {
    const slug = this.value;

    if (!slug) {
      propertySelect.innerHTML = '<option value="">Property</option>';
      propertySelect.disabled = true;
      return;
    }

    // Loading state
    propertySelect.innerHTML = '<option value="">Memuat data properti...</option>';
    propertySelect.disabled = true;

    try {
      const response = await fetch(`${baseUrl}properties/by-developer/${slug}`);
      if (!response.ok) throw new Error(`HTTP ${response.status}`);
      
      const data = await response.json();
      propertySelect.innerHTML = '<option value="">Pilih Properti</option>';

      if (Array.isArray(data) && data.length > 0) {
        data.forEach(p => {
          const opt = document.createElement('option');
          opt.value = p.id;
          opt.textContent = p.title;
          propertySelect.appendChild(opt);
        });
      } else {
        propertySelect.innerHTML = '<option value="">Tidak tersedia</option>';
      }

      propertySelect.disabled = false;
    } catch (err) {
      console.error('Fetch error:', err);
      propertySelect.innerHTML = '<option value="">Gagal memuat data</option>';
      propertySelect.disabled = true;
    }
  });

  // 3️⃣ VALIDASI FORM SEBELUM SUBMIT
  form.addEventListener('submit', function(e) {
    const keywordField  = form.querySelector('input[name="keyword"]');
    const propertyField = form.querySelector('select[name="property"]');
    const locationField = form.querySelector('select[name="location"]'); // optional

    const keyword  = keywordField ? keywordField.value.trim() : '';
    const property = propertyField ? propertyField.value.trim() : '';
    const location = locationField ? locationField.value.trim() : '';

    if (!keyword && !property && !location) {
      e.preventDefault();

      if (!document.querySelector('.search-alert')) {
        const alert = document.createElement('div');
        alert.className = 'alert alert-warning text-center search-alert';
        alert.style.marginTop = '15px';
        alert.innerText = 'Silakan pilih property tersedia';
        form.insertAdjacentElement('afterend', alert);
        setTimeout(() => alert.remove(), 3000);
      }
    }
  });
});
</script>



<!-- JS -->
<script src="<?= base_url('assets/frontend/js/vendor/jquery-3.7.1.min.js') ?>"></script>
<script src="<?= base_url('assets/frontend/js/bootstrap.min.js') ?>"></script>
<script src="<?= base_url('assets/frontend/js/swiper-bundle.min.js') ?>"></script>
<script src="<?= base_url('assets/frontend/js/main.js') ?>"></script>
</body>
</html>
