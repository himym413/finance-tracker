<?php

declare(strict_types=1);

use App\Controllers\DashboardController;
use App\Controllers\TransactionController;
use App\Core\Router;

$router = new Router($container);

$router->get('/', [DashboardController::class, 'index']);

$router->get('/transactions', [TransactionController::class, 'index']);

return $router;
