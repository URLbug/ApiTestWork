<?php

namespace Controllers;

use Models\Model;

class ApiController extends Controller
{
    function getUsers(): string
    {
        $model = new Model('users');

        $datas = $model->select(['name', 'age',]);

        return $this->json($datas);
    }

    function makeUsers(): string
    {
        $names = [];

        if(isset(
            $_GET['name'], 
            $_GET['password'], 
            $_GET['age'])
        ) {
            $model = new Model('users');

            $users = $model->select(['name']);

            foreach($users as $user)
            {
                $names[] = $user['name'];
            }

            if(!in_array($_GET['name'], $names))
            {
                $datas = $model->insert([
                    $_GET['name'], 
                    $_GET['password'], 
                    $_GET['age'],
                ]);

                if($datas)
                {
                    http_response_code(201);

                    return $this->json([
                        'code' => 201,
                        'message' => 'Пользователь создан!',
                    ]);
                }
            }
        }

        http_response_code(400);

        return $this->json([
            'code' => 400,
            'message' => 'Не удалось создать пользователя!',
        ]);
    }
}