<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->setAutoRoute(false); // tetap disarankan disable untuk keamanan

// ===========================
// ✅ Route publik (non-dashboard)
// ===========================
$routes->get('/', 'Frontend\Home::index');

// === DETAIL USER BERDASARKAN SLUG (contoh: /user/john-doe)
$routes->get('user/(:segment)', 'User::detail/$1');

// Auth routes
$routes->get('login', 'Auth::loginForm'); // tampilkan form login
$routes->post('login', 'Auth::login');    // proses login
$routes->get('logout', 'Auth::logout');   // logout


$routes->get('auth/google', 'AuthGoogle::redirect');
$routes->get('auth/google/callback', 'AuthGoogle::callback');

$routes->get('session-test', 'SessionTest::index');


// ===========================
// ✅ Route ke halaman dashboard utama
// ===========================
$routes->get('dashboard', 'Dashboard\Index::index');

// ===========================
// ✅ Route-group: Dashboard (dengan prefix /dashboard)
// ===========================
$routes->group('dashboard', ['filter' => 'auth'], function ($routes) {

    // === USER ===
    $routes->group('user', function ($routes) {
        $routes->get('/', 'Dashboard\User::index');
        $routes->get('create', 'Dashboard\User::create');
        $routes->post('store', 'Dashboard\User::store');
        $routes->get('edit/(:segment)', 'Dashboard\User::edit/$1');
        $routes->post('update/(:segment)', 'Dashboard\User::update/$1');
        $routes->get('delete/(:num)', 'Dashboard\User::delete/$1');
        $routes->get('user/deletePhoto/(:num)', 'Dashboard\User::deletePhoto/$1');
        $routes->get('profile', 'Dashboard\User::profile');

    });

    // === CRUD Developer ===
    $routes->group('developer', function($routes){
        $routes->get('/',              'Dashboard\Developer::index');
        $routes->get('create',         'Dashboard\Developer::create');
        $routes->post('store',         'Dashboard\Developer::store');
        $routes->get('edit/(:segment)',    'Dashboard\Developer::edit/$1');
        $routes->post('update/(:segment)', 'Dashboard\Developer::update/$1');
        $routes->get('delete/(:num)',  'Dashboard\Developer::delete/$1');
    });

    // === PROPERTY ===
    $routes->group('property', function ($routes) {
        $routes->get('/', 'Dashboard\Property::index');
        $routes->get('create', 'Dashboard\Property::create');
        $routes->post('store', 'Dashboard\Property::store');
        $routes->get('edit/(:segment)', 'Dashboard\Property::edit/$1');
        $routes->post('update/(:segment)', 'Dashboard\Property::update/$1');
        $routes->get('delete/(:num)', 'Dashboard\Property::delete/$1');
        $routes->get('deleteImage/(:num)', 'Dashboard\Property::deleteImage/$1');

        // property filtered by developer
        $routes->get('developer/(:segment)', 'Dashboard\Property::byDeveloper/$1');
        $routes->get('developer/(:segment)/create',    'Dashboard\Property::createByDeveloper/$1');
        $routes->post('developer/(:segment)/store',    'Dashboard\Property::storeByDeveloper/$1');
        $routes->get('developer/(:segment)/edit/(:segment)', 'Dashboard\Property::editByDeveloper/$1/$2');
        $routes->post('developer/(:segment)/update/(:segment)', 'Dashboard\Property::updateByDeveloper/$1/$2');
    });

            // === SETTINGS ===
        $routes->group('settings', ['filter' => 'auth'], function ($routes) {
        $routes->get('/', 'Dashboard\Settings::index');
        $routes->get('site-info', 'Dashboard\Settings::siteInfo');
        $routes->post('site-info', 'Dashboard\Settings::saveSiteInfo');
        $routes->get('contact-social', 'Dashboard\Settings::contactSocial');
        $routes->post('contact-social', 'Dashboard\Settings::saveContactSocial');
        $routes->get('logo-icon', 'Dashboard\Settings::logoIcon');
        $routes->post('logo-icon', 'Dashboard\Settings::saveLogoIcon');
        $routes->get('locale', 'Dashboard\Settings::locale');
        $routes->post('locale', 'Dashboard\Settings::saveLocale');
        $routes->get('maintenance', 'Dashboard\Settings::maintenance');
        $routes->post('maintenance', 'Dashboard\Settings::saveMaintenance');
    });







});

// ===========================
// ❌ Custom 404 harus diletakkan paling akhir
// ===========================
$routes->set404Override(function () {
    return view('errors/html/custom_404');
});
