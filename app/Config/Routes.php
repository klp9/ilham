<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

// Public / General routes
$routes->get('/', 'HomeController::index');
$routes->get('rooms', 'HomeController::rooms'); // AJAX/HTML room catalog
$routes->get('rooms/(:num)', 'HomeController::roomDetail/$1');

// Auth routes
$routes->get('login', 'AuthController::login');
$routes->post('login', 'AuthController::loginProcess');
$routes->get('register', 'AuthController::register');
$routes->post('register', 'AuthController::registerProcess');
$routes->get('logout', 'AuthController::logout');

// RESTful Resource API
$routes->get('api/rooms', 'RoomApiController::index');

// Admin Routes (Protected by AuthFilter and AdminFilter)
$routes->group('admin', ['filter' => ['auth', 'admin']], function($routes) {
    $routes->get('dashboard', 'Admin\DashboardController::index');
    
    // CRUD Categories
    $routes->get('categories', 'Admin\CategoryController::index');
    $routes->get('categories/create', 'Admin\CategoryController::create');
    $routes->post('categories/store', 'Admin\CategoryController::store');
    $routes->get('categories/edit/(:num)', 'Admin\CategoryController::edit/$1');
    $routes->post('categories/update/(:num)', 'Admin\CategoryController::update/$1');
    $routes->post('categories/delete/(:num)', 'Admin\CategoryController::delete/$1');

    // CRUD Rooms
    $routes->get('rooms', 'Admin\RoomController::index');
    $routes->get('rooms/create', 'Admin\RoomController::create');
    $routes->post('rooms/store', 'Admin\RoomController::store');
    $routes->get('rooms/edit/(:num)', 'Admin\RoomController::edit/$1');
    $routes->post('rooms/update/(:num)', 'Admin\RoomController::update/$1');
    $routes->post('rooms/delete/(:num)', 'Admin\RoomController::delete/$1');

    // CRUD Facilities
    $routes->get('facilities', 'Admin\FacilityController::index');
    $routes->get('facilities/create', 'Admin\FacilityController::create');
    $routes->post('facilities/store', 'Admin\FacilityController::store');
    $routes->get('facilities/edit/(:num)', 'Admin\FacilityController::edit/$1');
    $routes->post('facilities/update/(:num)', 'Admin\FacilityController::update/$1');
    $routes->post('facilities/delete/(:num)', 'Admin\FacilityController::delete/$1');

    // Bookings and Reports
    $routes->get('bookings', 'Admin\BookingController::index');
    $routes->get('bookings/detail/(:num)', 'Admin\BookingController::detail/$1');
    $routes->post('bookings/update-status/(:num)', 'Admin\BookingController::updateStatus/$1');
    $routes->get('reports', 'Admin\BookingController::reports');
});

// Customer Routes (Protected by AuthFilter and CustomerFilter)
$routes->group('customer', ['filter' => ['auth', 'customer']], function($routes) {
    $routes->get('dashboard', 'Customer\DashboardController::index');
    $routes->get('profile', 'Customer\DashboardController::profile');
    $routes->post('profile/update', 'Customer\DashboardController::updateProfile');
    
    // Booking transaction
    $routes->post('bookings/create', 'Customer\BookingController::create');
    $routes->get('bookings/detail/(:num)', 'Customer\BookingController::detail/$1');
    $routes->post('bookings/payment/(:num)', 'Customer\BookingController::uploadPayment/$1');
});
