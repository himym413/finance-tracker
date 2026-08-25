<?php view('partials/head', ['pageTitle' => 'Server Error']); ?>

<?php view('errors/_error', [
  'code' => '500',
  'title' => 'Something went wrong',
  'description' => "An unexpected error occurred. Please try again later.",
]) ?>

<?php view('partials/footer'); ?>