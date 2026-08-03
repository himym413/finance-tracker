<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

$router = require __DIR__ . '/../routes/web.php';

$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?: '/';

$router->dispatch($httpMethod, $uri);