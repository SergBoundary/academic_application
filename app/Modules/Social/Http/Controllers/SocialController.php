<?php

namespace App\Modules\Social\Http\Controllers;

class SocialController extends Controller
{
    public function index()
    {
        echo "Главная страница {$this->nameController}";
    }
}
