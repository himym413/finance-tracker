<?php view('partials/head', ['pageTitle' => 'Page Not Found']); ?>

<div class="mx-auto flex min-h-[70vh] max-w-md items-center justify-center px-6 text-center">
  <div>
    <p class="text-md font-semibold text-indigo-600">404</p>

    <h1 class="mt-2 text-3xl font-bold text-gray-900">
      Page not found
    </h1>

    <p class="mt-4 text-gray-600">
      Sorry, the page you are looking for doesn't exist or has been moved.
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