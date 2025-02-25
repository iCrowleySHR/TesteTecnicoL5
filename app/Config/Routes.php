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

