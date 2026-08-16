<?php

/** @var array $transactions */
/** @var string $pageTitle */

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

  <?php if (empty($transactions)): ?>
    <div class="rounded-xl border border-dashed border-gray-300 bg-gray-50 px-6 py-12 text-center">
      <h2 class="text-base font-semibold text-gray-900">
        No transactions found
      </h2>

      <p class="mt-1 text-sm text-gray-500">
        Add your first income or expense to get started.
      </p>
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
  <?php endif; ?>
</div>

<?php view('transactions/confirmationModal') ?>

<?php view('partials/footer') ?>