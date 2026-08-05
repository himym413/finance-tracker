<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Database\Database;

class TransactionRepository
{
  public function __construct(private Database $db) {}

  public function findAll(): array
  {
    return $this->db
      ->query('SELECT * FROM transactions')
      ->findAll();
  }
}
