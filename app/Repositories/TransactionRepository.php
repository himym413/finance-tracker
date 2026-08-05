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

  public function create(array $data): void
  {
    $this->db->query(
      'INSERT INTO transactions (
          amount, 
          type, 
          description, 
          category
        ) VALUES (
          :amount, 
          :type, 
          :description, 
          :category
        )',
      [
        ':amount' => $data['amount'],
        ':type' => $data['type'],
        ':description' => $data['description'],
        ':category' => $data['category'],
      ]
    );
  }
}
