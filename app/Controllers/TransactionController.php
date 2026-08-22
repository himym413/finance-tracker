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
  private const PER_PAGE = 10;

  public function __construct(private TransactionRepository $repository, private Validator $validator) {}

  public function index(): void
  {
    $filters = [
      'search' => trim($_GET['search'] ?? ''),
      'type' => $_GET['type'] ?? '',
      'category' => $_GET['category'] ?? '',
      'sort' => $_GET['sort'] ?? 'date_desc',
    ];
    $categories = $this->categories();
    $sortOptions = $this->sortOptions();

    $this->validateFilters($filters, $categories, $sortOptions);

    $paginationData = $this->getPaginationData($filters);

    $transactions = $this->getTransactions($filters, $sortOptions, $paginationData['offset']);

    view('transactions/index', [
      'page' => $paginationData['page'],
      'totalPages' => $paginationData['totalPages'],
      'params' => $paginationData['params'],
      'transactions' => $transactions,
      'search' => $filters['search'],
      'type' => $filters['type'],
      'selectedCategory' => $filters['category'],
      'categories' => $categories,
      'selectedSort' => $filters['sort'],
      'sortOptions' => $sortOptions,
      'pageTitle' => 'Transactions',
    ]);
  }

  private function validateFilters(array $filters, array $categories, array $sortOptions): void
  {
    if ($filters['type'] !== '' && $filters['type'] !== 'income' && $filters['type'] !== 'expense') {
      throw new RuntimeException('Not a valid type filter.');
    }

    if ($filters['category'] !== '' && !array_key_exists($filters['category'], $categories)) {
      throw new RuntimeException('Not a valid category filter.');
    }

    if ($filters['sort'] !== '' && !array_key_exists($filters['sort'], $sortOptions)) {
      throw new RuntimeException('Not a valid sort option.');
    }
  }

  private function getPaginationData(array $filters): array
  {
    $params = $_GET;
    $totalResults = $this->repository->countFiltered($filters);
    $totalPages = max(1, (int) ceil($totalResults / self::PER_PAGE));
    $page = max(1, (int) ($_GET['page'] ?? 1));

    if ($page > $totalPages) {
      $page = $totalPages;
    }

    $offset = ($page - 1) * self::PER_PAGE;

    return [
      'params' => $params,
      'totalPages' => $totalPages,
      'page' => $page,
      'offset' => $offset,
    ];
  }

  private function getTransactions(array $filters, array $sortOptions, int $offset): array
  {
    $hasFilters = $filters['search'] !== '' || $filters['type'] !== '' || $filters['category'] !== '' || $filters['sort'] !== 'date_desc';

    return $hasFilters
      ? $this->repository->filter($filters, $sortOptions[$filters['sort']]['sql'], self::PER_PAGE, $offset)
      : $this->repository->findAll(self::PER_PAGE, $offset);
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

      view('transactions/edit', [
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
