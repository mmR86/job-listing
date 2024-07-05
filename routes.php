<?php


$router->get('/', 'HomeController@index');
$router->get('/listings', 'ListingController@index');
$router->get('/listings/create', 'ListingController@create');
// $router->get('/listing', 'ListingController@show');
//instead of passing id through a get variable, we add a param, thats how its done in laravel
$router->get('/listings/{id}', 'ListingController@show');
$router->delete('/listings/{id}', 'ListingController@destroy');
$router->post('/listings', 'ListingController@store');
