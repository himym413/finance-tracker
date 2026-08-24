<?php

/** @var object App\Controllers\TransactionController */

declare(strict_types=1);

use App\Controllers\DashboardController;
use App\Controllers\TransactionController;
use App\Controllers\AuthController;
use App\Core\Router;

$router = new Router($container);

$router->get('/', [DashboardController::class, 'index'])->middleware('auth');

$router->get('/transactions', [TransactionController::class, 'index'])->middleware('auth');
$router->post('/transactions', [TransactionController::class, 'store'])->middleware('auth');
$router->get('/transactions/create', [TransactionController::class, 'create'])->middleware('auth');
$router->get('/transactions/{id}/edit', [TransactionController::class, 'edit'])->middleware('auth');
$router->post('/transactions/{id}', [TransactionController::class, 'update'])->middleware('auth');
$router->post('/transactions/{id}/delete', [TransactionController::class, 'destroy'])->middleware('auth');

$router->get('/register', [AuthController::class, 'register'])->middleware('guest');
$router->post('/register', [AuthController::class, 'store'])->middleware('guest');

$router->get('/login', [AuthController::class, 'login'])->middleware('guest');
$router->post('/login', [AuthController::class, 'authenticate'])->middleware('guest');

$router->post('/logout', [AuthController::class, 'logout'])->middleware('auth');

return $router;
