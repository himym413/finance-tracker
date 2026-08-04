<?php 

declare(strict_types=1);

namespace App\Controllers;

use App\Database\Database;

class DashboardController
{
  public function __construct(private Database $db)
  {
    
  }

  public function index(): void 
  {
    view('dashboard/index', [
      'title' => 'Dashboard',
      'user' => 'Igor'
    ]);
  }
}