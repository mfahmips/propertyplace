<?php

namespace Config;

use CodeIgniter\Config\Filters as BaseFilters;
use CodeIgniter\Filters\Cors;
use CodeIgniter\Filters\CSRF;
use CodeIgniter\Filters\DebugToolbar;
use CodeIgniter\Filters\ForceHTTPS;
use CodeIgniter\Filters\Honeypot;
use CodeIgniter\Filters\InvalidChars;
use CodeIgniter\Filters\PageCache;
use CodeIgniter\Filters\PerformanceMetrics;
use CodeIgniter\Filters\SecureHeaders;

class Filters extends BaseFilters
{
    public array $aliases = [
        'csrf'          => CSRF::class,
        'toolbar'       => DebugToolbar::class,
        'honeypot'      => Honeypot::class,
        'invalidchars'  => InvalidChars::class,
        'secureheaders' => SecureHeaders::class,
        'cors'          => Cors::class,
        'forcehttps'    => ForceHTTPS::class,
        'pagecache'     => PageCache::class,
        'performance'   => PerformanceMetrics::class,

        // Custom filters
        'login'         => \App\Filters\LoginFilter::class,
        'auth'          => \App\Filters\Auth::class,
        'role'          => \App\Filters\RoleFilter::class,
        'inactiveUser'  => \App\Filters\InactiveUserFilter::class, // ✅ baru ditambahkan
    ];

    // =========================
    // GLOBAL FILTERS
    // =========================
    public array $globals = [
    'before' => [
        'auth' => [
            'except' => [
                '/', 
                'login', 'login/*',
                'logout', 'logout/*',
                'register', 'register/*',
                'property', 'property/*',
                'developer', 'developer/*',
                'properties/by-developer', 'properties/by-developer/*',
                'auth/google', 'auth/google/*',
                'contact', 'contact/*',
                'about',
                'dashboard/user/autosave', // AJAX autosave tetap bisa diakses
            ]
        ],
    ],
    'after' => [
        'toolbar',
    ],
];


    public array $methods = [];

    // =========================
    // KHUSUS UNTUK DASHBOARD
    // =========================
    public array $filters = [
        // ⬇️ Filter untuk mencegah user belum aktif mengakses halaman selain dashboard
        'inactiveUser' => [
            'before' => [
                'dashboard/*',
            ]
        ],
    ];
}
