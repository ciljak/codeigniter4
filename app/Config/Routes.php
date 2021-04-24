<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php'))
{
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');

// here we add our routes - CL 18.4.21
$routes->match(['get', 'post'], 'news/create', 'News::create'); // for routing to page creating new articles in news

$routes->get('news/(:segment)', 'News::view/$1');  // for routing to news implemented along provided tutorial of code igniter
$routes->get('news', 'News::index');

$routes->get('(:any)', 'Pages::view/$1'); // added after rework for common pages handling along manual page https://codeigniter.com/user_guide/tutorial/static_pages.html, 24.4.21
    // after this update we dont need type /public/pages/vieww/name_of_page but only /public/name_of_the_pge
//$routes->add('about', 'About::index');
//$routes->add('contact', 'Contact::index');
//$routes->add('guestbook', 'Guestbook::index');


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
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php'))
{
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
