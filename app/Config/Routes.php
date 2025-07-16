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

    // property filtered by developer
        $routes->get('developer/(:segment)/property', 'Dashboard\Property::byDeveloper/$1'); // index
        $routes->get('developer/(:segment)/property/create', 'Dashboard\Property::createByDeveloper/$1'); // create form
        $routes->post('developer/(:segment)/property/store', 'Dashboard\Property::storeByDeveloper/$1'); // store (POST)
        $routes->get('developer/(:segment)/property/(:segment)/edit', 'Dashboard\Property::editByDeveloper/$1/$2'); // edit
        $routes->post('developer/(:segment)/property/(:segment)/update', 'Dashboard\Property::updateByDeveloper/$1/$2'); // update

    // === PROPERTY ===
    $routes->group('property', function ($routes) {
        $routes->get('/', 'Dashboard\Property::index');
        $routes->get('create', 'Dashboard\Property::create');
        $routes->post('store', 'Dashboard\Property::store');
        $routes->get('edit/(:segment)', 'Dashboard\Property::edit/$1');
        $routes->post('update/(:segment)', 'Dashboard\Property::update/$1');
        $routes->get('delete/(:num)', 'Dashboard\Property::delete/$1');
        $routes->get('deleteImage/(:num)', 'Dashboard\Property::deleteImage/$1');
        $routes->get('detail/(:segment)', 'Dashboard\Property::detail/$1');
        $routes->post('detail/update/(:segment)', 'Dashboard\Property::updateDetail/$1');

        // Floor plan routes
        $routes->get('(:segment)/floorplan', 'Dashboard\Property::floorplan/$1');
        $routes->post('(:segment)/floorplan/store', 'Dashboard\Property::floorplanStore/$1');
        $routes->get('(:segment)/floorplan/delete/(:num)', 'Dashboard\Property::floorplanDelete/$1/$2');
        $routes->post('dashboard/property/(:segment)/add-floorplan', 'Dashboard\Property::storeFloorPlanFromDetail/$1');


        // Property Document routes
        $routes->get('(:segment)/documents', 'Dashboard\Property::documents/$1');
        $routes->post('(:segment)/documents/store', 'Dashboard\Property::documentsStore/$1');
        $routes->get('(:segment)/documents/delete/(:num)', 'Dashboard\Property::documentsDelete/$1/$2');
        $routes->post('dashboard/property/(:segment)/add-document', 'Dashboard\Property::storeDocumentFromDetail/$1');

        $routes->get('unit/(:segment)', 'Dashboard\Property::unitTypes/$1');
        $routes->post('unit/save', 'Dashboard\Property::saveUnit');
        $routes->get('unit/delete/(:num)', 'Dashboard\Property::deleteUnit/$1');









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







});

// ===========================
// ❌ Custom 404 harus diletakkan paling akhir
// ===========================
$routes->set404Override(function () {
    return view('errors/html/custom_404');
});
