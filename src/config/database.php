<?php

namespace config;

use PDO;

class DB
{
    public PDO $pdo;

    function __construct() 
    {
        $env = parse_ini_file(__DIR__ . '/../.env');

        $dsn = 'mysql:host=' . $env['HOST'] . ';' . 'dbname=' . $env['DATABASE'] . ';charset=' . $env['CHARSET'];
        
        $opt = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        
        $this->pdo = new PDO($dsn, $env['USER'], $env['PASSWORD'], $opt); 
    }
}
