# EasyRouter

**About**

This is a Easy Router component.
Have automatic class loader.
Runs the controller or file registered in the routes array according to the current uri

**Installation**

Just download and include the library to your project.

```
include 'src/EasyRouter.php';
use Suvarivaza\ER\EasyRouter; // use namespace EasyRouter
```

**Usage**

1. First, let's create an array with routes and register them.
2. Create an object of the EasyRouter class.
3. Execute the RUN method.


Example:

```

$routes = [
    '/' => [
        'controller' => 'HomeController', // You can specify the controller that will handle the request.
        'path' => 'controllers/' // And specify the path to the controller
    ],
    '/posts/' => [
        'file' => 'posts.php', // You can specify the file to which the request will be redirected.
        'path' => 'public/' // And specify the path to the handler file
    ],
    '/posts/show' => [
        'controller' => 'PostsController/show', // Also you can optionally specify the controller method
        'path' => 'controllers/'
    ],
    '/posts/edit' => [
        'controller' => 'PostsController/edit', // controller method
        'path' => 'controllers/'
    ],
    '/404' => [
        'file' => '404.php', //you can specify the path to your custom 404 file
        'path' => 'public/'
    ]
];

$router = new EasyRouter();
$router->run($routes, $_SERVER['REQUEST_URI']);

```

Method RUN gets two arguments: 
$router | array 
$uri | string

It's all! Enjoy!
