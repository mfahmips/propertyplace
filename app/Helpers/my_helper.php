<?php

use CodeIgniter\Model;

if (!function_exists('tanggal_indo')) {
    function tanggal_indo($tanggal)
    {
        $hari = [
            'Sunday'    => 'Minggu',
            'Monday'    => 'Senin',
            'Tuesday'   => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday'  => 'Kamis',
            'Friday'    => 'Jumat',
            'Saturday'  => 'Sabtu',
        ];

        $bulan = [
            'January'   => 'Januari',
            'February'  => 'Februari',
            'March'     => 'Maret',
            'April'     => 'April',
            'May'       => 'Mei',
            'June'      => 'Juni',
            'July'      => 'Juli',
            'August'    => 'Agustus',
            'September' => 'September',
            'October'   => 'Oktober',
            'November'  => 'November',
            'December'  => 'Desember',
        ];

        $dayName   = $hari[date('l', strtotime($tanggal))];
        $dayNum    = date('d', strtotime($tanggal));
        $monthName = $bulan[date('F', strtotime($tanggal))];
        $year      = date('Y', strtotime($tanggal));

        return "{$dayName}, {$dayNum} {$monthName} {$year}";
    }
}


if (!function_exists('generateUniqueSlug')) {
    /**
     * Generate slug unik dari string kombinasi
     *
     * @param string $baseSlug
     * @param \CodeIgniter\Model $model
     * @return string
     */
    function generateUniqueSlug(string $baseSlug, \CodeIgniter\Model $model): string
    {
        $slug = url_title($baseSlug, '-', true);
        $originalSlug = $slug;
        $i = 1;

        while ($model->where('slug', $slug)->countAllResults() > 0) {
            $slug = $originalSlug . '-' . $i++;
        }

        return $slug;
    }
}




