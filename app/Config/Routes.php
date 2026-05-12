<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/login', 'Login::showLogin');
$routes->post('/login', 'Login::doLogin');

$routes->get('/creneau', 'Client::index');

$routes->get('/register', 'Register::showRegister');
