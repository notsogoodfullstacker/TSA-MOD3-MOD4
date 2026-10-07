<?php

use Config\Services;

$routes = Services::routes();

$routes->get('/', 'Home::index');
$routes->get('tasks', 'TaskController::index');
$routes->get('profile', 'Home::profile');
$routes->get('about', 'Home::about');

$routes->get('login', 'AuthController::login');
$routes->post('login', 'AuthController::authenticate');
$routes->get('logout', 'AuthController::logout');

$routes->group('', ['filter' => 'auth'], function($routes) {
    $routes->get('tasks/new', 'TaskController::new');
    $routes->post('tasks', 'TaskController::create');
    $routes->get('tasks/edit/(:num)', 'TaskController::edit/$1');
    $routes->post('tasks/update/(:num)', 'TaskController::update/$1');
    $routes->get('tasks/delete/(:num)', 'TaskController::delete/$1');
});
