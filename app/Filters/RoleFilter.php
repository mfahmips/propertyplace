<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class RoleFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $userRole = session()->get('role');
        $uri = service('uri')->getPath(); // dapatkan path URI misalnya: dashboard/user/autosave

        // 🔹 1. Izinkan semua role untuk autosave (agar profil tersimpan otomatis)
        if (preg_match('#^dashboard/user/autosave#', $uri)) {
            return; // lewati filter
        }

        // 🔹 2. Jika belum login
        if (!$userRole) {
            return redirect()->to('/login')->with('error', 'Anda belum login');
        }

        // 🔹 3. Jika filter dipakai tapi tidak diberi argument role
        if (!$arguments || !is_array($arguments)) {
            return redirect()->to('/dashboard')->with('error', 'Role tidak diatur');
        }

        // 🔹 4. Jika role user tidak termasuk dalam yang diizinkan
        if (!in_array($userRole, $arguments)) {
            return redirect()->to('/dashboard')->with('error', 'Anda tidak memiliki akses ke halaman ini');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // tidak perlu isi
    }
}
