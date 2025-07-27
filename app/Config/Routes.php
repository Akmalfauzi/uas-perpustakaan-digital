<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

// Authentication Routes
$routes->get('/login', 'Login::index');
$routes->post('/login/authenticate', 'Login::authenticate');
$routes->get('/logout', 'Login::logout');
$routes->get('/register', 'Register::index');
$routes->post('/register/create', 'Register::create');

// Book Routes
$routes->get('/books', 'Books::index');
$routes->get('/books/new', 'Books::new');
$routes->post('/books/create', 'Books::create');
$routes->get('/books/(:num)', 'Books::show/$1');
$routes->get('/books/(:num)/download', 'Books::download/$1');
$routes->get('/books/(:num)/edit', 'Books::edit/$1');
$routes->post('/books/(:num)/update', 'Books::update/$1');
$routes->post('/books/(:num)/delete', 'Books::delete/$1');
$routes->post('/books/(:num)/request-loan', 'Books::requestLoan/$1');
$routes->post('/books/search', 'Books::search');
$routes->get('/books/categories', 'Books::categories');

// User Dashboard Routes
$routes->group('dashboard', ['filter' => 'auth'], function($routes) {
    $routes->get('/', 'Dashboard::index');
    $routes->get('loans', 'Dashboard::loans');
    $routes->post('request-loan', 'Dashboard::requestLoan');
    $routes->post('cancel-loan/(:num)', 'Dashboard::cancelLoan/$1');
});

// Admin Routes (with admin prefix)
$routes->group('admin', ['filter' => 'auth'], function($routes) {
    // Admin Dashboard
    $routes->get('dashboard', 'Admin::dashboard');
    
    // Admin Books Management
    $routes->get('books', 'Admin::books');
    $routes->get('books/new', 'Admin::newBook');
    $routes->post('books/create', 'Admin::createBook');
    $routes->get('books/(:num)/edit', 'Admin::editBook/$1');
    $routes->post('books/(:num)/update', 'Admin::updateBook/$1');
    $routes->post('books/(:num)/delete', 'Admin::deleteBook/$1');
    
    // Admin Users Management
    $routes->get('users', 'Admin::users');
    $routes->get('users/new', 'Admin::newUser');
    $routes->post('users/create', 'Admin::createUser');
    $routes->get('users/(:num)/edit', 'Admin::editUser/$1');
    $routes->post('users/(:num)/update', 'Admin::updateUser/$1');
    $routes->post('users/(:num)/toggle-status', 'Admin::toggleUserStatus/$1');
    
    // Admin Loan Management
    $routes->get('loans', 'Admin::loans');
    $routes->post('loans/(:num)/approve', 'Admin::approveLoan/$1');
    $routes->post('loans/(:num)/reject', 'Admin::rejectLoan/$1');
    $routes->post('loans/(:num)/return', 'Admin::returnBook/$1');
    
    // Admin Settings
    $routes->get('settings', 'Admin::settings');
    $routes->post('settings/update', 'Admin::updateSettings');
});
