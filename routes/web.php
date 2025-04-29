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
Router::add('^(?P<language>[a-z-]+)/admin/users$', ['controller' => 'AdminUser', 'action' => 'index', 'role' => 'Admin', 'method' => 'GET']);
Router::add('^(?P<language>[a-z-]+)/admin/users/edit/?(?P<id>[0-9]+)$', ['controller' => 'AdminUser', 'action' => 'edit', 'role' => 'Admin', 'method' => 'GET']);
Router::add('^(?P<language>[a-z-]+)/admin/users/update$', ['controller' => 'AdminUser', 'action' => 'update', 'role' => 'Admin', 'method' => 'POST']);
Router::add('^(?P<language>[a-z-]+)/admin/users/delete$', ['controller' => 'AdminUser', 'action' => 'delete', 'role' => 'Admin', 'method' => 'POST']);
Router::add('^(?P<language>[a-z-]+)/admin/messages$', ['controller' => 'AdminMessage', 'action' => 'index', 'role' => 'Admin', 'method' => 'GET']);

// Admin panel for translation management
Router::add('^(?P<language>[a-z-]+)/admin/translations$', ['controller' => 'AdminTranslation', 'action' => 'index', 'role' => 'Admin', 'method' => 'GET']);
Router::add('^(?P<language>[a-z-]+)/admin/translations/create$', ['controller' => 'AdminTranslation', 'action' => 'create', 'role' => 'Admin', 'method' => 'GET']);
Router::add('^(?P<language>[a-z-]+)/admin/translations/store$', ['controller' => 'AdminTranslation', 'action' => 'store', 'role' => 'Admin', 'method' => 'POST']);
Router::add('^(?P<language>[a-z-]+)/admin/translations/edit/?(?P<key>[\w\-]+)$', ['controller' => 'AdminTranslation', 'action' => 'edit', 'role' => 'Admin', 'method' => 'GET']);
Router::add('^(?P<language>[a-z-]+)/admin/translations/update$', ['controller' => 'AdminTranslation', 'action' => 'update', 'role' => 'Admin', 'method' => 'POST']);
Router::add('^(?P<language>[a-z-]+)/admin/translations/delete$', ['controller' => 'AdminTranslation', 'action' => 'delete', 'role' => 'Admin', 'method' => 'POST']);

// Module Research
Router::add('^(?P<language>[a-z-]+)/research$', ['module' => 'Research', 'controller' => 'ResearchHome', 'action' => 'index', 'method' => 'GET']);
Router::add('^(?P<language>[a-z-]+)/research/(?P<id>\d+)$', ['module' => 'Research', 'controller' => 'ResearchHome', 'action' => 'view', 'method' => 'GET']);
// Module Discussion
Router::add('^(?P<language>[a-z-]+)/discussion$', ['module' => 'Discussion', 'controller' => 'DiscussionHome', 'action' => 'index', 'method' => 'GET']);
Router::add('^(?P<language>[a-z-]+)/discussion/(?P<id>\d+)$', ['module' => 'Discussion', 'controller' => 'DiscussionHome', 'action' => 'view', 'method' => 'GET']);

// API для аутентификации
Router::add('^(?P<language>[a-z-]+)/api/v1/login$', ['module' => 'Api\\V1', 'controller' => 'Auth', 'action' => 'login', 'method' => 'POST']);
// Пример API для получения списка пользователей (защищенный эндпоинт)
Router::add('^(?P<language>[a-z-]+)/api/v1/users$', ['module' => 'Api\\V1', 'controller' => 'User', 'action' => 'index', 'method' => 'GET']);
Router::add('^(?P<language>[a-z-]+)/api/v1/users/update$', ['module' => 'Api\\V1', 'controller' => 'User', 'action' => 'update', 'method' => 'POST']);

