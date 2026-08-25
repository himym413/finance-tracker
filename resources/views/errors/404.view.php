<?php view('partials/head', ['pageTitle' => 'Page Not Found']); ?>

<?php view('errors/_error', [
  'code' => '404',
  'title' => 'Page not found',
  'description' => "Sorry, the page you are looking for doesn't exist or has been moved.",
]) ?>

<?php view('partials/footer'); ?>