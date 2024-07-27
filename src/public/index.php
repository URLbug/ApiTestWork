<?php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../config/migration/make.php';

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