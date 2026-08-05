<?php

/** @var array $transactions */

?>

<?php view('partials/head') ?>

<?php if (empty($transactions)): ?>
  <p>No transactions found.</p>
<?php else: ?>
  <div class="flex flex-col mx-auto max-w-6xl p-6">
    <div class="overflow-x-auto mb-6">
      <table class="min-w-full divide-y-2 divide-gray-200">
        <thead class="ltr:text-left rtl:text-right">
          <tr class="*:font-medium *:text-gray-900">
            <th class="px-3 py-2 whitespace-nowrap">Description</th>
            <th class="px-3 py-2 whitespace-nowrap">Amount</th>
            <th class="px-3 py-2 whitespace-nowrap">Type</th>
            <th class="px-3 py-2 whitespace-nowrap">Category</th>
            <th class="px-3 py-2 whitespace-nowrap">Date</th>
          </tr>
        </thead>

        <tbody class="divide-y divide-gray-200 *:even:bg-gray-50">
          <?php foreach ($transactions as $transaction): ?>

            <?php
            $typeColor = $transaction['type'] === 'income'
              ? 'text-green-600'
              : 'text-red-600';
            ?>

            <tr class="*:first:font-medium">
              <td class="px-3 py-2 whitespace-nowrap text-gray-900"><?= htmlspecialchars($transaction['description']) ?></td>
              <td class="px-3 py-2 whitespace-nowrap <?= $typeColor ?>"><?= htmlspecialchars($transaction['amount']) ?></td>
              <td class="px-3 py-2 whitespace-nowrap <?= $typeColor ?>"><?= htmlspecialchars($transaction['type']) ?></td>
              <td class="px-3 py-2 whitespace-nowrap text-gray-900"><?= htmlspecialchars($transaction['category']) ?></td>
              <td class="px-3 py-2 whitespace-nowrap text-gray-900"><?= date("d.m.Y.", strtotime($transaction['created_at'])) ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>

    <a
      class="inline-flex items-center justify-center ml-auto rounded-full border border-indigo-600 bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition-colors hover:bg-indigo-700 focus-visible:ring-4 focus-visible:ring-indigo-200 focus-visible:outline-none"
      href="/transactions/create">
      Add new transaction
    </a>
  </div>
<?php endif; ?>

<?php view('partials/footer') ?>