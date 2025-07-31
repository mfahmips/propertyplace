<?php
// app/Views/auth/register.php
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?= esc($site_name) ?> - Register</title>
  <link rel="shortcut icon" href="<?= base_url('uploads/' . ($settings['site_icon'] ?? 'default-icon.png')) ?>" sizes="320x320" type="image/png">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" crossorigin="anonymous" />

  <style>
    @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap");
    * { box-sizing: border-box; }

    body {
      background: #202429;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
      font-family: "Poppins", sans-serif;
    }

    .container {
      background: #fff;
      width: 768px;
      max-width: 100%;
      border-radius: 15px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
      overflow: hidden;
      display: flex;
    }

    .form-container {
      flex: 1;
      background: #DAD3C5;
      padding: 60px 40px;
      display: flex;
      flex-direction: column;
      justify-content: center;
    }

    .form-container h1 {
      margin-bottom: 20px;
      font-size: 24px;
      color: #333;
      text-align: center;
    }

    .form-container input {
      width: 100%;
      padding: 12px 10px;
      margin: 8px 0;
      border: 0;
      background: #f1f5ff;
      border-radius: 4px;
      font-size: 14px;
    }

    .form-container input:focus {
      outline: none;
      box-shadow: 0 0 0 2px #6664;
    }

    .password-wrapper {
      position: relative;
    }

    .toggle-password {
      position: absolute;
      right: 12px;
      top: 50%;
      transform: translateY(-50%);
      background: none;
      border: 0;
      font-size: 14px;
      color: #555;
      cursor: pointer;
    }

    .form-container button[type="submit"] {
      width: 100%;
      padding: 12px;
      margin-top: 14px;
      background: #B86C3A;
      color: #fff;
      border: 0;
      border-radius: 20px;
      cursor: pointer;
      transition: 0.3s;
    }

    .form-container button:hover {
      background: #8d4e29;
    }

    .overlay-panel {
      flex: 1;
      background: url('https://images.unsplash.com/photo-1621360841013-c7683c659ec6?auto=format&fit=crop&w=900&q=80') center/cover;
      color: #fff;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      text-align: center;
      padding: 60px 40px;
    }

    .overlay-panel h1 { font-size: 28px; margin-bottom: 15px; }
    .overlay-panel p  { font-size: 14px; margin-bottom: 30px; }
    .overlay-panel button {
      background: transparent;
      border: 2px solid #fff;
      color: #fff;
      padding: 10px 25px;
      border-radius: 20px;
      cursor: pointer;
      transition: 0.3s;
    }
    .overlay-panel button:hover {
      background: #fff;
      color: #333;
    }

    /* Modal success */
    .modal {
      position: fixed;
      top: 0; left: 0; width: 100%; height: 100%;
      background: rgba(0,0,0,0.6);
      display: flex;
      align-items: center;
      justify-content: center;
      z-index: 9999;
    }
    .modal-content {
      background: #fff;
      padding: 30px;
      border-radius: 10px;
      max-width: 400px;
      text-align: center;
    }
    .modal-content h2 {
      margin-bottom: 10px;
      color: #2e7d32;
    }
    .modal-content button {
      margin-top: 20px;
      padding: 10px 25px;
      background: #B86C3A;
      color: white;
      border: none;
      border-radius: 20px;
      cursor: pointer;
    }

    @media (max-width: 768px) {
      .container { flex-direction: column; }
      .overlay-panel { display: none; }
    }
  </style>
</head>
<body>

  <div class="container">
    <div class="form-container">
      <h1>Buat Akun</h1>

      <?php if(session()->getFlashdata('error')): ?>
        <p style="color:red; text-align:center"><?= session()->getFlashdata('error') ?></p>
      <?php endif; ?>

      <form action="<?= base_url('register') ?>" method="post">
        <?= csrf_field() ?>
        <input type="text" name="name" placeholder="Nama Lengkap" value="<?= old('name') ?>" required />
        <input type="text" name="username" placeholder="Username" value="<?= old('username') ?>" required />
        <input type="email" name="email" placeholder="Alamat Email" value="<?= old('email') ?>" required />

        <div class="password-wrapper">
          <input type="password" id="password" name="password" placeholder="Kata Sandi" required />
          <button type="button" class="toggle-password"><i class="fa-regular fa-eye"></i></button>
        </div>

        <div class="password-wrapper">
          <input type="password" id="re_password" name="re_password" placeholder="Ulangi Kata Sandi" required />
          <button type="button" class="toggle-password"><i class="fa-regular fa-eye"></i></button>
        </div>

        <input type="hidden" name="role" value="sales" />
        <button type="submit">Daftar</button>
      </form>
    </div>

    <div class="overlay-panel">
      <h1>Sudah Punya Akun?</h1>
      <p>Masuk untuk mengelola data properti dan pelanggan</p>
      <button onclick="window.location.href='<?= base_url('login') ?>'">Masuk</button>
    </div>
  </div>

  <?php if(session()->getFlashdata('success')): ?>
    <div class="modal" id="successModal">
      <div class="modal-content">
        <h2>Registrasi Berhasil</h2>
        <p><?= session()->getFlashdata('success') ?></p>
        <button onclick="window.location.href='<?= base_url('login') ?>'">OK</button>
      </div>
    </div>
  <?php endif; ?>

  <script>
    document.querySelectorAll('.toggle-password').forEach(toggle => {
      toggle.addEventListener('click', function(){
        const input = this.previousElementSibling;
        const icon = this.querySelector('i');
        input.type = input.type === 'password' ? 'text' : 'password';
        icon.classList.toggle('fa-eye');
        icon.classList.toggle('fa-eye-slash');
      });
    });
  </script>
</body>
</html>
