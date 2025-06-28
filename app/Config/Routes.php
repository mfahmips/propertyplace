<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(false);

// routes

$routes->group('dashboard', ['namespace' => 'App\Controllers\Dashboard'], function($routes) {

    // dashboard index
    $routes->get('/', 'Index::index');

    // group property
    $routes->group('property', function($routes) {
        $routes->get('/', 'Property::index');                  // show list
        $routes->get('create', 'Property::create');            // show create form
        $routes->post('store', 'Property::store');             // process save
        $routes->get('edit/(:num)', 'Property::edit/$1');      // show edit form
        $routes->post('update/(:num)', 'Property::update/$1'); // process update
        $routes->get('delete/(:num)', 'Property::delete/$1');  // process delete
    });

});




