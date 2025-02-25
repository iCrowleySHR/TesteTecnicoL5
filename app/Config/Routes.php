<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->group('client', [], function($routes) {
    $routes->post('create', 'Client::create');
    $routes->post('auth', 'Client::auth');
    
    $routes->group('', ['filter' => 'jwt'], function($routes) {
        $routes->get('show', 'Client::show');
        $routes->delete('delete', 'Client::delete');
        $routes->put('update', 'Client::update');
    });
});

$routes->group('product', ['filter' => 'jwt'], function($routes) {
    $routes->post('create', 'Product::create');
    // $routes->get('index', 'Product::index');
    // $routes->get('show', 'Product::show');
    $routes->delete('delete/(:num)', 'Product::delete/$1');
    // $routes->put('update', 'Product::update');
});

