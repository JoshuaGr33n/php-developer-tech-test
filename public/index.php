<?php

require __DIR__ . '/../bootstrap/init.php';

// Include the container configuration and instantiate the container
$container = require __DIR__ . '/../bootstrap/container.php';

$router = new App\Router($container);
$router->load($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);