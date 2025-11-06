<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Page::index');
//$routes->get('/', 'Auth::login');

$routes->get('perfil/vista', 'Perfil::vista'); // para cargar layout con Vue


//perfil
$routes->get('perfil/', 'Perfil::index');          // listar todos
$routes->get('perfil/edit/(:num)', 'Perfil::edit/$1'); // obtener uno
$routes->post('perfil/add', 'Perfil::add');           // crear nuevo
$routes->put('perfil/update/(:num)', 'Perfil::update/$1'); // actualizar
$routes->delete('perfil/delete/(:num)', 'Perfil::delete/$1'); // eliminar

//cursos
$routes->get('/curso', 'Curso::index');
$routes->get('/curso/edit/(:num)', 'Curso::edit/$1');
$routes->post('/curso/update/(:num)', 'Curso::update/$1');
$routes->post('/curso/create', 'Curso::create');
$routes->get('/curso/delete/(:num)', 'Curso::delete/$1');
$routes->group('', ['filter' => 'auth'], static function($routes) {
    $routes->get('dashboard/curso/(:num)', 'Dashboard::curso/$1', ['as' => 'dashboard_curso']);
});


//modulos
$routes->get('/modulo/index/(:num)', 'Modulo::index/$1');
$routes->get('/modulo/edit/(:num)', 'Modulo::edit/$1');
$routes->post('/modulo/update/(:num)', 'Modulo::update/$1');
$routes->post('/modulo/create', 'Modulo::create');
$routes->get('/modulo/delete/(:num)', 'Modulo::delete/$1');

//preguntas
$routes->get('/preguntas/index/(:num)', 'Preguntas::index/$1');
$routes->get('/preguntas/edit/(:num)', 'Preguntas::edit/$1');
$routes->post('/preguntas/update/(:num)', 'Preguntas::update/$1');
$routes->post('/preguntas/create', 'Preguntas::create');
$routes->get('/preguntas/delete/(:num)', 'Preguntas::delete/$1');

//contenidos
$routes->get('/contenido/index/(:num)', 'Contenido::index/$1');
$routes->get('/contenido/edit/(:num)', 'Contenido::edit/$1');
$routes->post('/contenido/update/(:num)', 'Contenido::update/$1');
$routes->post('/contenido/create', 'Contenido::create');
$routes->get('/contenido/delete/(:num)', 'Contenido::delete/$1');

//idioma
$routes->get('idioma/(:segment)', 'Idioma::cambiar/$1');



//usuarios

$routes->get('/auth/login', 'Auth::login');
$routes->post('/auth/acceder', 'Auth::acceder');
$routes->get('/auth/logout', 'Auth::logout');
$routes->get('/dashboard', 'Dashboard::index'); // protegido

//registro
$routes->get('/aunt/registrer', 'Registrer::');

//page

$routes->get('curso/(:num)', 'Page::curso/$1');
$routes->get('curso/inscribirse/(:num)', 'Curso::inscribirse/$1');


