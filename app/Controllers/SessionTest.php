<?php

namespace App\Controllers;

class SessionTest extends BaseController
{
    public function index()
    {
        $session = session()->get();

        echo "<h2>🔍 Cek Session Login</h2>";
        echo "<pre>";
        print_r($session);
        echo "</pre>";

        if (isset($session['is_logged_in']) && $session['is_logged_in'] === true) {
            echo "<p style='color: green;'>✅ Login berhasil. Anda sudah login sebagai: <strong>{$session['user']['name']}</strong></p>";
        } else {
            echo "<p style='color: red;'>❌ Belum login. Silakan login terlebih dahulu.</p>";
        }

        echo "<hr><a href='" . base_url('/dashboard') . "'>➡️ Coba masuk ke /dashboard</a><br>";
        echo "<a href='" . base_url('/logout') . "' style='color: crimson;'>🚪 Logout</a>";
    }
}
