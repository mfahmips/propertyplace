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
$routes->get('property', 'Frontend\Property::index');
$routes->get('property/(:segment)', 'Frontend\Property::detail/$1');
$routes->get('/contact', 'Frontend\Contact::index');
$routes->post('/contact/submit', 'Frontend\Contact::submit');
$routes->get('/about', 'Frontend\About::index');




// === DETAIL USER BERDASARKAN SLUG (contoh: /user/john-doe)
$routes->get('user/(:segment)', 'User::detail/$1');

// Auth routes
$routes->get('login', 'Auth::loginForm');     // tampilkan form login
$routes->post('login', 'Auth::login');        // proses login
$routes->get('logout', 'Auth::logout');       // logout

// Register routes
$routes->get('register', 'Auth::registerForm');  // tampilkan form register
$routes->post('register', 'Auth::register');     // proses simpan user baru



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

        $routes->get('profile/(:segment)', 'Dashboard\User::profile/$1');
    // === USER ===
        $routes->group('user', function ($routes) {
        $routes->get('/', 'Dashboard\User::index');
        $routes->get('create', 'Dashboard\User::create');
        $routes->post('store', 'Dashboard\User::store');
        $routes->get('edit/(:segment)', 'Dashboard\User::edit/$1');
        $routes->post('update/(:num)', 'Dashboard\User::update/$1');
        $routes->get('delete/(:num)', 'Dashboard\User::delete/$1');
        $routes->get('deletePhoto/(:num)', 'Dashboard\User::deletePhoto/$1'); // ✅ Diperbaiki
        $routes->post('autosave', 'Dashboard\User::autosave');
        $routes->post('updateRole/(:num)', 'Dashboard\User::updateRole/$1');
        $routes->post('updateStatus/(:num)', 'Dashboard\User::updateStatus/$1');


    });

    // === CRUD Developer ===
    $routes->group('developer', function($routes){

        $routes->get('/',              'Dashboard\Developer::index');
        $routes->get('create',         'Dashboard\Developer::create');
        $routes->post('store',         'Dashboard\Developer::store');
        $routes->get('edit/(:segment)',    'Dashboard\Developer::edit/$1');
        $routes->post('update/(:segment)', 'Dashboard\Developer::update/$1');
        $routes->get('delete/(:num)',  'Dashboard\Developer::delete/$1');

        // === Property CRUD khusus filter developer ===
        $routes->get('(:segment)/property', 'Dashboard\Property::byDeveloper/$1'); // index property by developer
        $routes->post('(:segment)/property/store', 'Dashboard\Property::storeByDeveloper/$1'); // create property
        $routes->post('(:segment)/property/(:segment)/update', 'Dashboard\Property::updateByDeveloper/$1/$2'); // update property
        $routes->get('(:segment)/property/(:segment)/delete', 'Dashboard\Property::deleteByDeveloper/$1/$2'); // delete property

        // Image property
        $routes->get('(:segment)/property/image/(:num)/delete', 'Dashboard\Property::deleteImageByDeveloper/$1/$2');

        // Detail Property
        $routes->get('(:segment)/property/(:segment)/detail', 'Dashboard\Property::detailByDeveloper/$1/$2');
        $routes->post('(:segment)/property/(:segment)/detail/update', 'Dashboard\Property::updateDetailByDeveloper/$1/$2');
        $routes->post('(:segment)/property/(:segment)/detail/save', 'Dashboard\Property::saveDetailByDeveloper/$1/$2');


       // === TYPE IMAGES (dulunya floorplan) ===
        $routes->get('(:segment)/property/(:segment)/typeimages', 'Dashboard\Property::typeImagesByDeveloper/$1/$2');
        $routes->post('(:segment)/property/(:segment)/typeimages/save', 'Dashboard\Property::storetypeimagesByDeveloper/$1/$2');
        $routes->get('(:segment)/property/(:segment)/typeimages/(:num)/delete', 'Dashboard\Property::deletetypeimagesByDeveloper/$1/$2/$3');

        // Document
        $routes->get('(:segment)/property/(:segment)/documents', 'Dashboard\Property::documentsByDeveloper/$1/$2');
        $routes->post('(:segment)/property/(:segment)/documents/store', 'Dashboard\Property::storeDocumentByDeveloper/$1/$2');
        $routes->get('(:segment)/property/(:segment)/documents/(:num)/delete', 'Dashboard\Property::deleteDocumentByDeveloper/$1/$2/$3');

        // === PROPERTY TYPE ===
        $routes->post('(:segment)/property/(:segment)/type/save', 'Dashboard\Property::saveTypeByDeveloper/$1/$2');
        $routes->get('(:segment)/property/(:segment)/type/(:num)/delete', 'Dashboard\Property::deleteTypeByDeveloper/$1/$2/$3');
    });


    // === PROPERTY ===
    // Khusus untuk role admin: hanya index, detail unit type, documents, floorplan
    $routes->group('property', function ($routes) {
        $routes->get('/', 'Dashboard\Property::index'); // index semua property untuk admin/karyawan/customer (read-only)
        $routes->get('detail/(:segment)', 'Dashboard\Property::detail/$1');
        $routes->get('unit/(:segment)', 'Dashboard\Property::unitTypes/$1');
        $routes->get('(:segment)/floorplan', 'Dashboard\Property::floorPlan/$1');
        $routes->get('(:segment)/documents', 'Dashboard\Property::documents/$1');
    });


        // === BLOG ===
        $routes->group('blog', ['filter' => 'auth'], function ($routes) {
        $routes->get('/', 'Dashboard\Blog::index');
        $routes->get('create', 'Dashboard\Blog::create');
        $routes->post('store', 'Dashboard\Blog::store');
        $routes->get('edit/(:segment)', 'Dashboard\Blog::edit/$1');
        $routes->post('update/(:segment)', 'Dashboard\Blog::update/$1');
        $routes->post('delete/(:num)', 'Dashboard\Blog::delete/$1');

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

        $routes->group('SalesActivity', ['filter' => 'auth'], function ($routes) {
        // Halaman utama
        $routes->get('absensi', 'Dashboard\SalesActivity::absensi');
        $routes->get('pameran', 'Dashboard\SalesActivity::pameran');
        $routes->get('komisi', 'Dashboard\SalesActivity::komisi');

        // CRUD untuk absensi
        $routes->post('absensi/masuk', 'Dashboard\SalesActivity::absenMasuk');
        $routes->post('absensi/pulang', 'Dashboard\SalesActivity::absenPulang');

        // CRUD untuk pameran
        $routes->post('pameran/save', 'Dashboard\SalesActivity::savePameran');
        $routes->post('pameran/delete', 'Dashboard\SalesActivity::deletePameran');
        $routes->post('pameran/update', 'Dashboard\SalesActivity::updatePameran');

        // CRUD untuk komisi (jika ada pengajuan atau update status)
        $routes->post('komisi/save', 'Dashboard\SalesActivity::saveKomisi');
        $routes->post('komisi/update', 'Dashboard\SalesActivity::updateKomisi');
    });


        $routes->group('KPRCalculator', ['filter' => 'auth'], function ($routes) {
        $routes->get('/', 'Dashboard\KPRCalculator::index');
        $routes->post('kpr-calculate', 'Dashboard\KPRCalculator::calculate');
    });


});

// ===========================
// ❌ Custom 404 harus diletakkan paling akhir
// ===========================
$routes->set404Override(function () {
    return view('errors/html/custom_404');
});
