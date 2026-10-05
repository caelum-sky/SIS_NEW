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

// Production must never print PHP warnings/deprecations into the HTML
// (invalid HTML and breaks rendering); errors still land in Vercel stderr logs.
error_reporting(E_ALL & ~E_DEPRECATED & ~E_NOTICE);
ini_set('display_errors', '0');

// On serverless the single-channel log file can't be written; send logs to
// stderr so they show up in the Vercel function logs.
if (empty($_ENV['LOG_CHANNEL']) && empty($_SERVER['LOG_CHANNEL']) && getenv('LOG_CHANNEL') === false) {
    $_ENV['LOG_CHANNEL'] = 'stderr';
    $_SERVER['LOG_CHANNEL'] = 'stderr';
    putenv('LOG_CHANNEL=stderr');
}

require __DIR__.'/../vendor/autoload.php';

/** @var Application $app */
$app = require_once __DIR__.'/../bootstrap/app.php';

$app->useStoragePath($storagePath);

// Blade looks for its compiled views under storage_path(); after we moved
// storage to /tmp, point it at the deployment's pre-compiled views (from
// `php artisan view:cache` at build time), which are read-only.
$deployedViews = __DIR__.'/../storage/framework/views';
if (is_dir($deployedViews)) {
    $app['config']->set('view.compiled', $deployedViews);
}

// Also make /tmp's own compiled-views dir writable for Blade (cache fallback).

if (! is_dir($storagePath.'/framework/views')) {
    @mkdir($storagePath.'/framework/views', 0777, true);
}

// Vercel terminates TLS at the edge, but APP_URL may still say http://.
// Force https:// URLs/routes so the browser doesn't get mixed-content warnings.
if (! empty($_SERVER['VERCEL']) || ($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '') === 'https' || ($_SERVER['HTTPS'] ?? '') === 'on') {
    $app['url']->forceScheme('https');
}

$app->handleRequest(Request::capture());
