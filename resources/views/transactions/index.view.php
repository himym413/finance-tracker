<?php

/** @var array $transactions */
/** @var string $pageTitle */
/** @var string $search */
/** @var string $type */
/** @var string $selectedCategory */
/** @var array $categories */
/** @var string $selectedSort */
/** @var array $sortOptions */
/** @var int $page */
/** @var int $totalPages */
/** @var array $params */

?>

<?php view('partials/head', ['pageTitle' => $pageTitle]); ?>

<?php view('partials/flash'); ?>

<div class="mx-auto max-w-6xl p-6">
  <div class="mb-6 flex items-center justify-between gap-4">
    <div>
      <h1 class="text-2xl font-bold text-gray-900">
        Transactions
      </h1>

      <p class="mt-1 text-sm text-gray-500">
        Review and manage your income and expenses.
      </p>
    </div>

    <a
      href="/transactions/create"
      class="inline-flex shrink-0 items-center justify-center rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition-colors hover:bg-indigo-700 focus-visible:outline-none focus-visible:ring-4 focus-visible:ring-indigo-200">
      Add transaction
    </a>
  </div>

  <?php view('transactions/_filters', [
    'search' => $search,
    'type' => $type,
    'selectedCategory' => $selectedCategory,
    'categories' => $categories,
    'selectedSort' => $selectedSort,
    'sortOptions' => $sortOptions,
  ]); ?>

  <?php if (empty($transactions)): ?>
    <div class="rounded-xl border border-dashed border-gray-300 bg-gray-50 px-6 py-12 text-center">
      <h2 class="text-base font-semibold text-gray-900">
        No transactions found<?= $search !== '' ? ' for "' . htmlspecialchars($search) . '"' : '' ?>
      </h2>

      <?php if ($search === ''): ?>
        <p class="mt-1 text-sm text-gray-500">
          Add your first income or expense to get started.
        </p>
      <?php endif; ?>
    </div>
  <?php else: ?>
    <?php view('transactions/_table', ['transactions' => $transactions]); ?>

    <?php if ($totalPages > 1): ?>
      <?php view('transactions/_pagination', [
        'params' => $params,
        'page' => $page,
        'totalPages' => $totalPages,
      ]); ?>
    <?php endif; ?>

  <?php endif; ?>
</div>

<?php view('transactions/_confirmationModal'); ?>

<?php view('partials/footer'); ?>