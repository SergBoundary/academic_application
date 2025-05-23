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
// Admin panel for messages from users
Router::add('^(?P<language>[a-z-]+)/admin/messages$', ['controller' => 'AdminMessage', 'action' => 'index', 'role' => 'Admin', 'method' => 'GET']);

// Admin panel for translation management
Router::add('^(?P<language>[a-z-]+)/admin/translations$', ['controller' => 'AdminTranslation', 'action' => 'index', 'role' => 'Admin', 'method' => 'GET']);
Router::add('^(?P<language>[a-z-]+)/admin/translations/create$', ['controller' => 'AdminTranslation', 'action' => 'create', 'role' => 'Admin', 'method' => 'GET']);
Router::add('^(?P<language>[a-z-]+)/admin/translations/store$', ['controller' => 'AdminTranslation', 'action' => 'store', 'role' => 'Admin', 'method' => 'POST']);
Router::add('^(?P<language>[a-z-]+)/admin/translations/edit/?(?P<key>[\w\-]+)$', ['controller' => 'AdminTranslation', 'action' => 'edit', 'role' => 'Admin', 'method' => 'GET']);
Router::add('^(?P<language>[a-z-]+)/admin/translations/update$', ['controller' => 'AdminTranslation', 'action' => 'update', 'role' => 'Admin', 'method' => 'POST']);
Router::add('^(?P<language>[a-z-]+)/admin/translations/delete$', ['controller' => 'AdminTranslation', 'action' => 'delete', 'role' => 'Admin', 'method' => 'POST']);

// Admin panel for research post management
Router::add('^(?P<language>[a-z-]+)/admin/research$', ['controller' => 'AdminResearch', 'action' => 'index', 'role' => 'Admin', 'method' => 'GET']);
Router::add('^(?P<language>[a-z-]+)/admin/research/(?P<id>\d+)/edit$', ['controller' => 'AdminResearch', 'action' => 'edit', 'role' => 'Admin', 'method' => 'GET']);
Router::add('^(?P<language>[a-z-]+)/admin/research/update$', ['controller' => 'AdminResearch', 'action' => 'update', 'role' => 'Admin', 'method' => 'POST']);
Router::add('^(?P<language>[a-z-]+)/admin/research/lock/(?P<id>\d+)$', ['controller' => 'AdminResearch', 'action' => 'toggleLock', 'role' => 'Admin', 'method' => 'POST']); // Locked

// TODO: Admin panel for research design standard management
Router::add('^(?P<language>[a-z-]+)/admin/research/standard/design$', ['controller' => 'AdminResearchDesign', 'action' => 'index', 'role' => 'Admin', 'method' => 'GET']);
Router::add('^(?P<language>[a-z-]+)/admin/research/standard/design/create/?(?P<form>discipline|field|area|type|element)$', ['controller' => 'AdminResearchDesign', 'action' => 'create', 'role' => 'Admin', 'method' => 'GET']);
Router::add('^(?P<language>[a-z-]+)/admin/research/standard/design/store$', ['controller' => 'AdminResearchDesign', 'action' => 'store', 'role' => 'Admin', 'method' => 'POST']);
Router::add('^(?P<language>[a-z-]+)/admin/research/standard/design/edit/?(?P<key>[\w\-]+)$', ['controller' => 'AdminResearchDesign', 'action' => 'edit', 'role' => 'Admin', 'method' => 'GET']);
Router::add('^(?P<language>[a-z-]+)/admin/research/standard/design/update$', ['controller' => 'AdminResearchDesign', 'action' => 'update', 'role' => 'Admin', 'method' => 'POST']);
Router::add('^(?P<language>[a-z-]+)/admin/research/standard/design/delete$', ['controller' => 'AdminResearchDesign', 'action' => 'delete', 'role' => 'Admin', 'method' => 'POST']);
Router::add('^(?P<language>[a-z-]+)/admin/research/standard/design/fields/(?P<id>\d+)$', ['controller' => 'AdminResearchDesign', 'action' => 'listFields', 'role' => 'Admin', 'method' => 'POST']); // Locked

