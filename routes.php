<?php


$router->get('/', 'HomeController@index');
$router->get('/listings', 'ListingController@index');
$router->get('/listings/create', 'ListingController@create', ['auth']);
$router->get('listings/search', 'ListingController@search');
// $router->get('/listing', 'ListingController@show');
//instead of passing id through a get variable, we add a param, thats how its done in laravel
$router->get('/listings/{id}', 'ListingController@show');
$router->delete('/listings/{id}', 'ListingController@destroy', ['auth']);
$router->post('/listings', 'ListingController@store', ['auth']);
$router->get('/listings/edit/{id}', 'ListingController@edit', ['auth']);
$router->put('/listings/{id}', 'ListingController@update', ['auth']);
$router->get('auth/register', 'UserController@create', ['guest']);
$router->get('auth/login', 'UserController@login', ['guest']);
$router->post('auth/register', 'UserController@store', ['guest']);
$router->post('auth/logout', 'UserController@logout', ['auth']);
$router->post('auth/login', 'UserController@authenticate', ['guest']);


