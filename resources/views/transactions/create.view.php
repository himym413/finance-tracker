<?php

/** @var array $errors */
/** @var array $data */
/** @var array $categories */
/** @var string $pageTitle */

$errors ??= [];

?>

<?php view('partials/head', ['pageTitle' => $pageTitle]) ?>

<?php view('transactions/_form', [
  'data' => $data,
  'categories' => $categories,
  'errors' => $errors,
  'submitLabel' => 'Add Transaction',
  'action' => '/transactions'
]) ?>

<?php view('partials/footer') ?>