<?php

use App\Core\Http\Router;

// Module Core
Router::add('^(?P<language>[a-z-]+)$', ['controller' => 'Home', 'action' => 'index']);
// Authentification
Router::add('^(?P<language>[a-z-]+)/register$', ['controller' => 'Auth', 'action' => 'register']);
Router::add('^(?P<language>[a-z-]+)/login$', ['controller' => 'Auth', 'action' => 'login']);
Router::add('^(?P<language>[a-z-]+)/logout$', ['controller' => 'Auth', 'action' => 'logout']);
// Admin dashboard
Router::add('^(?P<language>[a-z-]+)/admin$', ['controller' => 'Admin', 'action' => 'index', 'method' => 'GET']);
// User list for edit and delete
Router::add('^(?P<language>[a-z-]+)/admin/users$', ['controller' => 'User', 'action' => 'index', 'role' => 'Admin', 'method' => 'GET']);
Router::add('^(?P<language>[a-z-]+)/admin/users/edit/(\d+)$', ['controller' => 'User', 'action' => 'edit', 'role' => 'Admin', 'method' => 'GET']);
Router::add('^(?P<language>[a-z-]+)/admin/users/update$', ['controller' => 'User', 'action' => 'update', 'role' => 'Admin', 'method' => 'POST']);
Router::add('^(?P<language>[a-z-]+)/admin/users/delete$', ['controller' => 'User', 'action' => 'delete', 'role' => 'Admin', 'method' => 'POST']);
// Reset password
Router::add('^(?P<language>[a-z-]+)/password/reset$', ['controller' => 'Auth', 'action' => 'showResetForm', 'method' => 'GET']);
Router::add('^(?P<language>[a-z-]+)/password/reset-request$', ['controller' => 'Auth', 'action' => 'sendResetLink', 'method' => 'POST']);
Router::add('^(?P<language>[a-z-]+)/password/new$', ['controller' => 'Auth', 'action' => 'showNewPasswordForm', 'method' => 'GET']);
Router::add('^(?P<language>[a-z-]+)/password/update$', ['controller' => 'Auth', 'action' => 'updatePassword', 'method' => 'POST']);

// Module Research
Router::add('^(?P<lang>[a-z-]+)/research$', ['module' => 'Research', 'controller' => 'Research', 'action' => 'index']);
Router::add('^(?P<lang>[a-z-]+)/research/(.+)$', ['module' => 'Research', 'controller' => 'Research', 'action' => 'view']);

// Module Social
Router::add('^(?P<lang>[a-z-]+)/social$', ['module' => 'Social', 'controller' => 'Social', 'action' => 'index']);
Router::add('^(?P<lang>[a-z-]+)/social/(.+)$', ['module' => 'Social', 'controller' => 'Social', 'action' => 'view']);



// Router::add('^$', ['lang' => 'pl', 'action' => 'index', 'content' => 'index']);
// Router::add('^(?P<lang>[a-z-]+)?$', ['action' => 'index', 'content' => 'index']);
// Router::add('^(?P<lang>[a-z-]+)/?(?P<field>[a-z-]+)?$', ['action' => 'index', 'content' => 'index']);
// Router::add('^(?P<lang>[a-z-]+)/?(?P<field>[a-z-]+)/?(?P<action>(?|add)+)?$', ['action' => 'add', 'content' => 'index']);
// Router::add('^(?P<lang>[a-z-]+)/?(?P<field>[a-z-]+)/?(?P<area>[a-z-]+)/?(?P<action>(?|add)+)?$', ['action' => 'index', 'content' => 'index']);
// Router::add('^(?P<lang>[a-z-]+)/?(?P<field>[a-z-]+)/?(?P<area>[a-z-]+)/?(?P<content>[0-9a-z-]+)?$', ['action' => 'show']);
// Router::add('^(?P<lang>[a-z-]+)/?(?P<field>[a-z-]+)/?(?P<area>[a-z-]+)/?(?P<content>[0-9a-z-]+)/?(?P<action>(?|edit|delete)+)?$');