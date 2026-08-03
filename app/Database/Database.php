<?php

declare(strict_types=1);

namespace App\Database;

use PDO;
use PDOStatement;

class Database
{
  private PDO $connection;
  private PDOStatement $statement;

  public function __construct(string $dsn)
  {
    $this->connection = new PDO($dsn);
  }

  public function query(string $query, array $params = []): self
  {
    $this->statement = $this->connection->prepare($query);
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