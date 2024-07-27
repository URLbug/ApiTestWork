<?php

namespace Controllers;

use Models\Model;

class ApiController extends Controller
{
    function getUser(): string
    {
        $model = new Model('users');

        $user = $model->where(
            ['name', 'age'],
            'session = ' . '"' . $_SERVER['HTTP_COOKIE'] . '"'
        );

        if($user === [])
        {
            http_response_code(401);

            return $this->json([
                'code' => 401,
                'message' => 'Пользователь не авторизован!',
            ]); 
        }

        http_response_code(200);

        return $this->json($user);
    }

    function authUser(): string
    {
        if(!isset(
            $_GET['name'], 
            $_GET['password']
            )
        ) {
            http_response_code(400);
        
            return $this->json([
                'code' => 400,
                'message' => 'Не удалось авторизироваться!',
            ]);
        }

        $password = hash('sha256', $_GET['password']);

        $model = new Model('users');

        $user = $model->where(
            ['name'],
            'name = ' . '"' . htmlspecialchars($_GET['name']) . 
            '" AND password = ' . '"' . htmlspecialchars($password) . '";'
        );

        if($user === [])
        {
            http_response_code(400);
        
            return $this->json([
                'code' => 400,
                'message' => 'Не удалось авторизироваться!',
            ]);
        }

        http_response_code(200);
        
        return $this->json([
            'code' => 200,
            'message' => 'Удалось аворизироваться!',
        ]);
    }

    function makeUser(): string
    {
        if(isset(
            $_GET['name'], 
            $_GET['password'], 
            $_GET['age'])
        ) {
            $model = new Model('users');

            $users = $model->where(
                ['name'],
                'name = ' . '"' . htmlspecialchars($_GET['name']) . '"'
            );

            if($users === [])
            {
                $password = hash('sha256', $_GET['password']);

                $datas = $model->insert([
                    $_GET['name'], 
                    $password, 
                    $_GET['age'],
                    $_SERVER['HTTP_COOKIE']
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

    function deleteUser(): string
    {
        return $this->json(['1' => '2']);
    }

    function updateUser(): string
    {
        return $this->json(['1' => '2']);
        
    }
}