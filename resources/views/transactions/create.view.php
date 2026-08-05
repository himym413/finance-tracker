<?php view('partials/head') ?>

<div class="p-6">
  <form
    action="/transactions" method="POST"
    class="mx-auto max-w-md space-y-4 rounded-lg border border-gray-300 bg-gray-100 p-6">
    <div>
      <label class="block text-sm font-medium text-gray-900" for="description">Description</label>

      <textarea class="mt-1 w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:outline-none bg-white p-1.5"
        id="description" name="description" placeholder="Add a short description..."></textarea>
    </div>

    <div>
      <label class="block text-sm font-medium text-gray-900" for="amount">Amount</label>

      <input
        class="mt-1 w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:outline-none bg-white p-1.5"
        id="amount"
        name="amount"
        type="number"
        step="0.01"
        placeholder="Enter the amount..." />
    </div>

    <div>
      <label class="block text-sm font-medium text-gray-900" for="type">Type</label>

      <select
        class="mt-1 w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:outline-none bg-white p-1.5"
        id="type" name="type">
        <option value="">Select type</option>
        <option value="income">Income</option>
        <option value="expense">Expense</option>
      </select>
    </div>

    <div>
      <label class="block text-sm font-medium text-gray-900" for="category">Category</label>

      <select
        class="mt-1 w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:outline-none bg-white p-1.5"
        id="category" name="category">
        <option value="">Select a category</option>
        <option value="salary">Salary</option>
        <option value="housing">Housing</option>
        <option value="utilities">Utilities</option>
        <option value="food">Food</option>
        <option value="transportation">Transportation</option>
        <option value="healthcare">Healthcare</option>
        <option value="personal">Personal</option>
      </select>
    </div>

    <button
      class="block w-full cursor-pointer rounded-lg border border-indigo-600 bg-indigo-600 px-12 py-3 text-sm font-medium text-white transition-colors hover:bg-indigo-800"
      type="submit">
      Add transaction
    </button>
  </form>
</div>

<?php view('partials/footer') ?>