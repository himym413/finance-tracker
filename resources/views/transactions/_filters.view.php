<?php

/** @var string $search */
/** @var string $type */
/** @var string $selectedCategory */
/** @var array $categories */
/** @var string $selectedSort */
/** @var array $sortOptions */

?>



<form action="/transactions" method="GET" class="mb-6 flex flex-wrap md:flex-row md:flex-nowrap items-center gap-3">
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

  <div class="flex items-center gap-2">
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
  </div>

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