<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

// Vercel's filesystem is read-only except /tmp — redirect storage there.
$storagePath = sys_get_temp_dir().'/laravel-storage';
foreach (['', '/app/public', '/framework', '/framework/cache', '/framework/sessions', '/framework/views', '/logs'] as $dir) {
    if (! is_dir($storagePath.$dir)) {
        @mkdir($storagePath.$dir, 0777, true);
    }
}

define('LARAVEL_START', microtime(true));

require __DIR__.'/../vendor/autoload.php';

/** @var Application $app */
$app = require_once __DIR__.'/../bootstrap/app.php';

$app->useStoragePath($storagePath);

$app->handleRequest(Request::capture());
