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
// $routes->get('/', 'Home::index');

// $routes->get('/user', 'User::index');
$routes->get('/', 'Home::index');
$routes->get('/user', 'User::index');
$routes->get('/user/edit', 'User::editProfile');
$routes->post('/user/update/(:num)', 'User::updateMyProfile/$1');
$routes->post('/user/generate/(:num)', 'User::generateKeyAES/$1');

// My Diary (Admin)
$routes->get('/admin/diary', 'Diary::index', ['filter' => 'role:admin']);
$routes->get('/admin/diary/delete/(:num)', 'Diary::deleteDiary/$1', ['filter' => 'role:admin']);
$routes->get('/admin/diary/edit/(:num)', 'Diary::editDiary/$1', ['filter' => 'role:admin']);
$routes->post('/admin/diary/update/(:num)', 'Diary::updateDiary/$1', ['filter' => 'role:admin']);

// My Diary (User)
$routes->get('/user/diary', 'Diary::diaryIndex', ['filter' => 'role:user']);
$routes->get('/user/diary/edit/(:num)', 'Diary::editDiaryUser/$1', ['filter' => 'role:user']);
$routes->post('/user/diary/update/(:num)', 'Diary::updateDiaryUser/$1', ['filter' => 'role:user']);
$routes->post('/user/verify/key/(:num)', 'Diary::verifyKey/$1', ['filter' => 'role:user']);
$routes->get('/user/diary/create', 'Diary::createDiary', ['filter' => 'role:user']);
$routes->post('/user/diary', 'Diary::insertDiary', ['filter' => 'role:user']);



// Manage Users
$routes->get('/admin', 'Admin::index', ['filter' => 'role:admin']);
$routes->get('/admin/create', 'Admin::addView', ['filter' => 'role:admin']);
$routes->get('/admin/index', 'Admin::index', ['filter' => 'role:admin']);

$routes->get('/admin/edit/(:num)', 'Admin::editUser/$1', ['filter' => 'role:admin']);
$routes->post('/admin/update/(:num)', 'Admin::updateUser/$1', ['filter' => 'role:admin']);


$routes->get('/admin/delete/(:num)', 'Admin::deleteUser/$1', ['filter' => 'role:admin']);
$routes->get('/admin/(:num)', 'Admin::details/$1', ['filter' => 'role:admin']);



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
