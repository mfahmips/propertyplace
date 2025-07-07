<?php

namespace Config;

use CodeIgniter\Events\Events;
use CodeIgniter\Exceptions\FrameworkException;
use CodeIgniter\HotReloader\HotReloader;

Events::on('pre_system', static function (): void {
    if (ENVIRONMENT !== 'testing') {
        if (ini_get('zlib.output_compression')) {
            throw FrameworkException::forEnabledZlibOutputCompression();
        }

        while (ob_get_level() > 0) {
            ob_end_flush();
        }

        ob_start(static fn ($buffer) => $buffer);
    }

    /*
     * --------------------------------------------------------------------
     * Debug Toolbar Listeners.
     * --------------------------------------------------------------------
     * If you delete, they will no longer be collected.
     */
    if (CI_DEBUG && ! is_cli()) {
        Events::on('DBQuery', 'CodeIgniter\Debug\Toolbar\Collectors\Database::collect');
        service('toolbar')->respond();

        // Hot Reload route - for framework use on the hot reloader.
        if (ENVIRONMENT === 'development') {
            service('routes')->get('__hot-reload', static function (): void {
                (new HotReloader())->run();
            });
        }
    }
});

/*
 * --------------------------------------------------------------------
 * Auto Assign Role After Registration
 * --------------------------------------------------------------------
 */
Events::on('register', function ($user) {
    $groups = service('groups');
    
    if ($groups && $user) {
        $groups->addUserToGroup($user->id, 'user');
    }
});

/*
 * --------------------------------------------------------------------
 * Debug Events for Login Process
 * --------------------------------------------------------------------
 */

Events::on('login', function($user) {
    log_message('info', 'User ' . $user->username . ' telah login.');
});

Events::on('loginFailed', function ($info) {
    log_message('error', 'LOGIN GAGAL: ' . json_encode($info));
});

Events::on('loginAttempt', function ($info) {
    log_message('debug', 'Percobaan login: ' . json_encode($info));
});