// User dashboard
Router::add('^(?P<language>[a-z-]+)/?(?P<username>[a-z0-9-]+)?$', ['controller' => 'User', 'action' => 'index', 'role' => 'User', 'method' => 'GET']);
// User Profile for edit and delete
Router::add('^(?P<language>[a-z-]+)/(?P<username>[a-z0-9-]+)/profile$', ['controller' => 'UserProfile', 'action' => 'index', 'role' => 'User', 'method' => 'GET']);
Router::add('^(?P<language>[a-z-]+)/(?P<username>[a-z0-9-]+)/edit-profile$', ['controller' => 'UserProfile', 'action' => 'edit', 'role' => 'User', 'method' => 'GET']);
Router::add('^(?P<language>[a-z-]+)/(?P<username>[a-z0-9-]+)/update-profile$', ['controller' => 'UserProfile', 'action' => 'update', 'role' => 'User', 'method' => 'POST']);
Router::add('^(?P<language>[a-z-]+)/(?P<username>[a-z0-9-]+)/delete-account$', ['controller' => 'UserProfile', 'action' => 'delete', 'role' => 'User', 'method' => 'POST']);
Router::add('^(?P<language>[a-z-]+)/(?P<username>[a-z0-9-]+)/send-message$', ['controller' => 'UserProfile', 'action' => 'sendMessage', 'role' => 'User', 'method' => 'POST']);
// User Research posts for edit and delete
Router::add('^(?P<language>[a-z-]+)/(?P<username>[a-z0-9-]+)/research$', ['module' => 'Research', 'controller' => 'UserResearchPost', 'action' => 'index', 'method' => 'GET']);
Router::add('^(?P<language>[a-z-]+)/(?P<username>[a-z0-9-]+)/research/create$', ['module' => 'Research', 'controller' => 'UserResearchPost', 'action' => 'create', 'method' => 'GET']);
Router::add('^(?P<language>[a-z-]+)/(?P<username>[a-z0-9-]+)/research/store$', ['module' => 'Research', 'controller' => 'UserResearchPost', 'action' => 'store', 'method' => 'POST']);
Router::add('^(?P<language>[a-z-]+)/(?P<username>[a-z0-9-]+)/research/(?P<id>\d+)$', ['module' => 'Research', 'controller' => 'UserResearchPost', 'action' => 'view', 'method' => 'GET']);
Router::add('^(?P<language>[a-z-]+)/(?P<username>[a-z0-9-]+)/research/(?P<id>\d+)/edit$', ['module' => 'Research', 'controller' => 'UserResearchPost', 'action' => 'edit', 'method' => 'GET']);
Router::add('^(?P<language>[a-z-]+)/(?P<username>[a-z0-9-]+)/research/(?P<id>\d+)/update$', ['module' => 'Research', 'controller' => 'UserResearchPost', 'action' => 'update', 'method' => 'POST']);
Router::add('^(?P<language>[a-z-]+)/(?P<username>[a-z0-9-]+)/research/(?P<id>\d+)/delete$', ['module' => 'Research', 'controller' => 'UserResearchPost', 'action' => 'delete', 'method' => 'POST']);
// User Discussion posts for edit and delete
Router::add('^(?P<language>[a-z-]+)/(?P<username>[a-z0-9-]+)/discussion$', ['module' => 'Discussion', 'controller' => 'UserDiscussionPost', 'action' => 'index', 'method' => 'GET']);
Router::add('^(?P<language>[a-z-]+)/(?P<username>[a-z0-9-]+)/discussion/(?P<researchid>\d+)/(?P<discussionid>\d+)/create$', ['module' => 'Discussion', 'controller' => 'UserDiscussionPost', 'action' => 'create', 'method' => 'GET']);
Router::add('^(?P<language>[a-z-]+)/(?P<username>[a-z0-9-]+)/discussion/store$', ['module' => 'Discussion', 'controller' => 'UserDiscussionPost', 'action' => 'store', 'method' => 'POST']);
Router::add('^(?P<language>[a-z-]+)/(?P<username>[a-z0-9-]+)/discussion/(?P<id>\d+)$', ['module' => 'Discussion', 'controller' => 'UserDiscussionPost', 'action' => 'view', 'method' => 'GET']);
Router::add('^(?P<language>[a-z-]+)/(?P<username>[a-z0-9-]+)/discussion/(?P<id>\d+)/edit$', ['module' => 'Discussion', 'controller' => 'UserDiscussionPost', 'action' => 'edit', 'method' => 'GET']);
Router::add('^(?P<language>[a-z-]+)/(?P<username>[a-z0-9-]+)/discussion/(?P<id>\d+)/update$', ['module' => 'Discussion', 'controller' => 'UserDiscussionPost', 'action' => 'update', 'method' => 'POST']);
Router::add('^(?P<language>[a-z-]+)/(?P<username>[a-z0-9-]+)/discussion/(?P<id>\d+)/delete$', ['module' => 'Discussion', 'controller' => 'UserDiscussionPost', 'action' => 'delete', 'method' => 'POST']);

// Universal Interaction Controller
Router::add('^(?P<language>[a-z-]+)/interact/(?P<type>liked|disliked|bookmarked|subscribed|shared)/(?P<level>research|discussion)/(?P<id>\d+)$', ['controller' => 'Interaction', 'action' => 'toggle', 'method' => 'POST']);



// Router::add('^$', ['lang' => 'pl', 'action' => 'index', 'content' => 'index']);
// Router::add('^(?P<lang>[a-z-]+)?$', ['action' => 'index', 'content' => 'index']);
// Router::add('^(?P<lang>[a-z-]+)/?(?P<field>[a-z-]+)?$', ['action' => 'index', 'content' => 'index']);
// Router::add('^(?P<lang>[a-z-]+)/?(?P<field>[a-z-]+)/?(?P<action>(?|add)+)?$', ['action' => 'add', 'content' => 'index']);
// Router::add('^(?P<lang>[a-z-]+)/?(?P<field>[a-z-]+)/?(?P<area>[a-z-]+)/?(?P<action>(?|add)+)?$', ['action' => 'index', 'content' => 'index']);
// Router::add('^(?P<lang>[a-z-]+)/?(?P<field>[a-z-]+)/?(?P<area>[a-z-]+)/?(?P<content>[0-9a-z-]+)?$', ['action' => 'show']);
// Router::add('^(?P<lang>[a-z-]+)/?(?P<field>[a-z-]+)/?(?P<area>[a-z-]+)/?(?P<content>[0-9a-z-]+)/?(?P<action>(?|edit|delete)+)?$');