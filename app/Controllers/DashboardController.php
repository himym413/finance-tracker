<?php 

declare(strict_types=1);

namespace App\Controllers;

class DashboardController
{
  public function index(): void 
  {
    view('dashboard/index', [
      'title' => 'Dashboard',
      'user' => 'Igor'
    ]);
  }
}