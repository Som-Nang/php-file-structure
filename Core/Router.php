<?php
namespace Core;


use Core\Middleware\Auth;
use Core\Middleware\Guest;
use Core\Middleware\Middleware;

Class Router{
    protected $routes = [];

    public function add($method, $uri, $controller): Router
    {
        $this->routes[] = [
            'uri' => $uri,
            'controller' => $controller,
            'method' => $method,
            'middleware' => null
        ];

//        The same above
//        $this->routes[] = compact('method', 'uri', 'controller');
        return $this;
    }


    public function get($uri, $controller)
    {
       return $this->add('GET', $uri, $controller);
    }
    public function post($uri, $controller)
    {
        return $this->add('POST', $uri, $controller);

    }

    public function delete($uri, $controller)
    {
        return $this->add('DELETE', $uri, $controller);
    }

    public function patch($uri, $controller)
    {
        return $this->add('PATCH', $uri, $controller);
    }

    public function put($uri, $controller)
    {
        return $this->add('PUT', $uri, $controller);

    }

    public function only($key)
    {
      $this->routes[array_key_last($this->routes)]['middleware'] = $key;

       return $this;
    }

    /**
     * @throws \Exception
     */
//    public function route($uri, $method)
//    {
//        foreach($this->routes as  $route){
//            if($route['uri'] === $uri && $route['method'] === strtoupper($method)){
//
//                Middleware::resolve($route['middleware']);
//
//
//                return require base_path('/Http/Controllers/'.$route['controller']);
//            }
//        }
//
//        $this->abort();
//    }

    public function route($uri, $method)
    {
        foreach ($this->routes as $route) {
            if ($route['uri'] === $uri && $route['method'] === strtoupper($method)) {

                // Middleware handling if needed
                if (isset($route['middleware'])) {
                    Middleware::resolve($route['middleware']);
                }

                if (!isset($route['controller']) || strpos($route['controller'], '@') === false) {
                    $this->abort(500); // Internal server error due to malformed route definition
                }
                // Break down controller and method
                list($controller, $action) = explode('@', $route['controller']);

                // Ensure the controller class exists
                $controllerClass = 'Http\Controllers\\' . $controller;
                if (!class_exists($controllerClass)) {
                    $this->abort(404); // Not found
                }
                // Instantiate the controller
                $controllerInstance = new $controllerClass();
                // Ensure the method exists on the controller
                if (!method_exists($controllerInstance, $action)) {
                    $this->abort(404); // Method not found
                }

                // Call the action method
                return call_user_func_array([$controllerInstance, $action], []);
            }
        }

        $this->abort(); // Default abort if no route matches
    }

    public function previousUrl(){
        return $_SERVER['HTTP_REFERER'];
    }

    protected function abort($code = 404)
    {
        http_response_code(404);

        require base_path("views/{$code}.php");

        die();
    }
}



