<?php

require_once __DIR__ . '/Controller.php';

class ApiController extends Controller
{
    function home(): void
    {
        echo $_GET['string'];
    }
}