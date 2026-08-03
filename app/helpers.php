<?php

declare(strict_types=1);

function view(string $path, array $data = []): void 
{
  extract($data);
  
  $view = __DIR__ . '/../resources/views/' . $path . '.view.php';

  if (!file_exists($view)) {
    throw new RuntimeException("View [{$path}] could not be found.");
  }

  require $view;
}