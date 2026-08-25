<?php view('partials/head', ['pageTitle' => 'Page Expired']); ?>

<?php view('errors/_error', [
  'code' => '419',
  'title' => 'Page expired',
  'description' => "Your session has expired or the form is no longer valid.
      Please go back and try again.",
]) ?>

<?php view('partials/footer'); ?>