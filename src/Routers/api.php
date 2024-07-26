<?php

/**
 * Если кратко то тут идет создание роутеров 
 */

namespace Routers;

use Controllers\ApiController;

$router = new Router;

$router->add('GET', '/home', [ApiController::class, 'home']);
 
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$router->dispatch($path); 