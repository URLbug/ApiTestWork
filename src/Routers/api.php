<?php

/**
 * Если кратко то тут идет создание роутеров 
 */

namespace Routers;

use Controllers\ApiController;

$router = new Router;

$router->add('GET', '/api/v1/users', [ApiController::class, 'getUser']);
$router->add('POST', '/api/v1/users/regs', [ApiController::class, 'makeUser']);
$router->add('POST', '/api/v1/users/auth', [ApiController::class, 'authUser']);

 
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$router->dispatch($path); 