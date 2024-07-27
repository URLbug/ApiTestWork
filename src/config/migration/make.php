<?php

namespace config;

use Models\Model;

class Migration
{
    function make()
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
}