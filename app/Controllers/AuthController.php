<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Repositories\UserRepository;
use App\Validation\AuthValidator;

class AuthController
{
  public function __construct(private UserRepository $repository, private AuthValidator $validator) {}

  public function login(): void
  {
    view('auth/login');
  }

  public function register(): void
  {
    view('auth/register');
  }

  public function store(): void
  {
    $data = $this->authData('register');

    if (! $this->validator->validate($data)) {
      view(
        'auth/register',
        [
          'data' => $data,
          'errors' => $this->validator->errors()
        ]
      );

      return;
    }

    $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

    $this->repository->create($data);

    flash('success', 'Account created successfully.');

    redirect('/login');
  }

  public function authenticate(): void
  {
    $data = $this->authData('login');

    $user = $this->repository->findByEmail($data['email']);

    if (!$user || !password_verify($data['password'], $user['password'])) {
      view('auth/login', [
        'data' => $data,
        'errors' => [
          'login' => 'Invalid email or password.'
        ],
      ]);

      return;
    }

    session_regenerate_id(true);
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['user_name'] = $user['name'];

    redirect('/');
  }

  public function logout(): void
  {
    $_SESSION = [];

    session_destroy();

    redirect('/login');
  }

  private function authData(string $type): array
  {
    $data = [
      'email' => trim($_POST['email'] ?? ''),
      'password' => $_POST['password'] ?? '',
    ];

    if ($type === 'login') return $data;

    return [
      ...$data,
      'name' => trim($_POST['name'] ?? ''),
      'password_confirmation' => $_POST['password_confirmation'] ?? '',
    ];
  }
}
