<?php

declare(strict_types=1);

return [
  'date_desc' => [
    'label' => 'Newest first',
    'sql' => 'created_at DESC',
  ],

  'date_asc' => [
    'label' => 'Oldest first',
    'sql' => 'created_at ASC',
  ],

  'amount_desc' => [
    'label' => 'Highest first',
    'sql' => 'amount DESC',
  ],

  'amount_asc' => [
    'label' => 'Lowest first',
    'sql' => 'amount ASC',
  ],
];
