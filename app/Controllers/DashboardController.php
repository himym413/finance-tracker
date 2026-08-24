<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Repositories\TransactionRepository;

class DashboardController
{
  private const DASHBOARD_DISPLAY = 5;

  public function __construct(private TransactionRepository $repository) {}

  public function index(): void
  {
    $summary = $this->repository->summary();
    $transactions = $this->repository->findAll(self::DASHBOARD_DISPLAY, 0);

    view('dashboard/index', [
      'pageTitle' => 'Dashboard',
      'user' => 'Igor',
      'totalIncome' => $summary['totalIncome'],
      'totalExpense' => $summary['totalExpense'],
      'balance' => $summary['balance'],
      'totalTransactions' => $summary['totalTransactions'],
      'transactions' => $transactions,
    ]);
  }
}
