<?php

namespace App\Controllers\Dashboard;

use App\Controllers\BaseController;

class KPRCalculator extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Kalkulator KPR',
            'breadcrumb' => [
                ['label' => 'Dashboard', 'url' => base_url('dashboard')],
                ['label' => 'Kalkulator KPR']
            ]
        ];

        return view('admin/sales/kpr', $data);
    }

    public function calculate()
    {
        try {
            // Ambil dan sanitasi input
            $price = (float) $this->request->getPost('price');
            $dp    = (float) $this->request->getPost('dp');
            $rate  = (float) $this->request->getPost('rate');
            $tenor = (int) $this->request->getPost('tenor');

            // Logging untuk debug (bisa dihapus di production)
            log_message('debug', 'Data POST KPR: ' . json_encode([
                'price' => $price,
                'dp' => $dp,
                'rate' => $rate,
                'tenor' => $tenor
            ]));

            // Validasi dasar
            if ($price <= 0) {
                return $this->response->setJSON(['error' => 'Harga properti harus lebih dari 0.'])->setStatusCode(400);
            }

            if ($dp < 0 || $dp >= $price) {
                return $this->response->setJSON(['error' => 'DP tidak boleh negatif atau melebihi harga.'])->setStatusCode(400);
            }

            if ($rate <= 0 || $rate > 100) {
                return $this->response->setJSON(['error' => 'Suku bunga harus antara 0 - 100%.'])->setStatusCode(400);
            }

            if ($tenor <= 0 || $tenor > 50) {
                return $this->response->setJSON(['error' => 'Tenor harus antara 1 - 50 tahun.'])->setStatusCode(400);
            }

            // Perhitungan
            $loan = $price - $dp;
            $monthly_rate = $rate / 100 / 12;
            $months = $tenor * 12;

            $cicilan = ($loan * $monthly_rate) / (1 - pow(1 + $monthly_rate, -$months));

            return $this->response->setJSON([
                'cicilan' => number_format($cicilan, 0, ',', '.')
            ]);
        } catch (\Throwable $e) {
            // Error internal: kirim log dan response error ke frontend
            log_message('error', 'KPR Error: ' . $e->getMessage());
            return $this->response->setJSON([
                'error' => 'Gagal menghitung cicilan. Silakan coba lagi.'
            ])->setStatusCode(500);
        }
    }
}
