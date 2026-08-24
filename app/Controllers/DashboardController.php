<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Repositories\TransactionRepository;

class DashboardController
{
  private const DISPLAY_LATEST = 5;

  public function __construct(private TransactionRepository $repository) {}

  public function index(): void
  {
    $summary = $this->repository->summary(userId());
    $transactions = $this->repository->findAll(userId(), self::DISPLAY_LATEST, 0);

    view('dashboard/index', [
      'pageTitle' => 'Dashboard',
      'totalIncome' => $summary['totalIncome'],
      'totalExpense' => $summary['totalExpense'],
      'balance' => $summary['balance'],
      'totalTransactions' => $summary['totalTransactions'],
      'transactions' => $transactions,
    ]);
  }
}
