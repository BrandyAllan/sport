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
