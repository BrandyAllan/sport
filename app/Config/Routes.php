<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/login', 'Login::showLogin');
$routes->post('/login', 'Login::doLogin');

$routes->get('/creneau', 'Dashboard::creneau');

$routes->get('/register', 'Register::showRegister');
$routes->post('/register', 'Register::doRegister');

$routes->get('/logout', 'Login::logout');

$routes->get('/dashboard', 'Dashboard::dashbobard');

$routes->get('/reserver/(:num)', 'Reservation::reserver/$1');

$routes->get('/confirmer/(:num)', 'Reservation::confirmer/$1');
$routes->get('/refuser/(:num)', 'Reservation::refuser/$1');
$routes->get('/annuler/(:num)', 'Reservation::annuler/$1');
