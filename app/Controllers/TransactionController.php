<?php

/** @var object App\Repositories\TransactionRepository */

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

  public function create(): void
  {
    view('transactions/create');
  }

  public function store(): void
  {
    $data = [
      'description' => $_POST['description'],
      'amount' => $_POST['amount'],
      'type' => $_POST['type'],
      'category' => $_POST['category'],
    ];

    $this->repository->create($data);

    header('Location: /transactions');
    exit();
  }
}
