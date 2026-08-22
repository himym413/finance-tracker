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

<?php view('partials/head', ['pageTitle' => $pageTitle]) ?>

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

  <form action="/transactions" method="GET" class="mb-6 flex items-center gap-3">
    <input
      type="text"
      name="search"
      placeholder="Search transactions..."
      value="<?= htmlspecialchars($search) ?>"
      class="w-full max-w-[20rem] rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm text-gray-900 shadow-sm placeholder:text-gray-400 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200" />

    <select
      name="type"
      class="cursor-pointer rounded-lg border border-gray-300 bg-white px-2 py-2 text-sm text-gray-900 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200">
      <option value="">All types</option>
      <option value="income" <?= $type === 'income' ? 'selected' : '' ?>>
        Income
      </option>
      <option value="expense" <?= $type === 'expense' ? 'selected' : '' ?>>
        Expense
      </option>
    </select>

    <select
      name="category"
      class="cursor-pointer rounded-lg border border-gray-300 bg-white px-2 py-2 text-sm text-gray-900 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200">
      <option value="">All categories</option>
      <?php foreach ($categories as $category => $label): ?>
        <option
          value="<?= htmlspecialchars($category) ?>"
          <?= $selectedCategory === $category ? 'selected' : '' ?>>
          <?= htmlspecialchars($label) ?>
        </option>
      <?php endforeach; ?>
    </select>

    <label for="sort">Sort by:</label>
    <select
      id="sort"
      name="sort"
      class="cursor-pointer rounded-lg border border-gray-300 bg-white px-2 py-2 text-sm text-gray-900 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200">
      <?php foreach ($sortOptions as $value => $option): ?>
        <option
          value="<?= htmlspecialchars($value) ?>"
          <?= $selectedSort === $value ? 'selected' : '' ?>>
          <?= htmlspecialchars($option['label']) ?>
        </option>
      <?php endforeach; ?>
    </select>

    <button
      type="submit"
      class="cursor-pointer inline-flex items-center justify-center rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition-colors hover:bg-indigo-700 focus:outline-none focus:ring-4 focus:ring-indigo-200">
      Apply
    </button>

    <?php if ($search !== '' || $type !== '' || $selectedCategory !== '' || $selectedSort !== 'date_desc'): ?>
      <a
        href="/transactions"
        class="rounded-lg px-4 py-2 text-sm font-medium text-gray-600 transition-colors hover:bg-gray-100 hover:text-gray-900">
        Clear
      </a>
    <?php endif; ?>
  </form>

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
    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr class="text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
              <th class="px-4 py-3 whitespace-nowrap">Description</th>
              <th class="px-4 py-3 whitespace-nowrap">Amount</th>
              <th class="px-4 py-3 whitespace-nowrap">Type</th>
              <th class="px-4 py-3 whitespace-nowrap">Category</th>
              <th class="px-4 py-3 whitespace-nowrap">Date</th>
              <th class="px-4 py-3 text-right whitespace-nowrap">Actions</th>
            </tr>
          </thead>

          <tbody class="divide-y divide-gray-200">
            <?php foreach ($transactions as $transaction): ?>
              <?php
              $isIncome = $transaction['type'] === 'income';

              $amountColor = $isIncome
                ? 'text-green-600'
                : 'text-red-600';

              $typeBadge = $isIncome
                ? 'bg-green-50 text-green-700 ring-green-600/20'
                : 'bg-red-50 text-red-700 ring-red-600/20';
              ?>

              <tr class="transition-colors hover:bg-gray-50">
                <td class="px-4 py-3 text-sm font-medium whitespace-nowrap text-gray-900">
                  <?= htmlspecialchars($transaction['description']) ?>
                </td>

                <td class="px-4 py-3 text-sm font-semibold whitespace-nowrap <?= $amountColor ?>">
                  <?= number_format((float) $transaction['amount'], 2) ?> KM
                </td>

                <td class="px-4 py-3 whitespace-nowrap">
                  <span class="inline-flex rounded-full px-2.5 py-1 text-xs font-medium ring-1 ring-inset <?= $typeBadge ?>">
                    <?= htmlspecialchars(ucfirst($transaction['type'])) ?>
                  </span>
                </td>

                <td class="px-4 py-3 text-sm whitespace-nowrap text-gray-600">
                  <?= htmlspecialchars(ucfirst($transaction['category'])) ?>
                </td>

                <td class="px-4 py-3 text-sm whitespace-nowrap text-gray-600">
                  <?= date('d.m.Y.', strtotime($transaction['created_at'])) ?>
                </td>

                <td class="px-4 py-3 whitespace-nowrap">
                  <div class="flex justify-end gap-2">
                    <a
                      href="/transactions/<?= htmlspecialchars($transaction['id']) ?>/edit"
                      class="rounded-md px-3 py-1.5 text-sm font-medium text-indigo-600 transition-colors hover:bg-indigo-50 hover:text-indigo-700">
                      Edit
                    </a>


                    <button
                      type="button"
                      data-modal-open
                      data-transaction-id="<?= htmlspecialchars($transaction['id']) ?>"
                      class="cursor-pointer rounded-md px-3 py-1.5 text-sm font-medium text-red-600 transition-colors hover:bg-red-50 hover:text-red-700">
                      Delete
                    </button>

                  </div>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>

    <nav aria-label="Pagination">
      <ul class="flex justify-center gap-1 text-gray-900 mt-4">
        <li>
          <a
            href="/transactions?<?= http_build_query([
                                  ...$params,
                                  'page' => $page - 1 < 1 ? 1 : $page - 1,
                                ]) ?>"
            class=" grid size-8 place-content-center rounded border border-gray-200 transition-colors hover:bg-gray-50 rtl:rotate-180 <?= $page === 1 ? 'pointer-events-none opacity-40' : '' ?>"
            aria-label="Previous page"
            <?= $page === 1 ? 'aria-disabled="true"' : '' ?>>
            <svg
              aria-hidden="true"
              xmlns="http://www.w3.org/2000/svg"
              class="size-4"
              viewBox="0 0 20 20"
              fill="currentColor">
              <path
                fill-rule="evenodd"
                d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                clip-rule="evenodd" />
            </svg>
          </a>
        </li>

        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
          <li>
            <a
              href="/transactions?<?= http_build_query([
                                    ...$params,
                                    'page' => $i
                                  ]) ?>"
              class="block size-8 rounded border border-gray-200 text-center text-sm/8 font-medium transition-colors <?= $i === $page ? 'border-indigo-600 bg-indigo-600 text-white' : 'hover:bg-gray-50 hover:text-black' ?>">
              <?= $i ?>
            </a>
          </li>
        <?php endfor; ?>

        <li>
          <a
            href="/transactions?<?= http_build_query([
                                  ...$params,
                                  'page' => $page + 1 > $totalPages ? $page : $page + 1,
                                ]) ?>"
            class="grid size-8 place-content-center rounded border border-gray-200 transition-colors hover:bg-gray-50 rtl:rotate-180 <?= $page === $totalPages ? 'pointer-events-none opacity-40' : '' ?>"
            aria-label="Next page"
            <?= $page === $totalPages ? 'aria-disabled="true"' : '' ?>>
            <svg
              aria-hidden="true"
              xmlns="http://www.w3.org/2000/svg"
              class="size-4"
              viewBox="0 0 20 20"
              fill="currentColor">
              <path
                fill-rule="evenodd"
                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                clip-rule="evenodd" />
            </svg>
          </a>
        </li>
      </ul>
    </nav>
  <?php endif; ?>
</div>

<?php view('transactions/confirmationModal') ?>

<?php view('partials/footer') ?>