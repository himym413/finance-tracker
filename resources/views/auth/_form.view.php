<?php

/** @var string $action */
/** @var array $data */
/** @var array $errors */

$isRegister = $action === '/register';

?>

<div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
  <div class="sm:mx-auto sm:w-full sm:max-w-sm">
    <h2 class="mt-10 text-center text-2xl/9 font-bold tracking-tight text-gray-900"><?= $isRegister ? 'Create a new account' : 'Sign in to your account' ?></h2>
  </div>

  <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">

    <?php if (isset($errors['login'])): ?>
      <p class="mt-1 mb-2 text-sm text-red-600">
        <?= htmlspecialchars($errors['login']) ?>
      </p>
    <?php endif; ?>

    <form action="<?= htmlspecialchars($action) ?>" method="POST" class="space-y-6">
      <?php if ($isRegister): ?>
        <div>
          <label for="name" class="block text-sm/6 font-medium text-gray-900">Name</label>
          <div class="mt-1">
            <input id="name" value="<?= htmlspecialchars($data['name'] ?? '') ?>" type="text" name="name" class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" />
          </div>

          <?php if (isset($errors['name'])): ?>
            <p class="mt-1 text-sm text-red-600">
              <?= htmlspecialchars($errors['name']) ?>
            </p>
          <?php endif; ?>
        </div>
      <?php endif; ?>

      <div>
        <label for="email" class="block text-sm/6 font-medium text-gray-900">Email address</label>
        <div class="mt-1">
          <input id="email" value="<?= htmlspecialchars($data['email'] ?? '') ?>" type="email" name="email" class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" />
        </div>

        <?php if (isset($errors['email'])): ?>
          <p class="mt-1 text-sm text-red-600">
            <?= htmlspecialchars($errors['email']) ?>
          </p>
        <?php endif; ?>
      </div>

      <div>
        <label for="password" class="block text-sm/6 font-medium text-gray-900">Password</label>
        <div class="mt-1">
          <input id="password" type="password" name="password" class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" />
        </div>

        <?php if (isset($errors['password'])): ?>
          <p class="mt-1 text-sm text-red-600">
            <?= htmlspecialchars($errors['password']) ?>
          </p>
        <?php endif; ?>
      </div>

      <?php if ($isRegister): ?>
        <div>
          <label for="password_confirmation" class="block text-sm/6 font-medium text-gray-900">Confirm Password</label>
          <div class="mt-1">
            <input id="password_confirmation" type="password" name="password_confirmation" class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" />
          </div>

          <?php if (isset($errors['password_confirmation'])): ?>
            <p class="mt-1 text-sm text-red-600">
              <?= htmlspecialchars($errors['password_confirmation']) ?>
            </p>
          <?php endif; ?>
        </div>
      <?php endif; ?>

      <div>
        <button type="submit" class="cursor-pointer flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm/6 font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"><?= $isRegister ? 'Create account' : 'Sign in' ?></button>
      </div>
    </form>

    <p class="mt-10 text-center text-sm/6 text-gray-500">
      <?= $isRegister ? "Already have an account?" : "Don't have an account?" ?>
      <a href="<?= $isRegister ? '/login' : '/register' ?>" class="font-semibold text-indigo-600 hover:text-indigo-500"><?= $isRegister ? 'Sign in' : 'Register' ?></a>
    </p>
  </div>
</div>