<?php

declare(strict_types=1);

namespace App\Validation;

use App\Repositories\UserRepository;

class AuthValidator
{
  public array $errors = [];

  public function __construct(private UserRepository $repository) {}

  public function validate(array $data): bool
  {
    $this->errors = [];

    foreach ($data as $key => $value) {
      if (trim((string) $value) === '')
        $this->addError($key, 'This field is required.');
    }

    if (!isset($this->errors['name']) && (strlen($data['name']) < 4 || strlen($data['name']) > 20))
      $this->addError('name', 'Name length must be between 4 and 20 characters');

    if (!isset($this->errors['email']) && !filter_var($data['email'], FILTER_VALIDATE_EMAIL))
      $this->addError('email', 'Not a valid email address');

    if (!isset($this->errors['email']) && $this->repository->findByEmail($data['email']))
      $this->addError('email', 'Email is already taken.');

    if (!isset($this->errors['password']) && strlen($data['password']) < 8)
      $this->addError('password', 'Password must be at least 8 characters long');

    if (!isset($this->errors['password']) && !isset($this->errors['password_confirmation']) && $data['password'] !== $data['password_confirmation'])
      $this->addError('password_confirmation', 'Passwords did not match.');

    return empty($this->errors);
  }

  public function addError(string $key, string $message): void
  {
    $this->errors[$key] = $message;
  }

  public function errors(): array
  {
    return $this->errors;
  }
}
