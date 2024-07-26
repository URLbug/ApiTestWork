<?php

namespace Controllers;

class ApiController extends Controller
{
    function home(): string
    {
        return $this->json(['1' => '2']);
    }
}