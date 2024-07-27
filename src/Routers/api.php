<?php

/**
 * Если кратко то тут идет создание роутеров 
 */

namespace Routers;

use Controllers\ApiController;

$router = new Router;

$router->add('GET', '/api/v1/users', [ApiController::class, 'getUsers']);
$router->add('POST', '/api/v1/users', [ApiController::class, 'makeUsers']);

 
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$router->dispatch($path); 