<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// var_dump($_SERVER);
// die();

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../config/migration/Migration.php';

require_once __DIR__ . '/../Models/Model.php';

$files = glob(__DIR__ . '/../Model/*.php');

foreach ($files as $file) {
    require_once $file;   
}

require_once  __DIR__ . '/../Controllers/Controller.php';

$files = glob(__DIR__ . '/../Controllers/*.php');

foreach ($files as $file) {
    require_once $file;   
}

require_once __DIR__ . '/../Routers/Router.php';
require_once __DIR__ . '/../Routers/api.php';