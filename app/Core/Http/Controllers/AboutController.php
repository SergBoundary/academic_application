<?php

namespace App\Core\Http\Controllers;

class AboutController extends Controller
{
    public function index()
    {
        echo "Главная страница {$this->nameController} - About";
    }
}
