<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'LoginController::index');
$routes->post('login/authenticate', 'LoginController::authenticate');
$routes->get('dashboard', 'DashboardController::index');

$routes->get('/bulletin/create', 'BulletinController::create');
$routes->post('/bulletin/store', 'BulletinController::store');
$routes->get('/eleves', 'BulletinController::listeEleves');