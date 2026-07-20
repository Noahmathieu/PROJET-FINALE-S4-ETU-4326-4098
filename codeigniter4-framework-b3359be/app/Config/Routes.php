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
$routes->get('/typeOperation', 'TypeOperationController::list');
$routes->post('/typeOperation/ajouter', 'TypeOperationController::ajouter');
$routes->post('/typeOperation/modifier/(:num)', 'TypeOperationController::modifier/$1');
$routes->get('/typeOperation/supprimer/(:num)', 'TypeOperationController::supprimer/$1');






//Noah
$routes->get('/', 'AuthController::login');
$routes->get('/logout', 'AuthController::logout');
$routes->post('/checkLogin', 'AuthController::checkLogin');
$routes->get('/logout', 'AuthController::logout');
$routes->get('/client/home', 'ClientController::index');
$routes->get('/operator/home', 'OperatorController::index');
$routes->get('/client/transfert', 'TransactionController::transfer');
$routes->get('/client/depot', 'TransactionController::depot');
$routes->get('/client/retrait', 'TransactionController::retrait');
$routes->post('/transfert/valide', 'TransactionController::valideTransfert');
$routes->post('/transfert/depot/valide', 'TransactionController::valideDepot');
$routes->post('/transfert/retrait/valide', 'TransactionController::valideRetrait');
$routes->get('/client/historique', 'TransactionController::historique');