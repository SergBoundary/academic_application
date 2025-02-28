<?php

namespace App\Core\Http\Controllers;

use App\Core\Models\Model;

class Controller
{
    public $model;

    public function __construct() {
      $this->model = 'Core';
    }
}