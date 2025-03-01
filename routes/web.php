<?php

use App\Core\Http\Router;

Router::add('^$', ['controller' => 'Home', 'action' => 'index']);
Router::add('^research$', ['module' => 'Research', 'controller' => 'Research', 'action' => 'index', 'method' => 'GET']);
Router::add('^social$', ['module' => 'Social', 'controller' => 'Social', 'action' => 'index', 'method' => 'GET']);

Router::add('^register$', ['controller' => 'Auth', 'action' => 'register']);
Router::add('^login$', ['controller' => 'Auth', 'action' => 'login']);
Router::add('^logout$', ['controller' => 'Auth', 'action' => 'logout']);

Router::add('^admin$', ['controller' => 'Admin', 'action' => 'index', 'role' => 'Admin', 'method' => 'GET']);
Router::add('^admin/users$', ['controller' => 'User', 'action' => 'index', 'role' => 'Admin', 'method' => 'GET']);
Router::add('^admin/users/edit/(\d+)$', ['controller' => 'User', 'action' => 'edit', 'role' => 'Admin', 'method' => 'GET']);
Router::add('^admin/users/update$', ['controller' => 'User', 'action' => 'update', 'role' => 'Admin', 'method' => 'POST']);
Router::add('^admin/users/delete$', ['controller' => 'User', 'action' => 'delete', 'role' => 'Admin', 'method' => 'POST']);
