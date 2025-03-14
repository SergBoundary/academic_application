<?php

use App\Core\Http\Router;

// Module Core
Router::add('^(?P<language>[a-z-]+)$', ['controller' => 'Home', 'action' => 'index']);
// Authentification
Router::add('^(?P<language>[a-z-]+)/register$', ['controller' => 'Auth', 'action' => 'register', 'middleware' => 'guest']);
Router::add('^(?P<language>[a-z-]+)/login$', ['controller' => 'Auth', 'action' => 'login', 'middleware' => 'guest']);
Router::add('^(?P<language>[a-z-]+)/logout$', ['controller' => 'Auth', 'action' => 'logout']);
// Reset password
Router::add('^(?P<language>[a-z-]+)/password/reset$', ['controller' => 'Auth', 'action' => 'showResetForm', 'method' => 'GET', 'middleware' => 'guest']);
Router::add('^(?P<language>[a-z-]+)/password/reset-request$', ['controller' => 'Auth', 'action' => 'sendResetLink', 'method' => 'POST']);
Router::add('^(?P<language>[a-z-]+)/password/new$', ['controller' => 'Auth', 'action' => 'showNewPasswordForm', 'method' => 'GET', 'middleware' => 'guest']);
Router::add('^(?P<language>[a-z-]+)/password/update$', ['controller' => 'Auth', 'action' => 'updatePassword', 'method' => 'POST']);

// Admin dashboard
Router::add('^(?P<language>[a-z-]+)/admin$', ['controller' => 'Admin', 'action' => 'index', 'method' => 'GET']);
// User list for edit and delete
Router::add('^(?P<language>[a-z-]+)/admin/users$', ['controller' => 'User', 'action' => 'index', 'role' => 'Admin', 'method' => 'GET']);
Router::add('^(?P<language>[a-z-]+)/admin/users/edit/?(?P<id>[0-9]+)$', ['controller' => 'User', 'action' => 'edit', 'role' => 'Admin', 'method' => 'GET']);
Router::add('^(?P<language>[a-z-]+)/admin/users/update$', ['controller' => 'User', 'action' => 'update', 'role' => 'Admin', 'method' => 'POST']);
Router::add('^(?P<language>[a-z-]+)/admin/users/delete$', ['controller' => 'User', 'action' => 'delete', 'role' => 'Admin', 'method' => 'POST']);
Router::add('^(?P<language>[a-z-]+)/admin/messages$', ['controller' => 'Message', 'action' => 'index', 'role' => 'Admin', 'method' => 'GET']);

// Admin panel for translation management
Router::add('^(?P<language>[a-z-]+)/admin/translations$', ['controller' => 'Translation', 'action' => 'index', 'role' => 'Admin', 'method' => 'GET']);
Router::add('^(?P<language>[a-z-]+)/admin/translations/add$', ['controller' => 'Translation', 'action' => 'add', 'role' => 'Admin', 'method' => 'GET']);
Router::add('^(?P<language>[a-z-]+)/admin/translations/create$', ['controller' => 'Translation', 'action' => 'create', 'role' => 'Admin', 'method' => 'POST']);
Router::add('^(?P<language>[a-z-]+)/admin/translations/edit/?(?P<key>[\w\-]+)$', ['controller' => 'Translation', 'action' => 'edit', 'role' => 'Admin', 'method' => 'GET']);
Router::add('^(?P<language>[a-z-]+)/admin/translations/update$', ['controller' => 'Translation', 'action' => 'update', 'role' => 'Admin', 'method' => 'POST']);
Router::add('^(?P<language>[a-z-]+)/admin/translations/delete$', ['controller' => 'Translation', 'action' => 'delete', 'role' => 'Admin', 'method' => 'POST']);


// Module Research
Router::add('^(?P<language>[a-z-]+)/research$', ['module' => 'Research', 'controller' => 'Research', 'action' => 'index']);
Router::add('^(?P<language>[a-z-]+)/research/(.+)$', ['module' => 'Research', 'controller' => 'Research', 'action' => 'view']);

// Module Social
Router::add('^(?P<language>[a-z-]+)/social$', ['module' => 'Social', 'controller' => 'Social', 'action' => 'index']);
Router::add('^(?P<language>[a-z-]+)/social/(.+)$', ['module' => 'Social', 'controller' => 'Social', 'action' => 'view']);

// API для аутентификации
Router::add('^(?P<language>[a-z-]+)/api/v1/login$', ['module' => 'Api\\V1', 'controller' => 'Auth', 'action' => 'login', 'method' => 'POST']);
// Пример API для получения списка пользователей (защищенный эндпоинт)
Router::add('^(?P<language>[a-z-]+)/api/v1/users$', ['module' => 'Api\\V1', 'controller' => 'User', 'action' => 'index', 'method' => 'GET']);
Router::add('^(?P<language>[a-z-]+)/api/v1/users/update$', ['module' => 'Api\\V1', 'controller' => 'User', 'action' => 'update', 'method' => 'POST']);

// User dashboard
Router::add('^(?P<language>[a-z-]+)/?(?P<username>[a-z0-9-]+)?$', ['controller' => 'User', 'action' => 'index', 'method' => 'GET']);
// User Profile for edit and delete
Router::add('^(?P<language>[a-z-]+)/(?P<username>[a-z0-9-]+)/profile$', ['controller' => 'UserProfile', 'action' => 'index']);
Router::add('^(?P<language>[a-z-]+)/(?P<username>[a-z0-9-]+)/edit-profile$', ['controller' => 'UserProfile', 'action' => 'edit', 'method' => 'GET']);
Router::add('^(?P<language>[a-z-]+)/(?P<username>[a-z0-9-]+)/update-profile$', ['controller' => 'UserProfile', 'action' => 'update', 'method' => 'POST']);
Router::add('^(?P<language>[a-z-]+)/(?P<username>[a-z0-9-]+)/delete-account$', ['controller' => 'UserProfile', 'action' => 'delete', 'method' => 'POST']);
Router::add('^(?P<language>[a-z-]+)/(?P<username>[a-z0-9-]+)/send-message$', ['controller' => 'UserProfile', 'action' => 'sendMessage', 'method' => 'POST']);


// Router::add('^$', ['lang' => 'pl', 'action' => 'index', 'content' => 'index']);
// Router::add('^(?P<lang>[a-z-]+)?$', ['action' => 'index', 'content' => 'index']);
// Router::add('^(?P<lang>[a-z-]+)/?(?P<field>[a-z-]+)?$', ['action' => 'index', 'content' => 'index']);
// Router::add('^(?P<lang>[a-z-]+)/?(?P<field>[a-z-]+)/?(?P<action>(?|add)+)?$', ['action' => 'add', 'content' => 'index']);
// Router::add('^(?P<lang>[a-z-]+)/?(?P<field>[a-z-]+)/?(?P<area>[a-z-]+)/?(?P<action>(?|add)+)?$', ['action' => 'index', 'content' => 'index']);
// Router::add('^(?P<lang>[a-z-]+)/?(?P<field>[a-z-]+)/?(?P<area>[a-z-]+)/?(?P<content>[0-9a-z-]+)?$', ['action' => 'show']);
// Router::add('^(?P<lang>[a-z-]+)/?(?P<field>[a-z-]+)/?(?P<area>[a-z-]+)/?(?P<content>[0-9a-z-]+)/?(?P<action>(?|edit|delete)+)?$');