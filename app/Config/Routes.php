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
// ✅ ROUTE PUBLIK (FRONTEND)
// ===========================
$routes->group('', ['namespace' => 'App\Controllers\Frontend'], static function($routes) {
    $routes->get('/', 'Home::index');
    $routes->get('developer/(:segment)', 'Home::developer/$1');
    $routes->get('properties/by-developer/(:segment)', 'Home::getPropertiesByDeveloper/$1');
    $routes->get('property/(:segment)', 'Home::property/$1');
    $routes->get('property', 'Property::index');
    $routes->get('contact', 'Contact::index');
    $routes->post('contact/submit', 'Contact::submit');
    $routes->get('about', 'About::index');
});



// === DETAIL USER BERDASARKAN SLUG
$routes->get('user/(:segment)', 'User::detail/$1');

// === AUTH (login & register gabung)
$routes->get('login', 'Auth::index');              // tampilkan halaman login/register (default login)
$routes->get('register', 'Auth::index');           // tampilkan halaman register (langsung mode daftar)
$routes->post('login', 'Auth::login');             // proses login
$routes->post('register', 'Auth::register');       // proses register
$routes->get('logout', 'Auth::logout');            // logout



// === LOGIN GOOGLE (opsional)
$routes->get('auth/google', 'AuthGoogle::redirect');
$routes->get('auth/google/callback', 'AuthGoogle::callback');

// === TEST SESSION
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
        $routes->get('resetPassword/(:segment)', 'Dashboard\User::resetPassword/$1');


    });

    // === CRUD Developer ===
    $routes->group('developer', function($routes) {

        // === Developer CRUD ===
        $routes->get('/',                     'Dashboard\Developer::index');
        $routes->get('create',                'Dashboard\Developer::create');
        $routes->post('store',                'Dashboard\Developer::store');
        $routes->get('edit/(:segment)',       'Dashboard\Developer::edit/$1');
        $routes->post('update/(:segment)',    'Dashboard\Developer::update/$1');
        $routes->get('delete/(:num)',         'Dashboard\Developer::delete/$1');

        // === EXPORT & IMPORT PROPERTY ===
        $routes->get('(:segment)/export',  'Dashboard\Developer::exportProperty/$1');
        $routes->post('(:segment)/import', 'Dashboard\Developer::importProperty/$1');

        // === PROPERTY (dipindahkan ke Developer Controller) ===
        $routes->get('(:segment)',                                   'Dashboard\Developer::property/$1'); // index
        $routes->post('(:segment)/store',                   'Dashboard\Developer::storeProperty/$1'); // create
        $routes->post('(:segment)/(:segment)/update',       'Dashboard\Developer::updateProperty/$1/$2'); // update
        $routes->get('(:segment)/(:segment)/delete',        'Dashboard\Developer::deleteProperty/$1/$2'); // delete

        // === DETAIL PROPERTY ===
        $routes->get('(:segment)/(:segment)',                        'Dashboard\Developer::detailProperty/$1/$2');
        $routes->post('(:segment)/(:segment)/update','Dashboard\Developer::updateDetailProperty/$1/$2');
        $routes->post('(:segment)/(:segment)/save',  'Dashboard\Developer::saveDetailProperty/$1/$2');

        // === TYPE IMAGES (Floorplan) ===
        $routes->get('(:segment)/(:segment)/typeimages',              'Dashboard\Developer::typeImagesProperty/$1/$2');
        $routes->post('(:segment)/(:segment)/typeimages/save',        'Dashboard\Developer::storeTypeImagesProperty/$1/$2');
        $routes->get('(:segment)/(:segment)/typeimages/(:num)/delete','Dashboard\Developer::deleteTypeImagesProperty/$1/$2/$3');

        // === DOCUMENTS PROPERTY ===
        $routes->get('(:segment)/(:segment)/documents',               'Dashboard\Developer::documentsProperty/$1/$2');
        $routes->post('(:segment)/(:segment)/documents/store',        'Dashboard\Developer::storeDocumentProperty/$1/$2');
        $routes->get('(:segment)/(:segment)/documents/(:num)/delete', 'Dashboard\Developer::deleteDocumentProperty/$1/$2/$3');

        // === PROPERTY TYPE ===
        $routes->post('(:segment)/(:segment)/type/save',              'Dashboard\Developer::saveTypeProperty/$1/$2');
        $routes->get('(:segment)/(:segment)/type/(:num)/delete',      'Dashboard\Developer::deleteTypeProperty/$1/$2/$3');

        
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
        $routes->get('bookings', 'Dashboard\SalesActivity::bookings');

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
        $routes->get('komisi/cetak/(:num)', 'Dashboard\SalesActivity::cetakKomisi/$1');
        $routes->get('komisi/preview/(:num)', 'Dashboard\SalesActivity::cetakKomisiPreview/$1');



         // Booking
        $routes->post('bookings/save', 'Dashboard\SalesActivity::saveBooking');
        $routes->post('bookings/update', 'Dashboard\SalesActivity::updateBooking');
        $routes->get('getTypesByProperty/(:num)', 'Dashboard\SalesActivity::getTypesByProperty/$1');


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
