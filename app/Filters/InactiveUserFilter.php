<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class InactiveUserFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();

        // Hanya jalankan untuk user login
        if ($session->get('logged_in')) {
            $role = $session->get('role');
            $isActive = (int) $session->get('is_active');

            // Jika bukan admin/management dan belum aktif
            if ($isActive === 0 && !in_array($role, ['admin', 'management'])) {
                // Boleh tetap lihat dashboard, tapi tidak boleh ke menu lain
                $uri = service('uri')->getPath();

                // izinkan hanya dashboard
                if (!preg_match('#^dashboard$#', $uri) && !preg_match('#^dashboard/$#', $uri)) {
                    return redirect()
                        ->to('/dashboard')
                        ->with('warning', 'Akun Anda belum disetujui oleh admin.');
                }
            }
        }

        return;
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Tidak perlu aksi setelah response
    }
}
