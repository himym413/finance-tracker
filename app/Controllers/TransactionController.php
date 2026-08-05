<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Repositories\TransactionRepository;

class TransactionController
{
  public function __construct(private TransactionRepository $repository) {}

  public function index(): void
  {
    $transactions = $this->repository->findAll();

    view('transactions/index', [
      'transactions' => $transactions,
    ]);
  }
}
