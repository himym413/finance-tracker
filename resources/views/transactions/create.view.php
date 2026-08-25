<?php

/** @var array $errors */
/** @var array $data */
/** @var array $categories */
/** @var string $pageTitle */
/** @var string $backUrl */

$errors ??= [];

?>

<?php view('partials/head', ['pageTitle' => $pageTitle]) ?>

<?php view('transactions/_form', [
  'data' => $data,
  'categories' => $categories,
  'errors' => $errors ?? [],
  'submitLabel' => 'Add Transaction',
  'action' => '/transactions',
  'backUrl' => $backUrl,
]) ?>

<?php view('partials/footer') ?>