<?php

/** @var object App\Controllers\TransactionController */

declare(strict_types=1);

use App\Controllers\DashboardController;
use App\Controllers\TransactionController;
use App\Core\Router;

$router = new Router($container);

$router->get('/', [DashboardController::class, 'index']);

$router->get('/transactions', [TransactionController::class, 'index']);
$router->post('/transactions', [TransactionController::class, 'store']);
$router->get('/transactions/create', [TransactionController::class, 'create']);
$router->get('/transactions/{id}/edit', [TransactionController::class, 'edit']);
$router->post('/transactions/{id}', [TransactionController::class, 'update']);

return $router;
