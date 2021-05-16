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
//$routes->setDefaultController('Home');
$routes->setDefaultController('Users');
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
//$routes->get('/', 'Home::index');
//$routes->get('/', 'Users::index');
$routes->get('/', 'Pages::view/about', ['filter' => 'noauth']);
$routes->get('users', 'Users::index', ['filter' => 'noauth']);
$routes->get('users/logout', 'Users::logout');
$routes->match(['get','post'],'users/register', 'Users::register', ['filter' => 'noauth']);
$routes->match(['get','post'],'users/profile', 'Users::profile',['filter' => 'auth']);
$routes->get('users/dashboard', 'Dashboard::index',['filter' => 'auth']);





// here we add our routes - CL 18.4.21
$routes->match(['get', 'post'], 'news/create', 'News::create'); // for routing to page creating new articles in news
$routes->match(['get', 'post'], 'news/delete_news_article/(:segment)', 'News::delete_news_article/$1'); // for routing to controller responsible for deletion
$routes->match(['get', 'post'], 'news/update_news_article/(:segment)', 'News::update_news_article/$1'); // for routing to controller responsible for news article update

//gustbook routing
$routes->match(['get', 'post'], 'guestbook/guestbook_add_post', 'Guestbook::guestbook_add_post'); // for routing to controller responsible for news article update
$routes->match(['get', 'post'], 'guestbook/delete_guestbook_article/(:segment)', 'Guestbook::delete_guestbook_article/$1'); // for routing to controller responsible for deletion
//$routes->get( 'pages/delete_guestbook_article/(:segment)', 'Pages::delete_guestbook_article/$1'); // for routing to controller responsible for deletion
$routes->match(['get', 'post'], 'guestbook/update_guestbook_article/(:segment)', 'Guestbook::update_guestbook_article/$1'); // for routing to controller responsible for news article update

//contact us routing - CL 9.5.2021
$routes->match(['get', 'post'], 'contactus/contactus_add_post', 'Contactus::contactus_add_post'); // for routing to controller responsible for news article update
$routes->match(['get', 'post'], 'contactus/delete_contactus_article/(:segment)', 'Contactus::delete_contactus_article/$1'); // for routing to controller responsible for deletion
//$routes->get( 'pages/delete_guestbook_article/(:segment)', 'Pages::delete_guestbook_article/$1'); // for routing to controller responsible for deletion
$routes->match(['get', 'post'], 'contactus/update_contactus_article/(:segment)', 'Contactus::update_contactus_article/$1'); // for routing to controller responsible for news article update

$routes->get('news/(:segment)', 'News::view/$1');  // for routing to news implemented along provided tutorial of code igniter
$routes->get('public/guestbook_single_view(:segment)', 'Pages:guestbook_single_view/$1');  // for routing to news implemented along provided tutorial of code igniter

// personal part for loged in users - users
//$routes->get('logout', 'Users::logout');
//$routes->match(['get','post'],'users/register', 'Users::register');
//$routes->match(['get','post'],'users/register', 'Users::register');
//$routes->match(['get','post'],'users/profile', 'Users::profile');
//$routes->get('dashboard', 'Dashboard::index');

//$routes->get('/', 'Users::index', ['filter' => 'noauth']);
//$routes->get('users', 'Users::index');


$routes->get('news', 'News::index');
$routes->get('guestbook', 'Guestbook::index');
$routes->get('contactus', 'Contactus::index');

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
