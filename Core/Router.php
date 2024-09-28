<?php
namespace Core;
Class Router{
    protected $routes = [];

    public function add($method, $uri, $controller, $func): Router
    {
//        $this->routes[] = [
//            'uri' => $uri,
//            'controller' => $controller,
//            'method' => $method
//        ];

//        The same above
        $this->routes[] = compact('method', 'uri', 'controller', 'func');
        return $this;
    }
    public function get($uri, $controller)
    {
       $this->add('GET', $uri, $controller);
    }
    public function post($uri, $controller)
    {
        $this->add('POST', $uri, $controller);

    }

    public function delete($uri, $controller)
    {
        $this->add('DELETE', $uri, $controller);
    }

    public function patch($uri, $controller)
    {
        $this->add('PATCH', $uri, $controller);
    }

    public function put($uri, $controller)
    {
        $this->add('PUT', $uri, $controller);

    }

    public function route($uri, $method, $func)
    {
        foreach($this->routes as  $route){
            if($route['uri'] === $uri && $route['method'] === strtoupper($method)){
                return require base_path($route['controller']);
            }
        }

        $this->abort();
    }

    protected function abort($code = 404)
    {
        http_response_code(404);

        require base_path("views/{$code}.php");

        die();
    }
}



