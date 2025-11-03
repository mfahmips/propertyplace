<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title id="pageTitle">Login - <?= esc($site_name ?? 'Property Place') ?></title>

  <!-- Favicon from settings -->
  <link rel="icon" href="<?= base_url('uploads/' . ($settings['site_icon'] ?? 'default-icon.png')) ?>" type="image/png" />

  <!-- CSS -->
  <link rel="stylesheet" href="<?= base_url('assets/admin/style.css') ?>">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>
<body>
  <main>
    <div class="box">
      <div class="inner-box">
        <div class="forms-wrap">
          <!-- Sign In Form -->
          <form action="<?= base_url('login') ?>" method="post" autocomplete="off" class="sign-in-form">
            <?= csrf_field() ?>
            <div class="logo">
              <img src="<?= base_url('uploads/' . ($settings['site_logo'] ?? 'default-logo.png')) ?>" alt="Logo" style="height: 40px; width: auto;" />

              <h4>Property Place</h4>
            </div>

            <div class="heading">
              <h2>Masuk</h2>
              <h6>Belum punya akun?</h6>
              <a href="#" class="toggle">Daftar</a>
            </div>

            <div class="actual-form">
              <div class="input-wrap">
                <input type="text" name="email" class="input-field" autocomplete="off" placeholder="Username atau Email" required />
              </div>

              <div class="input-wrap">
                <input type="password" name="password" class="input-field" autocomplete="off" placeholder="Kata Sandi" required />
              </div>

              <input type="submit" value="Masuk" class="sign-btn" />

              <p class="text" style="text-align:center;margin-top:16px;">
                Lupa password? <a href="#">Klik di sini</a>
              </p>

              <p class="text" style="text-align:center;margin-top:16px;">
                Atau masuk dengan <br>
                <a href="<?= base_url('auth/google') ?>" style="text-align:center;margin-top:16px;">
                  <i class="fab fa-google"></i>
                </a>


              </p>
            </div>
          </form>

          <!-- Sign Up Form -->
          <form action="<?= base_url('register') ?>" method="post" class="sign-up-form">
            <?= csrf_field() ?>

            <div class="logo">
              <img src="<?= base_url('uploads/' . ($settings['site_logo'] ?? 'default-logo.png')) ?>" alt="Logo" style="height: 40px; width: auto;" />
              <h4>Property Place</h4>
            </div>

            <div class="heading">
              <h2>Daftar Akun</h2>
              <h6>Sudah punya akun?</h6>
              <a href="#" class="toggle">Masuk</a>
            </div>

            <div class="actual-form">
              <div class="input-wrap">
                <input type="text" name="name" class="input-field" placeholder="Nama Lengkap" value="<?= old('name') ?>" required />
              </div>

              <div class="input-wrap">
                <input type="text" name="username" class="input-field" placeholder="Username" value="<?= old('username') ?>" required />
              </div>

              <div class="input-wrap">
                <input type="email" name="email" class="input-field" placeholder="Email" value="<?= old('email') ?>" required />
              </div>

              <div class="input-wrap">
                <input type="password" name="password" class="input-field" placeholder="Kata Sandi" required />
              </div>

              <div class="input-wrap">
                <input type="password" name="re_password" class="input-field" placeholder="Ulangi Kata Sandi" required />
              </div>

              <input type="hidden" name="role" value="sales" />
              <input type="submit" value="Daftar" class="sign-btn" />

              <p class="text">
                Dengan mendaftar, saya menyetujui
                <a href="#">Syarat Layanan</a> dan
                <a href="#">Kebijakan Privasi</a>
              </p>
            </div>
          </form>

        </div>

        <!-- Carousel Side -->
        <div class="carousel">
          <div class="images-wrapper">
            <img src="<?= base_url('assets/admin/img/image1.png') ?>" class="image img-1 show" alt="" />
            <img src="<?= base_url('assets/admin/img/image2.png') ?>" class="image img-2" alt="" />
            <img src="<?= base_url('assets/admin/img/image3.png') ?>" class="image img-3" alt="" />
          </div>

          <div class="text-slider">
            <div class="text-wrap">
              <div class="text-group">
                <h2>Gabung bersama tim sukses kami</h2>
                <h2>Bangun karier dari properti</h2>
                <h2>Capai impian finansialmu</h2>
              </div>
            </div>

            <div class="bullets">
              <span class="active" data-value="1"></span>
              <span data-value="2"></span>
              <span data-value="3"></span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>

<script>
  const toggleLinks = document.querySelectorAll('.toggle');
  const main = document.querySelector('main');
  const pageTitle = document.getElementById('pageTitle');

  toggleLinks.forEach(toggle => {
    toggle.addEventListener('click', (e) => {
      e.preventDefault();

      // Toggle antara login dan register
      main.classList.toggle('sign-up-mode');

      // Ubah URL tanpa reload halaman
      const isSignup = main.classList.contains('sign-up-mode');
      const newUrl = isSignup ? '/register' : '/login';
      window.history.pushState({}, '', newUrl);

      // Ubah title halaman
      pageTitle.textContent = (isSignup ? 'Daftar' : 'Login') + ' - <?= esc($site_name ?? 'Property Place') ?>';
    });
  });

  // Pastikan mode register aktif saat membuka /register
  if (window.location.pathname === '/register') {
    main.classList.add('sign-up-mode');
    pageTitle.textContent = 'Daftar - <?= esc($site_name ?? 'Property Place') ?>';
  }
</script>


  <!-- JS -->
  <script src="<?= base_url('assets/admin/app.js') ?>"></script>
</body>
</html>
