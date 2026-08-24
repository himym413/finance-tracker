<?php view('partials/head', ['pageTitle' => 'Register']); ?>

<?php view('auth/_form', [
  'action' => '/register',
  'data' => $data ?? [],
  'errors' => $errors ?? [],
]); ?>

<?php view('partials/footer'); ?>