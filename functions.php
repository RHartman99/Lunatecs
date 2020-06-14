<?php

$composer_autoload = __DIR__ . '/vendor/autoload.php';
if (file_exists($composer_autoload)) {
  require_once $composer_autoload;
  $timber = new Timber\Timber();
}

require_once('library/theme.php');
require_once('library/setup.php');
require_once('library/cleanup.php');
require_once('library/admin.php');

require_once('library/timber.php');
