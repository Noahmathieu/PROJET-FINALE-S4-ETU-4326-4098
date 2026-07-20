<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */













$routes->get('/', 'AuthController::login');
$routes->post('/checkLogin', 'AuthController::checkLogin');
$routes->get('/logout', 'AuthController::logout');
