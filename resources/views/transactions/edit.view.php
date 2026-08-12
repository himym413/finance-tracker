<?php

/** @var string $pageTitle */
/** @var array $categories */
/** @var array $data */
/** @var string $id */
/** @var array $errors */

$errors ??= [];

?>

<?php view('partials/head', ['pageTitle' => $pageTitle]); ?>

<?php view('transactions/_form', [
  'data' => $data,
  'categories' => $categories,
  'errors' => $errors,
  'submitLabel' => 'Save Changes',
  'action' => "/transactions/{$data['id']}"
]); ?>

<?php view('partials/footer'); ?>