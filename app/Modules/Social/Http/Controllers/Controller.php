<?php

namespace App\Modules\Social\Http\Controllers;

class Controller
{
  public $nameController;

  public function __construct() {
    $this->nameController = 'Social';
  }
}