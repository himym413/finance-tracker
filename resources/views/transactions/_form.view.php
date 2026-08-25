<?php

/** @var array $categories */
/** @var string $submitLabel */
/** @var array $data */
/** @var array $errors */
/** @var string $action */
/** @var string $backUrl */

?>

<div class="p-6">
  <a
    href="<?= htmlspecialchars($backUrl) ?>"
    class="mb-6 inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm transition-all hover:border-gray-400 hover:bg-gray-50 hover:text-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-200">
    <svg
      xmlns="http://www.w3.org/2000/svg"
      class="size-4"
      fill="none"
      viewBox="0 0 24 24"
      stroke="currentColor"
      stroke-width="2">
      <path
        stroke-linecap="round"
        stroke-linejoin="round"
        d="M15 19l-7-7 7-7" />
    </svg>

    Go back
  </a>

  <form
    action="<?= htmlspecialchars($action) ?>" method="POST"
    class="mx-auto max-w-md space-y-4 rounded-lg border border-gray-300 bg-gray-100 p-6">
    <div>
      <label class="block text-sm font-medium text-gray-900" for="description">Description</label>

      <textarea class="mt-1 w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:outline-none bg-white p-1.5"
        id="description"
        name="description"
        placeholder="Add a short description..."><?= htmlspecialchars($data['description'] ?? '') ?></textarea>

      <?php if (isset($errors['description'])): ?>
        <p class="mt-1 text-sm text-red-600">
          <?= htmlspecialchars($errors['description']) ?>
        </p>
      <?php endif; ?>
    </div>

    <div>
      <label class="block text-sm font-medium text-gray-900" for="amount">Amount</label>

      <input
        class="mt-1 w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:outline-none bg-white p-1.5"
        id="amount"
        name="amount"
        type="number"
        min="0.01"
        step="0.01"
        value="<?= htmlspecialchars($data['amount'] ?? '') ?>"
        placeholder="Enter the amount..." />

      <?php if (isset($errors['amount'])): ?>
        <p class="mt-1 text-sm text-red-600">
          <?= htmlspecialchars($errors['amount']) ?>
        </p>
      <?php endif; ?>
    </div>

    <div>
      <label class="block text-sm font-medium text-gray-900" for="type">Type</label>

      <select
        class="mt-1 w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:outline-none bg-white p-1.5"
        id="type" name="type">
        <option value="">Select type</option>
        <option value="income" <?= ($data['type'] ?? '') === 'income' ? 'selected' : '' ?>>Income</option>
        <option value="expense" <?= ($data['type'] ?? '') === 'expense' ? 'selected' : '' ?>>Expense</option>
      </select>

      <?php if (isset($errors['type'])): ?>
        <p class="mt-1 text-sm text-red-600">
          <?= htmlspecialchars($errors['type']) ?>
        </p>
      <?php endif; ?>
    </div>

    <div>
      <label class="block text-sm font-medium text-gray-900" for="category">Category</label>

      <select
        class="mt-1 w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:outline-none bg-white p-1.5"
        id="category" name="category">
        <option value="">Select a category</option>
        <?php foreach ($categories as $category => $label): ?>
          <option
            value="<?= htmlspecialchars($category) ?>"
            <?= ($data['category'] ?? '') === $category ? 'selected' : '' ?>>
            <?= htmlspecialchars($label) ?>
          </option>
        <?php endforeach; ?>
      </select>

      <?php if (isset($errors['category'])): ?>
        <p class="mt-1 text-sm text-red-600">
          <?= htmlspecialchars($errors['category']) ?>
        </p>
      <?php endif; ?>
    </div>

    <input
      type="hidden"
      name="_token"
      value="<?= htmlspecialchars(csrfToken()) ?>">

    <input
      type="hidden"
      name="_back_url"
      value="<?= htmlspecialchars($backUrl) ?>">

    <button
      class="block w-full cursor-pointer rounded-lg border border-indigo-600 bg-indigo-600 px-12 py-3 text-sm font-medium text-white transition-colors hover:bg-indigo-800"
      type="submit">
      <?= htmlspecialchars($submitLabel) ?>
    </button>
  </form>
</div>