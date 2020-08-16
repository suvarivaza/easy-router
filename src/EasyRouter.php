<?php

namespace Suvarivaza\ER;


class EasyRouter
{
    protected $path;

    /*
     * Automatic class loader.
     * Runs the controller or file registered in the $routes array according to the current $uri
     * @param array $routes
     * @param string $uri
     */
    public function run($routes, $uri)
    {

        //class autoloader
        spl_autoload_register(function($class){
            if(is_file("{$this->path}{$class}.php")){
                include "{$this->path}{$class}.php";
            } else {
                die("file {$this->path}{$class}.php not found");
            }
        });


        try{

            if(array_key_exists($uri, $routes)){

                $route = $routes[$uri];

                // if a handler file is specified in routes
                // check file exists and include file
                if(isset($route['file'])){
                    if(file_exists ( $route['path'] . $route['file'] )){
                        include $route['path'] . $route['file'];
                        exit;
                    }
                }

                // if a class or method is specified in the routes
                $this->path = $route['path'];
                $param = explode('/', $route['controller']);
                $controller = $param[0];
                if(isset($param[1])) $method = $param[1];

                // if class exists create new object same class
                if (class_exists($controller)) {
                    $controllerObject = new $controller;
                    // if method exists call this method
                    if(isset($method)){
                        if(method_exists($controller, $method)){
                            $controllerObject->{$method}();
                        } else{
                            throw new \Exception("Failed to load method: {$controller}/{$route['method']}");
                        }
                    }
                    exit;
                } else {
                    throw new \Exception("Failed to load class: $controller");
                }
            } else {
                // if page 404 is specified
                if(isset($routes['/404'])){
                    if(file_exists ( $routes['/404']['path'] . $routes['/404']['file'] )) {
                        include $routes['/404']['path'] . $routes['/404']['file'];
                        exit;
                    }
                }
                throw new \Exception('Page not found 404', 404);
            }
        } catch (\Exception $e ){
            echo $e->getMessage();
        }
    }
}
