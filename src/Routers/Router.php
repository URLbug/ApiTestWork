<?php

namespace Routers;

class Router
{
    /**
     * Тут будут храниться все роутеры
     * 
     * @var array<string, mixed>
     */
    private array $routers = [];
    
    /**
     * Регестрирует новый роутер
     * 
     * @param string $method
     * @param string $path
     * @param array $controller
     * @return void
     */
    function add(
        string $method, 
        string $path, 
        array $controller
    ): void {
        $path = $this->normalizePath($path);

        $this->routers[] = [
            'path' => $path,
            'method' => strtoupper($method), // Делаю каждый метод заглавным
            'controller' => $controller,
        ];
    }

    /**
     * Метод для описание маршрута
     * 
     * @param string $path
     * @return void
     */
    public function dispatch(string $path): void
    { 
        $path = $this->normalizePath($path);
        $method = strtoupper($_SERVER['REQUEST_METHOD']); // Метод который пришел на сервер

        foreach($this->routers as $route) 
        {
            // Проверка пути
            if (
              !preg_match("#^{$route['path']}$#", $path) ||
              $route['method'] !== $method
            ) {
                continue;
            }
            
            // Инцилизирую класс и вызываю функцию
            $class = $route['controller'][0];
            $function = $route['controller'][1];
            
            $controller = new $class;
            
            echo $controller->{ $function }();
        }
    }

    /**
     * Нормализируем каждый путь 
     * 
     * @param string $path
     * @return string
     */
    private function normalizePath(string $path): string 
    { 
        $path = trim($path, '/'); 
        
        $path = "/{$path}/"; 
        
        $path = preg_replace('#[/]{2,}#', '/', $path);
        
        return $path; 
    } 
}