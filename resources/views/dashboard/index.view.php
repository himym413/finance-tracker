<?php

/** @var string $pageTitle */
/** @var float $totalIncome */
/** @var float $totalExpense */
/** @var float $balance */
/** @var int $totalTransactions */
/** @var array $transactions */

?>

<?php view('partials/head', ['pageTitle' => $pageTitle]); ?>

<div class="flex flex-1 flex-col overflow-y-auto">
  <header class="flex items-center justify-between border-b border-gray-200 bg-white px-6 py-4">
    <h1 class="text-lg font-semibold text-gray-900">
      Welcome <?= htmlspecialchars($_SESSION['user_name'] ?? 'User') ?>
    </h1>

    <form action="/logout" method="POST">
      <button
        type="submit"
        class="inline-flex cursor-pointer items-center rounded-lg border border-red-200 bg-red-50 px-4 py-2 text-sm font-semibold text-red-700 transition-colors hover:bg-red-100 hover:border-red-300 focus:outline-none focus:ring-4 focus:ring-red-200">
        Logout
      </button>
    </form>
  </header>

  <main class="flex-1 space-y-6 p-6">
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-4">

      <?php
      $balanceColor = 'text-gray-900';

      if ($balance > 0) {
        $balanceColor = 'text-green-600';
      } elseif ($balance < 0) {
        $balanceColor = 'text-red-600';
      }
      ?>

      <article class="flex flex-col gap-4 rounded-lg border border-gray-200 bg-white p-6">
        <div>
          <strong class="block text-sm font-medium text-gray-600">Balance</strong>

          <p>
            <span class="text-2xl font-medium text-gray-900 <?= $balanceColor ?>"><?= number_format($balance, 2) ?> KM</span>
          </p>
        </div>
      </article>

      <article class="flex flex-col gap-4 rounded-lg border border-gray-200 bg-white p-6">
        <div>
          <strong class="block text-sm font-medium text-gray-600">Total income</strong>

          <p>
            <span class="text-2xl font-medium text-gray-900"><?= number_format($totalIncome, 2) ?> KM</span>
          </p>
        </div>
      </article>

      <article class="flex flex-col gap-4 rounded-lg border border-gray-200 bg-white p-6">
        <div>
          <strong class="block text-sm font-medium text-gray-600">Total expense</strong>

          <p>
            <span class="text-2xl font-medium text-gray-900"><?= number_format($totalExpense, 2) ?> KM</span>
          </p>
        </div>
      </article>

      <article class="flex flex-col gap-4 rounded-lg border border-gray-200 bg-white p-6">
        <div>
          <strong class="block text-sm font-medium text-gray-600">Total transactions</strong>

          <p>
            <span class="text-2xl font-medium text-gray-900"><?= $totalTransactions ?></span>
          </p>
        </div>
      </article>
    </div>

    <?php if (empty($transactions)): ?>
      <div class="rounded-xl border border-dashed border-gray-300 bg-gray-50 px-6 py-12 text-center">
        <h2 class="text-base font-semibold text-gray-900">
          No recent transactions
        </h2>

        <p class="mt-1 text-sm text-gray-500">
          Add your first transaction to see it on your dashboard.
        </p>

        <a
          href="/transactions/create"
          class="mt-4 inline-flex items-center rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white transition-colors hover:bg-indigo-700">
          Add transaction
        </a>
      </div>
    <?php else: ?>

      <div class="flex justify-between items-center">
        <h2 class="text-md font-semibold text-gray-800">Recent transactions</h2>

        <a
          href="/transactions"
          class="cursor-pointer inline-flex items-center justify-center rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition-colors hover:bg-indigo-700 focus:outline-none focus:ring-4 focus:ring-indigo-200">
          View all &rarr;
        </a>
      </div>

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
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>

    <?php endif; ?>
  </main>
</div>

<?php view('partials/footer'); ?>