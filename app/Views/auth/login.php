<!-- Simpan file ini sebagai app/Views/auth/login.php -->
<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Halaman Masuk</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
      @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap");

      * {
        box-sizing: border-box;
      }

      body {
        background-color: #6c7383;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        font-family: "Poppins", sans-serif;
        margin: 0;
      }

      .container {
        background: #fff;
        width: 768px;
        max-width: 100%;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        overflow: hidden;
        display: flex;
        flex-direction: row;
        position: relative;
      }

      .form-container {
        flex: 1;
        padding: 40px;
      }

      .form-container h1 {
        margin-bottom: 20px;
        font-size: 24px;
        color: #333;
      }

      .form-container input {
        width: 100%;
        padding: 12px 10px;
        margin: 8px 0;
        border: none;
        border-bottom: 2px solid #ccc;
        background: none;
        font-size: 14px;
      }

      .form-container input:focus {
        outline: none;
        border-color: #666;
      }

      .form-container .options {
        display: flex;
        justify-content: space-between;
        font-size: 13px;
        margin: 10px 0;
      }

      .form-container button {
        width: 100%;
        padding: 12px;
        background-color: #555;
        color: white;
        border: none;
        border-radius: 20px;
        margin-top: 10px;
        cursor: pointer;
        transition: all 0.3s ease;
      }

      .form-container button:hover {
        background-color: #333;
      }

      .social-login {
        text-align: center;
        margin-top: 20px;
      }

      .social-login span {
        font-size: 13px;
      }

      .social-login a {
        margin: 0 10px;
        font-size: 18px;
        color: #555;
      }

      .overlay-panel {
        flex: 1;
        background: url('https://images.unsplash.com/photo-1621360841013-c7683c659ec6?ixlib=rb-4.0.3&auto=format&fit=crop&w=900&q=80') no-repeat center center;
        background-size: cover;
        color: white;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        padding: 30px;
        text-align: center;
      }

      .overlay-panel h1 {
        font-size: 28px;
        margin-bottom: 15px;
      }

      .overlay-panel p {
        font-size: 14px;
        margin-bottom: 30px;
      }

      .overlay-panel button {
        background-color: transparent;
        border: 2px solid white;
        color: white;
        padding: 10px 25px;
        border-radius: 20px;
        cursor: pointer;
        transition: 0.3s;
      }

      .overlay-panel button:hover {
        background-color: white;
        color: #333;
      }

      @media (max-width: 768px) {
        .container {
          flex-direction: column;
        }
        .overlay-panel {
          display: none;
        }
      }
    </style>
  </head>
  <body>
    <div class="container">
      <div class="form-container">
        <h1>Masuk ke Akun Anda</h1>

        <?php if (session()->getFlashdata('error')) : ?>
        <p style="color:red"><?= session()->getFlashdata('error') ?></p>
        <?php endif; ?>
        
        <form action="<?= base_url('login') ?>" method="post">
          <?= csrf_field() ?>
          <input type="email" name="email" placeholder="Alamat Email" required />
          <input type="password" name="password" placeholder="Kata Sandi" required />

          <div class="options">
            <label>
              <input type="checkbox" name="remember" /> Ingat Saya
            </label>
            <a href="#">Lupa kata sandi?</a>
          </div>

          <button type="submit">Masuk</button>

          <div class="social-login">
            <span>Atau masuk dengan</span><br />
            <a href="<?= base_url('auth/google') ?>"><i class="fab fa-google"></i></a>
            <a href="<?= base_url('auth/facebook') ?>"><i class="fab fa-facebook-f"></i></a>
            <a href="<?= base_url('auth/github') ?>"><i class="fab fa-github"></i></a>
          </div>
        </form>
      </div>
      <div class="overlay-panel">
        <h1>Mulai Petualanganmu Sekarang</h1>
        <p>
          Jika belum punya akun, silakan daftar dan bergabung bersama kami!
        </p>
        <button onclick="window.location.href='<?= base_url('register') ?>'">Daftar</button>
      </div>
    </div>
  </body>
</html>
