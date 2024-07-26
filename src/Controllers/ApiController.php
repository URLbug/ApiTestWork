<?php

require_once __DIR__ . '/Controller.php';

class ApiController extends Controller
{
    function home(): string
    {
        return $this->json(['1' => '2']);
    }
}