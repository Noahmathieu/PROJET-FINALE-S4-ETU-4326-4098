<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
//Mitia
$routes->get('/config', 'ConfigurationController::form');
$routes->post('/config/ajouter', 'ConfigurationController::ajouter');
$routes->get('/config/supprimer/(:num)', 'ConfigurationController::supprimer/$1');
$routes->get('/frais', 'FraisController::list');
$routes->post('/frais/ajouter', 'FraisController::ajouter');
$routes->post('/frais/modifier/(:num)', 'FraisController::modifier/$1');
$routes->get('/frais/supprimer/(:num)', 'FraisController::supprimer/$1');









//Noah
$routes->get('/', 'AuthController::login');
$routes->post('/checkLogin', 'AuthController::checkLogin');
$routes->get('/logout', 'AuthController::logout');