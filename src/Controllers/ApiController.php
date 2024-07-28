<?php

namespace Controllers;

use Models\Model;

class ApiController extends Controller
{
    function getUser(): string
    {
        $data = $this->isAuth();

        if($data['isAuth'])
        {
            http_response_code(401);

            return $this->json([
                'code' => 401,
                'message' => 'Пользователь не авторизован!',
            ]); 
        }

        http_response_code(200);

        return $this->json($data['data']);
    }

    function authUser(): string
    {
        $data = $this->isRequests();

        if(!$data['isRequests'])
        {
            http_response_code($data['json']['code']);

            return $data['json'];
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
            http_response_code(401);
        
            return $this->json([
                'code' => 401,
                'message' => 'Не удалось авторизироваться!',
            ]);
        }

        $this->updateSession($_GET['name']);

        http_response_code(200);
        
        return $data['json'];
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
                session_start();
                
                $password = hash('sha256', $_GET['password']);

                $datas = $model->insert([
                    $_GET['name'], 
                    $password, 
                    $_GET['age'],
                    session_id(),
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
        $data = $this->isRequests();

        if(!$data['isRequests'])
        {
            http_response_code($data['json']['code']);

            return $data['json'];
        }

        $data = $this->isAuth();

        if($data['isAuth'])
        {
            http_response_code(401);

            return $this->json([
                'code' => 401,
                'message' => 'Пользователь не авторизован!',
            ]); 
        }

        http_response_code(200);

        $model = new Model('users');

        $opt = 'name=' . $_GET['name'] . 
        'AND password=' . $_GET['password'];

        $model->delete($opt);

        return $this->json([
            'code' => 200,
            'message' => 'Успешно удалось удалить пользователя!',
        ]);
    }

    function updateUser(): string
    {
        return $this->json(['1' => '2']);
        
    }

    private function isRequests(): array
    {
        if(!isset($_GET['name'], $_GET['password'])) 
        {
            return [
                'json' => $this->json([
                    'code' => 400,
                    'message' => 'Пользователь не авторизирован!',
                ]),
                'isRequests' => false,
            ];
        }
        
        return [
            'json' => $this->json([
                'code' => 200,
                'message' => 'Удалось аворизироваться!',
            ]),
            'isRequests' => true,
        ];
    }

    private function updateSession(string $name): bool|int
    {
        session_start();
        
        $id = session_id();

        $model = new Model('users');

        return $model->update(['session'], [$id], 'name=' . $name);
    }

    private function isAuth(): array
    {
        session_start();

        $model = new Model('users');

        $user = $model->where(
            ['name', 'age'],
            'session = ' . '"' . session_id() . '"'
        );

        return [
            'isAuth' => $user === [], 
            'data' => $user,
        ];
    }
}