// TODO: Admin panel for research implementation standard management
Router::add('^(?P<language>[a-z-]+)/admin/research/standard/implementation$', ['controller' => 'AdminResearchImplementation', 'action' => 'index', 'role' => 'Admin', 'method' => 'GET']);
Router::add('^(?P<language>[a-z-]+)/admin/research/standard/implementation/edit$', ['controller' => 'AdminResearchImplementation', 'action' => 'edit', 'role' => 'Admin', 'method' => 'GET']);
Router::add('^(?P<language>[a-z-]+)/admin/research/standard/implementation/update$', ['controller' => 'AdminResearchImplementation', 'action' => 'update', 'role' => 'Admin', 'method' => 'POST']);
Router::add('^(?P<language>[a-z-]+)/admin/research/standard/implementation/delete$', ['controller' => 'AdminResearchImplementation', 'action' => 'delete', 'role' => 'Admin', 'method' => 'POST']);

// TODO: Admin panel for research publication standard management
Router::add('^(?P<language>[a-z-]+)/admin/research/standard/publication$', ['controller' => 'AdminResearchPublication', 'action' => 'index', 'role' => 'Admin', 'method' => 'GET']);
Router::add('^(?P<language>[a-z-]+)/admin/research/standard/publication/edit$', ['controller' => 'AdminResearchPublication', 'action' => 'edit', 'role' => 'Admin', 'method' => 'GET']);
Router::add('^(?P<language>[a-z-]+)/admin/research/standard/publication/update$', ['controller' => 'AdminResearchPublication', 'action' => 'update', 'role' => 'Admin', 'method' => 'POST']);
Router::add('^(?P<language>[a-z-]+)/admin/research/standard/publication/delete$', ['controller' => 'AdminResearchPublication', 'action' => 'delete', 'role' => 'Admin', 'method' => 'POST']);

// TODO: Admin panel for research post type management
// Router::add('^(?P<language>[a-z-]+)/admin/research/types$', ['controller' => 'AdminResearchType', 'action' => 'index', 'role' => 'Admin', 'method' => 'GET']);
// Router::add('^(?P<language>[a-z-]+)/admin/research/types/create$', ['controller' => 'AdminResearchType', 'action' => 'create', 'role' => 'Admin', 'method' => 'GET']);
// Router::add('^(?P<language>[a-z-]+)/admin/research/types/store$', ['controller' => 'AdminResearchType', 'action' => 'store', 'role' => 'Admin', 'method' => 'POST']);
// Router::add('^(?P<language>[a-z-]+)/admin/research/types/edit/?(?P<key>[\w\-]+)$', ['controller' => 'AdminResearchType', 'action' => 'edit', 'role' => 'Admin', 'method' => 'GET']);
// Router::add('^(?P<language>[a-z-]+)/admin/research/types/update$', ['controller' => 'AdminResearchType', 'action' => 'update', 'role' => 'Admin', 'method' => 'POST']);
// Router::add('^(?P<language>[a-z-]+)/admin/research/types/delete$', ['controller' => 'AdminResearchType', 'action' => 'delete', 'role' => 'Admin', 'method' => 'POST']);

// TODO: Admin panel for research post type management
// Router::add('^(?P<language>[a-z-]+)/admin/research/element/types$', ['controller' => 'AdminResearchElementType', 'action' => 'index', 'role' => 'Admin', 'method' => 'GET']);
// Router::add('^(?P<language>[a-z-]+)/admin/research/element/types/create$', ['controller' => 'AdminResearchElementType', 'action' => 'create', 'role' => 'Admin', 'method' => 'GET']);
// Router::add('^(?P<language>[a-z-]+)/admin/research/element/types/store$', ['controller' => 'AdminResearchElementType', 'action' => 'store', 'role' => 'Admin', 'method' => 'POST']);
// Router::add('^(?P<language>[a-z-]+)/admin/research/element/types/edit/?(?P<key>[\w\-]+)$', ['controller' => 'AdminResearchElementType', 'action' => 'edit', 'role' => 'Admin', 'method' => 'GET']);
// Router::add('^(?P<language>[a-z-]+)/admin/research/element/types/update$', ['controller' => 'AdminResearchElementType', 'action' => 'update', 'role' => 'Admin', 'method' => 'POST']);
// Router::add('^(?P<language>[a-z-]+)/admin/research/element/types/delete$', ['controller' => 'AdminResearchElementType', 'action' => 'delete', 'role' => 'Admin', 'method' => 'POST']);

