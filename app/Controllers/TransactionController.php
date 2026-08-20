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
    $search = trim($_GET['search'] ?? '');
    $type = $_GET['type'] ?? '';
    $category = $_GET['category'] ?? '';
    $categories = $this->categories();
    $sort = $_GET['sort'] ?? 'date_desc';
    $sortOptions = $this->sortOptions();

    if ($type !== '' && $type !== 'income' && $type !== 'expense') {
      throw new RuntimeException('Not a valid type filter.');
    }

    if ($category !== '' && !array_key_exists($category, $categories)) {
      throw new RuntimeException('Not a valid category filter.');
    }

    if ($sort !== '' && !array_key_exists($sort, $sortOptions)) {
      throw new RuntimeException('Not a valid sort option.');
    }

    $transactions = $search !== '' || $type !== '' || $category !== '' || $sort !== 'date_desc'
      ? $this->repository->filter($search, $type, $category, $sortOptions[$sort]['sql'])
      : $this->repository->findAll();

    view('transactions/index', [
      'transactions' => $transactions,
      'search' => $search,
      'type' => $type,
      'selectedCategory' => $category,
      'categories' => $categories,
      'selectedSort' => $sort,
      'sortOptions' => $sortOptions,
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

  private function sortOptions(): array
  {
    return require __DIR__ . '/../../config/sortOptions.php';
  }
}
