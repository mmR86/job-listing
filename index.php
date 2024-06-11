<?php

$routes = require './routes.php';


$uri = $_SERVER['REQUEST_URI'];

echo $uri;
echo '<br>';
echo '<br>';
if(array_key_exists($uri, $routes)){
    require __DIR__ . '/' . $routes[$uri];  
} else {
    require __DIR__ . '/' . $routes['404'];
}