// Module Research
Router::add('^(?P<language>[a-z-]+)/research$', ['module' => 'Research', 'controller' => 'Research', 'action' => 'index', 'method' => 'GET']);
Router::add('^(?P<language>[a-z-]+)/research/(?P<id>\d+)$', ['module' => 'Research', 'controller' => 'Research', 'action' => 'view', 'method' => 'GET']);
// Module Discussion
Router::add('^(?P<language>[a-z-]+)/discussion$', ['module' => 'Discussion', 'controller' => 'Discussion', 'action' => 'index', 'method' => 'GET']);
Router::add('^(?P<language>[a-z-]+)/discussion/(?P<id>\d+)$', ['module' => 'Discussion', 'controller' => 'Discussion', 'action' => 'view', 'method' => 'GET']);

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
Router::add('^(?P<language>[a-z-]+)/(?P<username>[a-z0-9-]+)/discussion$', ['module' => 'Discussion', 'controller' => 'UserDiscussion', 'action' => 'index', 'method' => 'GET']);
Router::add('^(?P<language>[a-z-]+)/(?P<username>[a-z0-9-]+)/discussion/(?P<researchid>\d+)/(?P<discussionid>\d+)/create$', ['module' => 'Discussion', 'controller' => 'UserDiscussion', 'action' => 'create', 'method' => 'GET']);
Router::add('^(?P<language>[a-z-]+)/(?P<username>[a-z0-9-]+)/discussion/store$', ['module' => 'Discussion', 'controller' => 'UserDiscussion', 'action' => 'store', 'method' => 'POST']);
Router::add('^(?P<language>[a-z-]+)/(?P<username>[a-z0-9-]+)/discussion/(?P<id>\d+)$', ['module' => 'Discussion', 'controller' => 'UserDiscussion', 'action' => 'view', 'method' => 'GET']);
Router::add('^(?P<language>[a-z-]+)/(?P<username>[a-z0-9-]+)/discussion/(?P<id>\d+)/edit$', ['module' => 'Discussion', 'controller' => 'UserDiscussion', 'action' => 'edit', 'method' => 'GET']);
Router::add('^(?P<language>[a-z-]+)/(?P<username>[a-z0-9-]+)/discussion/(?P<id>\d+)/update$', ['module' => 'Discussion', 'controller' => 'UserDiscussion', 'action' => 'update', 'method' => 'POST']);
Router::add('^(?P<language>[a-z-]+)/(?P<username>[a-z0-9-]+)/discussion/(?P<id>\d+)/delete$', ['module' => 'Discussion', 'controller' => 'UserDiscussion', 'action' => 'delete', 'method' => 'POST']);

// Universal Interaction Controller
Router::add('^(?P<language>[a-z-]+)/interact/(?P<type>liked|disliked|bookmarked|subscribed|shared)/(?P<level>research|discussion)/(?P<id>\d+)$', ['controller' => 'Interaction', 'action' => 'toggle', 'method' => 'POST']);


// Router::add('^$', ['lang' => 'pl', 'action' => 'index', 'content' => 'index']);
// Router::add('^(?P<lang>[a-z-]+)?$', ['action' => 'index', 'content' => 'index']);
// Router::add('^(?P<lang>[a-z-]+)/?(?P<field>[a-z-]+)?$', ['action' => 'index', 'content' => 'index']);
// Router::add('^(?P<lang>[a-z-]+)/?(?P<field>[a-z-]+)/?(?P<action>(?|add)+)?$', ['action' => 'add', 'content' => 'index']);
// Router::add('^(?P<lang>[a-z-]+)/?(?P<field>[a-z-]+)/?(?P<area>[a-z-]+)/?(?P<action>(?|add)+)?$', ['action' => 'index', 'content' => 'index']);
// Router::add('^(?P<lang>[a-z-]+)/?(?P<field>[a-z-]+)/?(?P<area>[a-z-]+)/?(?P<content>[0-9a-z-]+)?$', ['action' => 'show']);
// Router::add('^(?P<lang>[a-z-]+)/?(?P<field>[a-z-]+)/?(?P<area>[a-z-]+)/?(?P<content>[0-9a-z-]+)/?(?P<action>(?|edit|delete)+)?$');