<?php view('partials/head', ['pageTitle' => 'Page Not Found']); ?>

<div class="mx-auto flex min-h-[70vh] max-w-md items-center justify-center px-6 text-center">
  <div>
    <p class="text-md font-semibold text-indigo-600">500</p>

    <h1 class="mt-2 text-3xl font-bold text-gray-900">
      Something went wrong
    </h1>

    <p class="mt-4 text-gray-600">
      An unexpected error occurred. Please try again later.
    </p>

    <div class="mt-6 flex justify-center gap-3">
      <a
        href="/"
        class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700">
        Dashboard
      </a>

      <a
        href="/transactions"
        class="rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">
        Transactions
      </a>
    </div>
  </div>
</div>

<?php view('partials/footer'); ?>