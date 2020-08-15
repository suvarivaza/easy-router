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

                if(isset($route['file'])){
                    include $route['path'] . $route['file'];
                    exit;
                }

                $this->path = $route['path'];
                $param = explode('/', $route['controller']);
                $controller = $param[0];
                if(isset($param[1])) $method = $param[1];

                if (class_exists($controller)) {
                    $controllerObject = new $controller;
                    if(isset($method)){
                        if(method_exists($controller, $method)){
                            $controllerObject->{$method}();
                        } else{
                            throw new \Exception("Не удалось загрузить метод: {$route['method']} класса $controller", 500);
                        }
                    }
                    exit;
                } else {
                    throw new \Exception("Не удалось загрузить класс: $controller", 500);
                }
            } else {
                if(isset($routes['/rakhim_oop3/404'])){

                    include $routes['/rakhim_oop3/404']['path'] . $routes['/rakhim_oop3/404']['file'];
                    exit;
                }
                throw new \Exception('Страница не найдена 404', 404);
            }
        } catch (\Exception $e ){
            echo $e->getMessage();
        }
    }
}