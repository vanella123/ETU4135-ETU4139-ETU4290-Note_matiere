<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'LoginController::index');

// Routes pour le StudentController
$routes->get('/student', 'StudentController::index');
$routes->get('/student/(:num)/details(/(:alpha))?(/.*)?', 'StudentController::details/$1/$2');
$routes->get('/student/(:num)/edit-notes', 'StudentController::editNotes/$1');
$routes->post('/student/update-note', 'StudentController::updateNote');
