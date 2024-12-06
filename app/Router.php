<?php

namespace App;

class Router
{
    private $routes;
    private $container;

    public function __construct($container)
    {
        // Store the container for dependency resolution
        $this->container = $container;

        $this->routes = require __DIR__ . '/routes.php';
    }

    public function load(string $uri, ?string $type = 'GET', ?array $params = null)
    {
        if (!isset($this->routes[$uri])) {
            header('HTTP/1.0 404 Not Found');
            exit();
        }

        $match = false;

        foreach ($this->routes[$uri] as $route) {
            if ($route['type'] == $type) {
                [$controller, $method] = explode('@', $route['handler']);
                $controller = sprintf('App\Controller\%s', $controller);

                // Resolve the controller with the container
                $controllerInstance = $this->container->resolve($controller);

                // Call the method on the controller instance
                $controllerInstance->{$method}($params);
                $match = true;
                break;
            }
        }

        if (!$match) {
            header('HTTP/1.0 405 Method Not Allowed');
        }
    }
}
