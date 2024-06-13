<?php

require '../helpers.php';
$routes = require basePath('routes.php');


$uri = $_SERVER['REQUEST_URI'];

if(array_key_exists($uri, $routes)){
    require basePath($routes[$uri]);
} else {
    require basePath($routes['404']);
}