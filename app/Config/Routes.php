<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->post('/client', 'Client::create');
$routes->post('/client/auth', 'Client::index');
