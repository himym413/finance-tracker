<?php

declare(strict_types=1);

use App\Core\Container;
use App\Database\Database;

session_start();

require __DIR__ . '/../vendor/autoload.php';

$config = require __DIR__ . '/../config/database.php';

$db = new Database($config);

$container = new Container();
$container->bind(Database::class, $db);

$router = require __DIR__ . '/../routes/web.php';

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?: '/';
$httpMethod = $_SERVER['REQUEST_METHOD'];

$router->dispatch($httpMethod, $uri);
