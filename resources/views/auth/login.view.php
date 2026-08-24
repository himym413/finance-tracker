<?php view('partials/head', ['pageTitle' => 'Login']); ?>

<?php view('partials/flash'); ?>

<?php view('auth/_form', [
  'action' => '/login',
  'data' => $data ?? [],
  'errors' => $errors ?? [],
]); ?>

<?php view('partials/footer'); ?>