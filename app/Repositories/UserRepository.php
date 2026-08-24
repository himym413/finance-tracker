<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Database\Database;

class UserRepository
{
  public function __construct(private Database $db) {}

  public function findByEmail(string $email): array|false
  {
    return $this->db->query(
      'SELECT * FROM users WHERE email = :email',
      ['email' => $email]
    )->find();
  }

  public function create(array $data): void
  {
    $this->db->query(
      'INSERT INTO users (name, email, password) VALUES (:name, :email, :password)',
      [
        'name' => $data['name'],
        'email' => $data['email'],
        'password' => $data['password'],
      ]
    );
  }
}
