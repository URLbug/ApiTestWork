<?php

namespace config\migration;

use Models\Model;
use PDOException;

class Migration
{
    static function make()
    {
        try
        {
            $model = new Model('users');

            $model->create([
                'usersId INT AUTO_INCREMENT',
                'name VARCHAR(30)',
                'password VARCHAR(250)',
                'age INT',
                'PRIMARY KEY(usersId)',
            ]);
        }
        catch(PDOException $ex)
        {
            echo $ex->getMessage();
        }
    }
}
