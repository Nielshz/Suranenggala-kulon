<?php

/**
 * Vercel Serverless Function entry point
 * Memaksa Laravel menggunakan /tmp folder karena server Vercel bersifat Read-Only
 */

ini_set('display_errors', 1);
error_reporting(E_ALL);

$_ENV['VIEW_COMPILED_PATH'] = '/tmp';
$_ENV['SESSION_DRIVER'] = 'cookie';
$_ENV['LOG_CHANNEL'] = 'stderr';
$_ENV['APP_STORAGE'] = '/tmp';
$_ENV['APP_DEBUG'] = 'true'; // FORCE DEBUG MODE

// Membuat struktur direktori wajib untuk Laravel di dalam folder sementara Vercel
$directories = [
    '/tmp/framework/views',
    '/tmp/framework/cache',
    '/tmp/framework/cache/data',
    '/tmp/framework/sessions',
    '/tmp/logs',
    '/tmp/app/public',
];

foreach ($directories as $dir) {
    if (!is_dir($dir)) {
        @mkdir($dir, 0777, true);
    }
}

// Memaksa cache framework ke /tmp
putenv('VIEW_COMPILED_PATH=/tmp/framework/views');
putenv('CACHE_DRIVER=array');

if ($_SERVER['REQUEST_URI'] === '/ping') {
    http_response_code(200);
    header('Content-Type: text/plain');
    echo "PHP Serverless is Working! (VERCEL-PHP@0.9.0)";
    exit;
}

try {
    require __DIR__ . '/../public/index.php';
} catch (\Throwable $e) {
    http_response_code(200);
    header('Content-Type: text/plain');
    echo "FATAL VERCEL ERROR CAUGHT BY WRAPPER:\n";
    echo "Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . " on line " . $e->getLine() . "\n";
    echo "Trace:\n" . $e->getTraceAsString() . "\n";
    exit;
}
