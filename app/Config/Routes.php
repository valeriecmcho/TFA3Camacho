<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('operations', 'Operations::index');
$routes->get('operations/displayinfo/(:segment)/(:segment)/(:segment)/(:segment)/(:segment)', 'Operations::displayinfo/$1/$2/$3/$4/$5');
$routes->get('operations/compute/(:num)/(:num)', 'Operations::compute/$1/$2');
$routes->get('operations/compute', 'Operations::compute');

// POS System Routes
$routes->get('customer-accounts', 'CustomerAccounts::index');
$routes->get('customers/new', 'CustomerAccounts::new');
$routes->post('customers/create', 'CustomerAccounts::create');
$routes->get('customers/edit/(:num)', 'CustomerAccounts::edit/$1');
$routes->post('customers/update/(:num)', 'CustomerAccounts::update/$1');
$routes->get('user-accounts', 'UserAccounts::index');
$routes->get('users/new', 'UserAccounts::new');
$routes->post('users/create', 'UserAccounts::create');
$routes->get('users/edit/(:num)', 'UserAccounts::edit/$1');
$routes->post('users/update/(:num)', 'UserAccounts::update/$1');
