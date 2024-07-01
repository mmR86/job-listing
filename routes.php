<?php


$router->get('/', 'App/controllers/home.php');
$router->get('/listings', 'App/controllers/listings.php');
$router->get('/listings/create', 'App/controllers/create.php');
$router->get('/listing', 'App/controllers/show.php');
