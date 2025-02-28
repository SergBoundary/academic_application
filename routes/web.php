<?php

use App\Core\Http\Router;

Router::add('^$', ['controller' => 'Home', 'action' => 'index']);
Router::add('^about$', ['controller' => 'About', 'action' => 'index']);
Router::add('^research$', ['module' => 'Research', 'controller' => 'Research', 'action' => 'index']);
Router::add('^social$', ['module' => 'Social', 'controller' => 'Social', 'action' => 'index']);
