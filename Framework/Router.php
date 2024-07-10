<?php

namespace Framework;

use App\Controllers\ErrorController;
use Framework\Middleware\Authorize;

class Router {
    protected $routes = [];

    public function registerRoute($method, $uri, $action, $middleware = []) {
        list($controller, $controllerMethod) = explode('@', $action);

        $this->routes[] = [
            'method' => $method,
            'uri' => $uri,
            'controller' => $controller,
            'controllerMethod' => $controllerMethod,
            'middleware' => $middleware
        ];
    }

    /**
     * Add a GET route
     * 
     * @param string $uri
     * @param string $controller
     * @param array $middleware
     * @return void
     */
    public function get($uri, $controller, $middleware = []) {
        $this->registerRoute('GET', $uri, $controller, $middleware);
    }

    /**
     * Add a POST route
     * @param string $uri
     * @param string $controller
     * @param array $middleware
     * @return void
     */
    public function post($uri, $controller, $middleware = []) {
        $this->registerRoute('POST', $uri, $controller, $middleware);
    }

    /**
     * Add a PUT route
     * @param string $uri
     * @param string $controller
     * @param array $middleware
     * @return void
     */
    public function put($uri, $controller, $middleware = []) {
        $this->registerRoute('PUT', $uri, $controller, $middleware);
    }

    /**
     * Add a DELETE route
     * @param string $uri
     * @param string $controller
     * @param array $middleware
     * @return void
     */
    public function delete($uri, $controller, $middleware = []) {
        $this->registerRoute('DELETE', $uri, $controller, $middleware);
    }

    /**
     * Route the request
     * @param string $uri
     * @param string $method
     * @return void
     */
    public function route($uri) {
        //get current http method
        $requestMethod = $_SERVER['REQUEST_METHOD'];

        if($requestMethod === 'POST' && isset($_POST['_method'])) {
            // Overide request method with the value of _method, which is hidden and represent "DELETE"
            $requestMethod = strtoupper($_POST['_method']);
        }

        foreach($this->routes as $route) {
            
            //Split the current uri into segments
            $uriSegments = explode('/', trim($uri, '/'));

            //Split the route uri into segments
            $routeSegments = explode('/', trim($route['uri'], '/'));

            $match = true;

            //Check if the number of segments matches
            if(count($uriSegments) === count($routeSegments) && strtoupper($route['method'] === $requestMethod)) {

                $params = [];

                $match = true;

                for($i = 0; $i < count($uriSegments); $i++) {
                    //if the uris do not match and there is no param
                    if($routeSegments[$i] !== $uriSegments[$i] && !preg_match('/\{(.+?)\}/', $routeSegments[$i])) {

                    $match = false;
                    break;
                    }
                    //Check for the param and add to $params array
                    if(preg_match('/\{(.+?)\}/', $routeSegments[$i], $matches)) {
                    $params[$matches[1]] = $uriSegments[$i];
                    }
                }

                if($match) {
                    // na svakom middleware koji je ubačen u array pozove handle koji čekira da li je user logiran ili da li ima neki middleware za autorizaciju općenito
                    foreach($route['middleware'] as $middleware) {
                        (new Authorize())->handle($middleware);
                    }
                    //Extract controller and controller method
                    $controller = 'App\\Controllers\\' . $route['controller'];
                    $controllerMethod = $route['controllerMethod'];
    
                    //Instatiate the controller and call the method
                    $controllerInstance = new $controller();
                    $controllerInstance->$controllerMethod($params);
                    return;
                }   
            }  
        }
        ErrorController::notFound();
    }
}

