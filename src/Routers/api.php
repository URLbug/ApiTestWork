<?php

require_once __DIR__ . '/Router.php';
require_once __DIR__ . '/../Controllers/ApiController.php';

/**
 * Если кратко то тут идет создание роутеров 
 */

$router = new Router;

$router->add('GET', '/home', [ApiController::class, 'home']);
 
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$router->dispatch($path); 