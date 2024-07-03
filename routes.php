<?php


$router->get('/', 'HomeController@index');
$router->get('/listings', 'ListingController@index');
$router->get('/listings/create', 'ListingController@create');
// $router->get('/listing', 'ListingController@show');
//instead of passing id through a get variable, we add a param, thats how its done in laravel
$router->get('/listing/{id}', 'ListingController@show');
// $router->get('/listings', 'controllers/listings/index.php');
// $router->get('/listings/create', 'controllers/listings/create.php');
// $router->get('/listing', 'controllers/listings/show.php');
