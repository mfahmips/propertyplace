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

        // Jika tidak ada role dalam session
        if (!$userRole) {
            return redirect()->to('/login')->with('error', 'Anda belum login');
        }

        // Jika tidak ada argument role yang diberikan
        if (!$arguments || !is_array($arguments)) {
            return redirect()->to('/dashboard')->with('error', 'Role tidak diatur');
        }

        // Jika role user tidak termasuk yang diperbolehkan
        if (!in_array($userRole, $arguments)) {
            return redirect()->to('/dashboard')->with('error', 'Anda tidak memiliki akses ke halaman ini');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Tidak perlu diisi
    }
}
