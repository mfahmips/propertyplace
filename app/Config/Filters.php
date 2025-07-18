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

        // custom
        'login'         => \App\Filters\LoginFilter::class,
        'auth'          => \App\Filters\Auth::class,
        'role'          => \App\Filters\RoleFilter::class,


    ];

    // Middleware global (semua route)
    public array $globals = [
    'before' => [
        'auth' => [
            'except' => [
                '/', // home
                'login', 'login/*',
                'logout', 'logout/*',
                'register', 'register/*',
                'property', 'property/*',
            ]
        ]
    ],
    'after' => [
        'toolbar',
    ],
];


    public array $methods = [];

    public array $filters = [];


}
