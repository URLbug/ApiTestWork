<?php

abstract class Controller
{
    /**
     * @param array<string, mixed> $data
     * @return string
     */
    function json(array $data): string
    {
        header('Content-Type: application/json; charset=utf-8');
        
        return json_encode($data);
    }
}