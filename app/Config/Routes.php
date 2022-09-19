<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (is_file(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
//$routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'DashboardController::index');
$routes->match(['get', 'post'], 'register', 'CompanyController::register');
$routes->match(['get'], 'register/success', 'CompanyController::registerSuccess');
$routes->match(['get', 'post'], 'activate', 'CompanyController::activate');
$routes->match(['get', 'post'], 'login', 'AuthController::login');
$routes->get('logout', 'AuthController::logout');

$routes->group('costs', function($routes) {
    $routes->get('', 'CostController::index');
    $routes->match(['get', 'post'], 'add', 'CostController::edit/0');
    $routes->match(['get', 'post'], 'edit/(:num)', 'CostController::edit/$1');
    $routes->match(['get', 'post'], 'delete/(:num)', 'CostController::delete/$1');
    $routes->get('view/(:num)', 'CostController::view/$1');
});

$routes->group('cost-categories', function($routes) {
    $routes->get('', 'CostCategoryController::index');
    $routes->match(['get', 'post'], 'add', 'CostCategoryController::edit/0');
    $routes->match(['get', 'post'], 'edit/(:num)', 'CostCategoryController::edit/$1');
    $routes->match(['get', 'post'], 'delete/(:num)', 'CostCategoryController::delete/$1');
    $routes->get('view/(:num)', 'CostCategoryController::view/$1');
});

$routes->group('companies', function($routes) {
    $routes->get('', 'CompanyController::index');
    $routes->match(['get', 'post'], 'add', 'CompanyController::edit/0');
    $routes->match(['get', 'post'], 'edit/(:num)', 'CompanyController::edit/$1');
    $routes->match(['get', 'post'], 'delete/(:num)', 'CompanyController::delete/$1');
    $routes->get('view/(:num)', 'CompanyController::view/$1');
});

$routes->group('customers', function($routes) {
    $routes->get('', 'CustomerController::index');
    $routes->match(['get', 'post'], 'add', 'CustomerController::edit/0');
    $routes->match(['get', 'post'], 'edit/(:num)', 'CustomerController::edit/$1');
    $routes->match(['get', 'post'], 'delete/(:num)', 'CustomerController::delete/$1');
    $routes->match(['get', 'post'], 'activate-product/(:num)', 'CustomerController::activateProduct/$1');
    $routes->get('view/(:num)', 'CustomerController::view/$1');
});

$routes->group('products', function($routes) {
    $routes->get('', 'ProductController::index');
    $routes->match(['get', 'post'], 'add', 'ProductController::edit/0');
    $routes->match(['get', 'post'], 'edit/(:num)', 'ProductController::edit/$1');
    $routes->match(['get', 'post'], 'delete/(:num)', 'ProductController::delete/$1');
    $routes->get('view/(:num)', 'ProductController::view/$1');
});

$routes->group('bills', function($routes) {
    $routes->get('', 'BillController::index');
    $routes->match(['get', 'post'], 'generate', 'BillController::generate');
    $routes->match(['post'], 'process', 'BillController::process');
    $routes->match(['get', 'post'], 'add', 'BillController::edit/0');
    $routes->match(['get', 'post'], 'edit/(:num)', 'BillController::edit/$1');
    $routes->match(['get', 'post'], 'delete/(:num)', 'BillController::delete/$1');
    $routes->get('view/(:num)', 'BillController::view/$1');
});

$routes->group('reports', function($routes) {
    $routes->get('cost', 'ReportController::cost');
    $routes->get('paid-bills', 'ReportController::paidBills');
    $routes->get('unpaid-bills', 'ReportController::unpaidBills');
});

$routes->group('users', function($routes) {
    $routes->get('', 'UserController::index');
    $routes->match(['get', 'post'], 'edit/(:num)', 'UserController::edit/$1');
    $routes->match(['get', 'post'], 'profile', 'UserController::profile');
    $routes->match(['get', 'post'], 'delete/(:num)', 'UserController::delete/$1');
});

$routes->group('user-groups', function($routes) {
    $routes->get('', 'UserGroupController::index');
    $routes->match(['get', 'post'], 'edit/(:num)', 'UserGroupController::edit/$1');
    $routes->get('delete/(:num)', 'UserGroupController::delete/$1');
});

$routes->group('system', function($routes) {
    $routes->match(['get', 'post'], 'settings', 'SystemController::settings');
});

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
