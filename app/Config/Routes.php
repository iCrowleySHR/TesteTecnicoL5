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
    $routes->get('show/(:num)', 'Product::show/$1');
    $routes->get('show', 'Product::show');    
    $routes->delete('delete/(:num)', 'Product::delete/$1');
    $routes->put('update/(:num)', 'Product::update/$1');
});

$routes->group('order', ['filter' => 'jwt'], function($routes) {
    $routes->post('create', 'Order::create');
    $routes->get('show/(:num)', 'Order::show/$1');
    $routes->get('show', 'Order::show');    
    $routes->delete('delete/(:num)', 'Order::delete/$1');
    $routes->put('update/(:num)', 'Order::update/$1');
});
