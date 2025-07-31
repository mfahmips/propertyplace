<!-- app/Views/auth/login.php -->
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?= esc($site_name) ?> - Login</title>
  <link rel="shortcut icon" href="<?= base_url('uploads/' . ($settings['site_icon'] ?? 'default-icon.png')) ?>" sizes="320x320" type="image/png">


  <!-- Font Awesome -->
  <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        crossorigin="anonymous" referrerpolicy="no-referrer"/>

  <style>
    @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap");

    *{box-sizing:border-box}

    body{
      background:#202429;
      display:flex;justify-content:center;align-items:center;
      height:100vh;margin:0;font-family:"Poppins",sans-serif
    }

    .container{
      background:#fff;width:768px;max-width:100%;
      border-radius:15px;box-shadow:0 10px 30px rgba(0,0,0,.3);
      overflow:hidden;display:flex
    }

    /* ─── FORM ─────────────────────────────── */
    .form-container{flex:1;padding:40px;background:#DAD3C5}
    .form-container h1{margin:0 0 20px;font-size:24px;color:#333}

    .form-container input{
      width:100%;padding:12px 10px;margin:8px 0;
      border:0;background:#f1f5ff;border-radius:4px;
      font-size:14px
    }
    .form-container input:focus{outline:none;box-shadow:0 0 0 2px #6664}

    /* wrapper khusus password agar bisa pasang ikon */
    .password-wrapper{position:relative}
    .toggle-password{
      position:absolute;right:12px;top:50%;transform:translateY(-50%);
      background:none;border:0;font-size:14px;color:#555;cursor:pointer
    }

    .options{display:flex;justify-content:space-between;align-items:center;margin:6px 0;font-size:12px}
    .options label{margin:0}
    .options a{text-decoration:none;color:#6b5c88}
    .options a:hover{text-decoration:underline}

    .form-container button[type="submit"]{
      width:100%;padding:12px;margin-top:14px;
      background:#B86C3A;color:#fff;border:0;border-radius:20px;
      cursor:pointer;transition:.3s
    }
    .form-container button:hover{background:#8d4e29}

    /* ─── SOCIAL ───────────────────────────── */
    .social-login{text-align:center;margin-top:20px;font-size:13px}
    .social-login a{margin:0 10px;font-size:18px;color:#555}
    .social-login a:hover{color:#333}

    /* ─── OVERLAY ──────────────────────────── */
    .overlay-panel{
      flex:1;background:url('https://images.unsplash.com/photo-1621360841013-c7683c659ec6?auto=format&fit=crop&w=900&q=80') center/cover;
      color:#fff;display:flex;flex-direction:column;justify-content:center;align-items:center;
      text-align:center;padding:30px
    }
    .overlay-panel h1{font-size:28px;margin:0 0 15px}
    .overlay-panel p{font-size:14px;margin:0 0 30px}
    .overlay-panel button{
      background:transparent;border:2px solid #fff;color:#fff;
      padding:10px 25px;border-radius:20px;cursor:pointer;transition:.3s
    }
    .overlay-panel button:hover{background:#fff;color:#333}

    /* ─── RESPONSIVE ───────────────────────── */
    @media (max-width:768px){
      .container{flex-direction:column}
      .overlay-panel{display:none}
    }
  </style>
</head>
<body>
  <div class="container">
    <!-- ── FORM SIDE ─────────────────────── -->
    <div class="form-container">
      <h1>Masuk ke Akun Anda</h1>

      <?php if(session()->getFlashdata('error')): ?>
        <p style="color:red"><?= session()->getFlashdata('error') ?></p>
      <?php endif; ?>

      <form action="<?= base_url('login') ?>" method="post">
        <?= csrf_field() ?>

        <input type="text" name="email" placeholder="Email atau Username" required />

        <!-- Password + toggle -->
        <div class="password-wrapper">
          <input type="password" id="password" name="password" placeholder="Kata Sandi" required />
          <button type="button" class="toggle-password" aria-label="Show password">
            <i class="fa-regular fa-eye"></i>
          </button>
        </div>

        <!-- Remember & Forgot -->
        <div class="options">
          <div style="display:flex;align-items:center;gap:6px;white-space:nowrap;">
            <input type="checkbox" id="remember" name="remember">
            <label for="remember">Ingat Saya</label>
          </div>
          <a href="#">Lupa kata sandi?</a>
        </div>

        <button type="submit">Masuk</button>

        <!-- Social -->
        <div class="social-login">
          <span>Atau masuk dengan</span><br>
          <a href="<?= base_url('auth/google') ?>"><i class="fab fa-google"></i></a>
        </div>
      </form>
    </div>

    <!-- ── OVERLAY SIDE ───────────────────── -->
    <div class="overlay-panel">
      <h1>Mulai Petualanganmu Sekarang</h1>
      <p>Jika belum punya akun, silakan daftar dan bergabung bersama kami!</p>
      <button onclick="window.location.href='<?= base_url('register') ?>'">Daftar</button>
    </div>
  </div>

  <!-- Show / Hide password script -->
  <script>
    document.querySelector('.toggle-password').addEventListener('click', function(){
      const pwInput = document.getElementById('password');
      const icon    = this.querySelector('i');
      if(pwInput.type === 'password'){
        pwInput.type = 'text';
        icon.classList.replace('fa-eye','fa-eye-slash');
        this.setAttribute('aria-label','Hide password');
      }else{
        pwInput.type = 'password';
        icon.classList.replace('fa-eye-slash','fa-eye');
        this.setAttribute('aria-label','Show password');
      }
    });
  </script>
</body>
</html>
