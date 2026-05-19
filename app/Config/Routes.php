<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/login', 'Login::showLogin');
$routes->post('/login', 'Login::doLogin');

$routes->get('/creneau', 'Creneau::creneau');
$routes->post('/ajouter-creneau', 'Creneau::ajouter_creneau');
$routes->get('/supprimer-creneau/(:num)', 'Creneau::supprimer_creneau/$1');
$routes->get('/editer-creneau/(:num)', 'Creneau::edit_creneau/$1');
$routes->post('/editer-creneau', 'Creneau::update_creneau');

$routes->get('/register', 'Register::showRegister');
$routes->post('/register', 'Register::doRegister');

$routes->get('/logout', 'Login::logout');

$routes->get('/dashboard', 'Dashboard::dashbobard');

$routes->get('/reserver/(:num)', 'Reservation::reserver/$1');

$routes->get('/confirmer/(:num)', 'Reservation::confirmer/$1');
$routes->get('/refuser/(:num)', 'Reservation::refuser/$1');
$routes->get('/annuler/(:num)', 'Reservation::annuler/$1');

$routes->get('/reservation', 'Reservation::reservation');

$routes->get('/liste-client', 'Dashboard::clients');
