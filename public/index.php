<?php

declare(strict_types=1);

use App\Database\Database;

require __DIR__ . '/../vendor/autoload.php';

$config = require __DIR__ . '/../config/database.php';

$db = new Database($config);

$router = require __DIR__ . '/../routes/web.php';

$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?: '/';

$router->dispatch($httpMethod, $uri);