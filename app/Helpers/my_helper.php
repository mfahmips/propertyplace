<?php

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
     * Generate slug unik berdasarkan kolom slug di tabel properti
     *
     * @param string $title Judul yang akan dikonversi menjadi slug
     * @param \App\Models\PropertyModel $model Model untuk cek slug
     * @return string Slug yang unik
     */
    function generateUniqueSlug(string $title, \App\Models\PropertyModel $model): string
    {
        $slug = url_title($title, '-', true);
        $originalSlug = $slug;
        $i = 1;

        while ($model->where('slug', $slug)->countAllResults() > 0) {
            $slug = $originalSlug . '-' . $i++;
        }

        return $slug;
    }
}


