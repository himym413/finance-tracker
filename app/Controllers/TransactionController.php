<?php

/** @var object App\Repositories\TransactionRepository */
/** @var object App\Validation\Validator */

declare(strict_types=1);

namespace App\Controllers;

use App\Repositories\TransactionRepository;
use App\Validation\Validator;

class TransactionController
{
  public function __construct(private TransactionRepository $repository, private Validator $validator) {}

  public function index(): void
  {
    $transactions = $this->repository->findAll();

    view('transactions/index', [
      'transactions' => $transactions,
    ]);
  }

  public function create(): void
  {
    view('transactions/create', [
      'categories' => $this->categories(),
    ]);
  }

  public function store(): void
  {
    $categories = $this->categories();

    $data = [
      'description' => trim($_POST['description'] ?? ''),
      'amount' => $_POST['amount'] ?? '',
      'type' => $_POST['type'] ?? '',
      'category' => $_POST['category'] ?? '',
    ];

    if (!$this->validator->validate($data, $categories)) {
      view('transactions/create', [
        'errors' => $this->validator->errors(),
        'old' => $data,
        'categories' => $categories,
      ]);

      return;
    }

    $this->repository->create($data);

    header('Location: /transactions');
    exit();
  }

  private function categories(): array
  {
    return require __DIR__ . '/../../config/categories.php';
  }
}
