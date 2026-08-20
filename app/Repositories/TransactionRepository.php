<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Database\Database;

class TransactionRepository
{
  public function __construct(private Database $db) {}

  public function findById(int $id): array|false
  {
    return $this->db
      ->query(
        'SELECT * FROM transactions WHERE id = :id',
        ['id' => $id]
      )
      ->find();
  }

  public function findAll(): array
  {
    return $this->db
      ->query('SELECT * FROM transactions ORDER BY created_at DESC')
      ->findAll();
  }

  public function filter(string $search, string $type, string $category): array
  {
    $sql = 'SELECT * FROM transactions WHERE 1=1';
    $params = [];

    if ($search !== '') {
      $sql .= ' AND description LIKE :search';
      $params['search'] = "%{$search}%";
    }

    if ($type !== '') {
      $sql .= ' AND type = :type';
      $params['type'] = $type;
    }

    if ($category !== '') {
      $sql .= ' AND category = :category';
      $params['category'] = $category;
    }

    $sql .= ' ORDER BY created_at DESC';

    return $this->db
      ->query($sql, $params)
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
        'amount' => $data['amount'],
        'type' => $data['type'],
        'description' => $data['description'],
        'category' => $data['category'],
      ]
    );
  }

  public function update(int $id, array $data): void
  {
    $this->db->query(
      'UPDATE transactions SET
        amount = :amount,
        type = :type,
        description = :description,
        category = :category
         WHERE id = :id',
      [
        'amount' => $data['amount'],
        'type' => $data['type'],
        'description' => $data['description'],
        'category' => $data['category'],
        'id' => $id,
      ]
    );
  }

  public function delete(int $id): void
  {
    $this->db->query(
      'DELETE FROM transactions WHERE id = :id',
      ['id' => $id]
    );
  }
}
