<?php

declare(strict_types=1);

function dd(mixed $value): never
{
  echo '<pre>';
  var_dump($value);
  echo '</pre>';

  die();
}

function view(string $path, array $data = []): void
{
  $view = __DIR__ . '/../resources/views/' . $path . '.view.php';

  if (!file_exists($view)) {
    throw new RuntimeException("View [{$path}] could not be found.");
  }

  extract($data);

  require $view;
}
