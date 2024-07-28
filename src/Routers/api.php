<?php

/**
 * Если кратко то тут идет создание роутеров 
 */

namespace Routers;

use Controllers\ApiController;

$router = new Router;

$router->add(
    'GET', 
    '/api/v1/users', 
    [ApiController::class, 'getUser']
);
$router->add(
    'POST', 
    '/api/v1/users/make', 
    [ApiController::class, 'makeUser']
);
$router->add(
    'POST', 
    '/api/v1/users', 
    [ApiController::class, 'authUser']
);
$router->add(
    'PATCH', 
    '/api/v1/users', 
    [ApiController::class, 'updateUser']
);
$router->add(
    'DELETE', 
    '/api/v1/users', 
    [ApiController::class, 'deleteUser']
);

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$router->dispatch($path); 