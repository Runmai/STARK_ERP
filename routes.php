<?php
use Core\Router;

$router = new Router();

// ── Auth ──────────────────────────────────────────────────────
$router->get('/login',             ['Controllers\AuthController','showLogin']);
$router->post('/login',            ['Controllers\AuthController','login']);
$router->get('/auth/totp-setup',   ['Controllers\AuthController','showTotpSetup']);
$router->post('/auth/totp-setup',  ['Controllers\AuthController','verifyTotpSetup']);
$router->get('/auth/totp-verify',  ['Controllers\AuthController','showTotpVerify']);
$router->post('/auth/totp-verify', ['Controllers\AuthController','verifyTotp']);
$router->post('/logout',           ['Controllers\AuthController','logout']);

// ── Dashboard ─────────────────────────────────────────────────
$router->get('/dashboard',         ['Controllers\DashboardController','index']);
$router->get('/',                  ['Controllers\DashboardController','index']);

// ── Projects ──────────────────────────────────────────────────
$router->get('/projects',                    ['Controllers\ProjectController','index']);
$router->get('/projects/create',             ['Controllers\ProjectController','create']);
$router->post('/projects/store',             ['Controllers\ProjectController','store']);
$router->get('/projects/{id}',               ['Controllers\ProjectController','show']);
$router->post('/projects/{id}/update',       ['Controllers\ProjectController','update']);
$router->post('/projects/{id}/delete',       ['Controllers\ProjectController','delete']);

// ── Project API (AJAX) ────────────────────────────────────────
$router->get('/api/projects/{id}/tab/{tab}',            ['Controllers\ApiController','getTab']);
$router->post('/api/projects/{id}/todos',               ['Controllers\ApiController','storeTodo']);
$router->post('/api/projects/{id}/todos/{tid}/status',  ['Controllers\ApiController','updateTodoStatus']);
$router->post('/api/projects/{id}/todos/{tid}/delete',  ['Controllers\ApiController','deleteTodo']);
$router->post('/api/projects/{id}/events',              ['Controllers\ApiController','storeEvent']);
$router->post('/api/projects/{id}/events/{eid}/delete', ['Controllers\ApiController','deleteEvent']);
$router->post('/api/projects/{id}/chat',                ['Controllers\ApiController','sendChat']);
$router->get('/api/projects/{id}/chat/poll',            ['Controllers\ApiController','pollChat']);
$router->post('/api/projects/{id}/messages',            ['Controllers\ApiController','storeMessage']);
$router->post('/api/projects/{id}/messages/{mid}/pin',  ['Controllers\ApiController','pinMessage']);
$router->post('/api/projects/{id}/messages/{mid}/delete',['Controllers\ApiController','deleteMessage']);
$router->post('/api/projects/{id}/locations',           ['Controllers\ApiController','storeLocation']);
$router->post('/api/projects/{id}/locations/{lid}',     ['Controllers\ApiController','updateLocation']);
$router->post('/api/projects/{id}/locations/{lid}/delete',['Controllers\ApiController','deleteLocation']);
$router->post('/api/projects/{id}/cameras',             ['Controllers\ApiController','storeCamera']);
$router->post('/api/projects/{id}/cameras/{cid}',       ['Controllers\ApiController','updateCamera']);
$router->post('/api/projects/{id}/cameras/{cid}/delete',['Controllers\ApiController','deleteCamera']);
$router->post('/api/projects/{id}/updates',             ['Controllers\ApiController','storeDailyUpdate']);
$router->post('/api/projects/{id}/updates/{uid}/delete',['Controllers\ApiController','deleteUpdate']);
$router->post('/api/projects/{id}/team/add',            ['Controllers\ApiController','addMember']);
$router->post('/api/projects/{id}/team/{empId}/remove', ['Controllers\ApiController','removeMember']);
$router->post('/api/projects/{id}/documents',           ['Controllers\ApiController','uploadDocument']);
$router->post('/api/projects/{id}/documents/{did}/delete',['Controllers\ApiController','deleteDocument']);
$router->post('/api/projects/{id}/expenses',            ['Controllers\ApiController','storeExpense']);
$router->post('/api/projects/{id}/expenses/{eid}/delete',['Controllers\ApiController','deleteExpense']);
$router->post('/api/projects/{id}/tickets',             ['Controllers\ApiController','storeTicket']);
$router->post('/api/projects/{id}/tickets/{tid}',       ['Controllers\ApiController','updateTicket']);
$router->post('/api/projects/{id}/tickets/{tid}/delete',['Controllers\ApiController','deleteTicket']);

// ── Notification API ──────────────────────────────────────────
$router->get('/api/notifications',                   ['Controllers\ApiController','getNotifications']);
$router->post('/api/notifications/{nid}/read',       ['Controllers\ApiController','markRead']);
$router->post('/api/notifications/read-all',         ['Controllers\ApiController','markAllRead']);

// ── Users / Admin ─────────────────────────────────────────────
$router->get('/users',                  ['Controllers\UserController','index']);
$router->post('/users/store',           ['Controllers\UserController','store']);
$router->post('/users/{id}/toggle',     ['Controllers\UserController','toggle']);
$router->post('/users/{id}/reset-totp', ['Controllers\UserController','resetTotp']);
$router->get('/profile',                ['Controllers\UserController','profile']);
$router->get('/audit-logs',             ['Controllers\UserController','auditLogs']);
$router->get('/notifications',          ['Controllers\UserController','notifications']);
$router->get('/employees',              ['Controllers\UserController','employees']);

return $router;
