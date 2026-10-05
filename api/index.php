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

// The deployment's bundled compiled views can't be modified (read-only bundle),
// so copy them into the tmp storage for Blade to read during booting.
$bundledViews = __DIR__.'/../storage/framework/views';
if (is_dir($bundledViews)) {
    foreach (glob($bundledViews.'/*.php') as $bundled) {
        @copy($bundled, $storagePath.'/framework/views/'.basename($bundled));
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

// Vercel terminates TLS at the edge, but the request may still look like http.
// Override the canonical URL env before config load so assets/routes are https.
if (! empty($_SERVER['VERCEL']) || ($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '') === 'https' || ($_SERVER['HTTPS'] ?? '') === 'on') {
    $_SERVER['REQUEST_SCHEME'] = 'https';
    $_SERVER['HTTPS'] = 'on';
    $_SERVER['SERVER_PORT'] = 443;
    $host = $_SERVER['HTTP_HOST'] ?? '';
    if ($host !== '') {
        $_ENV['APP_URL'] = 'https://'.$host;
        $_SERVER['APP_URL'] = 'https://'.$host;
        putenv('APP_URL=https://'.$host);
    }
}

$app->handleRequest(Request::capture());
