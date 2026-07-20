<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
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
$routes->get('/client/home', 'ClientController::index');
$routes->get('/operator/home', 'OperatorController::index');
$routes->get('/client/transfer', 'ClientController::transfer');
$routes->get('/client/depot', 'ClientController::depot');
$routes->get('/client/retrait', 'ClientController::retrait');
