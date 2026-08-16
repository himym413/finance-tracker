<?php

declare(strict_types=1);

namespace App\Validation;

class Validator
{
  private array $errors = [];

  public function validate(array $data, array $categories): bool
  {
    $this->errors = [];

    foreach ($data as $key => $value) {
      if (trim((string) $value) === '') {
        $this->addError($key, ucfirst($key) . ' is required.');
      }
    }

    if (
      !isset($this->errors['amount']) &&
      (!is_numeric($data['amount']) || (float) $data['amount'] <= 0)
    ) {
      $this->addError('amount', 'Amount must be greater than zero.');
    }

    if (!isset($this->errors['type']) && !in_array($data['type'], ['income', 'expense'], true)) {
      $this->addError('type', 'Type must be either income or expense.');
    }

    if (!isset($this->errors['category']) && !array_key_exists($data['category'], $categories)) {
      $this->addError('category', 'Please choose available category.');
    }

    return empty($this->errors);
  }

  private function addError(string $key, string $message): void
  {
    $this->errors[$key] = $message;
  }

  public function errors(): array
  {
    return $this->errors;
  }
}
