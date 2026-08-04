<?php

declare(strict_types=1);

use App\Controllers\DashboardController;
use App\Core\Router;

$router = new Router($container);

$router->get('/', [DashboardController::class, 'index']);

return $router;