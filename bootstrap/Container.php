<?php
use App\Container;
use App\Repository\CompanyMatcherRepository;
use App\Service\CompanyMatcherService;
use App\Config\Database; 

$container = new Container();

// Bind Database Connection (singleton)
$container->bind(Database::class, function () {
    return Database::getInstance(); // Return the singleton instance of Database Connection
});

// Bind repositories
$container->bind(CompanyMatcherRepository::class, function ($container) {
    $db = $container->resolve(Database::class); // Resolve the Database connection instance
    return new CompanyMatcherRepository($db);
});

// Bind services
$container->bind(CompanyMatcherService::class, function ($container) {
    return new CompanyMatcherService($container->resolve(CompanyMatcherRepository::class));
});

// Bind controllers
$container->bind(App\Controller\FormController::class, function ($container) {
    return new \App\Controller\FormController($container->resolve(CompanyMatcherService::class));
});

return $container;
