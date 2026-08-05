<?php

declare(strict_types=1);

namespace App\Database;

use PDO;
use PDOStatement;
use RuntimeException;

class Database
{
  private PDO $connection;
  private PDOStatement $statement;

  public function __construct(array $config)
  {
    $dsn = sprintf(
      '%s:host=%s;port=%d;dbname=%s;charset=%s',
      $config['driver'],
      $config['host'],
      $config['port'],
      $config['dbname'],
      $config['charset']
    );

    $this->connection = new PDO(
      $dsn,
      $config['username'],
      $config['password'],
      [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
      ]
    );
  }

  public function query(string $query, array $params = []): self
  {
    $statement = $this->connection->prepare($query);

    if ($statement === false) {
      throw new RuntimeException('Failed to prepare database query.');
    }

    $this->statement = $statement;
    $this->statement->execute($params);

    return $this;
  }

  public function find(): array|false
  {
    return $this->statement->fetch();
  }

  public function findAll(): array
  {
    return $this->statement->fetchAll();
  }
}
