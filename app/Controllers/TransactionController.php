<?php

/** @var object App\Repositories\TransactionRepository */
/** @var object App\Validation\Validator */

declare(strict_types=1);

namespace App\Controllers;

use App\Repositories\TransactionRepository;
use App\Validation\Validator;
use RuntimeException;

class TransactionController
{
  public function __construct(private TransactionRepository $repository, private Validator $validator) {}

  public function index(): void
  {
    $transactions = $this->repository->findAll();

    view('transactions/index', [
      'transactions' => $transactions,
      'pageTitle' => 'Transactions',
    ]);
  }

  public function create(): void
  {
    view('transactions/create', [
      'categories' => $this->categories(),
      'pageTitle' => 'Add Transaction',
    ]);
  }

  public function store(): void
  {
    $categories = $this->categories();

    $data = $this->transactionData();

    if (!$this->validator->validate($data, $categories)) {
      view('transactions/create', [
        'errors' => $this->validator->errors(),
        'data' => $data,
        'categories' => $categories,
        'pageTitle' => 'Add Transaction',
      ]);

      return;
    }

    $this->repository->create($data);

    flash('success', 'Transaction created successfully.');

    $this->redirectToIndex();
  }

  public function edit(string $id): void
  {
    $categories = $this->categories();
    $transaction = $this->findTransactionOrFail((int) $id);

    view('transactions/edit', [
      'data' => $transaction,
      'categories' => $categories,
      'pageTitle' => 'Edit Transaction',
    ]);
  }

  public function update(string $id): void
  {
    $categories = $this->categories();
    $this->findTransactionOrFail((int) $id);

    $data = $this->transactionData();

    if (!$this->validator->validate($data, $categories)) {
      $data['id'] = (int) $id;

      view("transactions/edit", [
        'errors' => $this->validator->errors(),
        'data' => $data,
        'categories' => $categories,
        'pageTitle' => 'Edit Transaction',
      ]);

      return;
    }

    $this->repository->update((int) $id, $data);

    flash('success', 'Transaction edited successfully.');

    $this->redirectToIndex();
  }

  public function destroy(string $id): void
  {
    $this->findTransactionOrFail((int) $id);

    $this->repository->delete((int) $id);

    flash('success', 'Transaction deleted successfully.');

    $this->redirectToIndex();
  }

  private function redirectToIndex(): never
  {
    header('Location: /transactions');
    exit();
  }

  private function transactionData(): array
  {
    return [
      'description' => trim($_POST['description'] ?? ''),
      'amount' => $_POST['amount'] ?? '',
      'type' => $_POST['type'] ?? '',
      'category' => $_POST['category'] ?? '',
    ];
  }

  private function findTransactionOrFail(int $id): array
  {
    $transaction = $this->repository->findById($id);

    if (!$transaction) {
      throw new RuntimeException('Transaction not found.');
    }

    return $transaction;
  }

  private function categories(): array
  {
    return require __DIR__ . '/../../config/categories.php';
  }
}
