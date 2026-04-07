<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->group('auth', function($routes)
{
    $routes->get('login',    'Auth::loginForm',    ['as' => 'loginForm']);
    $routes->get('register', 'Auth::registerForm', ['as' => 'registerForm']);
    $routes->get('forget',   'Auth::forget',       ['as' => 'forgetForm']);
    $routes->get('profile',  'Auth::profile',      ['as' => 'profile']);
    $routes->get('settings', 'Auth::settings',     ['as' => 'settings']);
    $routes->get('logout',   'Auth::logout',       ['as' => 'logout']);

    $routes->post('login',    'Auth::loginProcess',    ['as' => 'loginProcess']);
    $routes->post('register', 'Auth::registerProcess', ['as' => 'registerProcess']);
});

$routes->group('services', function($routes)
{
    $routes->get('geolocation',  'Api::geolocation', ['as' => 'apiGeolocationGet']);
    $routes->post('geolocation', 'Api::geolocation', ['as' => 'apiGeolocationPost']);

    $routes->get('telegram',  'Api::telegram', ['as' => 'apiTelegramGet']);
});

$routes->group('admin', ['filter' => 'role:admin'], function($routes)
{
    $routes->get('create',         'Levels::create',    ['as' => 'createLevel']);
    $routes->get('read',           'Levels::read',      ['as' => 'readLevel']);
    $routes->get('delete/(:num)',  'Levels::delete/$1', ['as' => 'deleteLevel']);
    $routes->get('update/(:num)',  'Levels::update/$1', ['as' => 'updateLevel']);

    $routes->post('apiCreate',      'Levels::apiCreate', ['as' => 'apiCreate']);
    $routes->post('apiDelete',      'Levels::apiDelete', ['as' => 'apiDelete']);

    $routes->get('dashboard', 'Admin::index', ['as' => 'adminDashboard']);
    $routes->get('users', 'Admin::usersIndex', ['as' => 'adminUsers']);
    $routes->post('users', 'Admin::usersCreate', ['as' => 'adminUsersCreate']);
    $routes->get('users/read', 'Admin::usersRead', ['as' => 'adminUsersRead']);
    $routes->post('users/apiCreate', 'Admin::apiUsersCreate', ['as' => 'adminUsersApiCreate']);
    $routes->post('users/apiDelete', 'Admin::apiUsersDelete', ['as' => 'adminUsersApiDelete']);
    $routes->post('pending/approve/(:num)', 'Admin::approvePendingUser/$1', ['as' => 'adminPendingApprove']);
    $routes->get('users/edit/(:num)', 'Admin::usersEdit/$1', ['as' => 'adminUsersEdit']);
    $routes->post('users/edit/(:num)', 'Admin::usersUpdate/$1', ['as' => 'adminUsersUpdate']);
    $routes->get('users/delete/(:num)', 'Admin::usersDelete/$1', ['as' => 'adminUsersDelete']);
    $routes->get('levels', 'Admin::levelsIndex', ['as' => 'adminLevels']);
    $routes->post('levels', 'Admin::levelsCreate', ['as' => 'adminLevelsCreate']);
    $routes->get('levels/edit/(:num)', 'Admin::levelsEdit/$1', ['as' => 'adminLevelsEdit']);
    $routes->post('levels/edit/(:num)', 'Admin::levelsUpdate/$1', ['as' => 'adminLevelsUpdate']);
    $routes->get('levels/delete/(:num)', 'Admin::levelsDelete/$1', ['as' => 'adminLevelsDelete']);
});

// Estas rutas son exclusivas del profesor y usan un prefijo propio
// para que la URL sea mas clara: /docente/dashboard
$routes->group('docente', ['filter' => 'role:docente'], function($routes)
{
    $routes->get('dashboard', 'Admin::docente', ['as' => 'docenteDashboard']);
});

// Estas rutas son exclusivas del alumno y tambien usan su propio prefijo
// para mantener una estructura limpia: /alumno/dashboard
$routes->group('alumno', ['filter' => 'role:alumno'], function($routes)
{
    $routes->get('dashboard', 'Admin::alumno', ['as' => 'alumnoDashboard']);
});
