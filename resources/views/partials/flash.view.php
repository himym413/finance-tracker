<?php $message = flash('success'); ?>

<?php if ($message): ?>
  <div class="mx-auto mt-4 max-w-6xl rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
    <?= htmlspecialchars($message) ?>
  </div>
<?php endif; ?>