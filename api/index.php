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

// Serve real static files from public/ directly (Vite build output, images,
// css/js, etc.). The serverless function is the only entrypoint in this
// setup, so without this every asset falls through to Laravel and 404s.
$publicPath = realpath(__DIR__.'/../public');
$requestPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
if ($requestPath !== '/' && $publicPath !== false) {
    $file = realpath($publicPath.$requestPath);
    if ($file !== false && is_file($file) && str_starts_with($file, $publicPath)) {
        // mime_content_type is unreliable on the Vercel PHP runtime (it
        // returned text/plain, which browsers refuse for stylesheets), so
        // map the types we actually serve explicitly.
        $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
        $types = [
            'css' => 'text/css',
            'js' => 'application/javascript',
            'mjs' => 'application/javascript',
            'json' => 'application/json',
            'png' => 'image/png',
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'gif' => 'image/gif',
            'svg' => 'image/svg+xml',
            'ico' => 'image/x-icon',
            'webp' => 'image/webp',
            'woff' => 'font/woff',
            'woff2' => 'font/woff2',
            'ttf' => 'font/ttf',
            'map' => 'application/json',
            'txt' => 'text/plain',
            'html' => 'text/html',
        ];
        header('Content-Type: '.($types[$ext] ?? 'application/octet-stream'));
        // Vite-built assets are content-hashed; everything else gets a short cache.
        header('Cache-Control: '.(str_starts_with($requestPath, '/build/') ? 'public, max-age=31536000, immutable' : 'public, max-age=3600'));
        readfile($file);
        exit;
    }
}

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
