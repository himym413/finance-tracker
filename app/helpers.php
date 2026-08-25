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

function flash(string $key, ?string $message = null): ?string
{
  if ($message !== null) {
    $_SESSION['_flash'][$key] = $message;
    return null;
  }

  if (!isset($_SESSION['_flash'][$key])) {
    return null;
  }

  $flashMessage = $_SESSION['_flash'][$key];
  unset($_SESSION['_flash'][$key]);

  return $flashMessage;
}

function userId(): int
{
  return (int) $_SESSION['user_id'];
}

function isAuthenticated(): bool
{
  return isset($_SESSION['user_id']);
}

function redirect(string $path): never
{
  header("Location: {$path}");
  exit();
}

function csrfToken(): string
{
  if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
  }

  return $_SESSION['csrf_token'];
}

function verifyCsrfToken(): void
{
  $token = $_POST['_token'] ?? '';

  if (
    !isset($_SESSION['csrf_token']) ||
    !hash_equals($_SESSION['csrf_token'], $token)
  ) {
    http_response_code(419);

    view('errors/419');

    exit();
  }
}
