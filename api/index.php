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

// Vercel terminates TLS at the edge, but APP_URL may still say http://.
// Force https:// URLs/routes so the browser doesn't get mixed-content warnings.
if (! empty($_SERVER['VERCEL']) || ($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '') === 'https' || ($_SERVER['HTTPS'] ?? '') === 'on') {
    $app['url']->forceScheme('https');
}

$app->handleRequest(Request::capture());
