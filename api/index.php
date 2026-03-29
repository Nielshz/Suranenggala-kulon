<?php

/**
 * Vercel Serverless Function entry point
 * Memaksa Laravel menggunakan /tmp folder karena server Vercel bersifat Read-Only
 */

// CACHE OVERRIDES FOR VERCEL READ-ONLY FS
$_ENV['APP_SERVICES_CACHE'] = '/tmp/services.php';
$_ENV['APP_PACKAGES_CACHE'] = '/tmp/packages.php';
$_ENV['APP_CONFIG_CACHE'] = '/tmp/config.php';
$_ENV['APP_ROUTES_CACHE'] = '/tmp/routes.php';
$_ENV['APP_EVENTS_CACHE'] = '/tmp/events.php';

putenv('APP_SERVICES_CACHE=/tmp/services.php');
putenv('APP_PACKAGES_CACHE=/tmp/packages.php');
putenv('APP_CONFIG_CACHE=/tmp/config.php');
putenv('APP_ROUTES_CACHE=/tmp/routes.php');
putenv('APP_EVENTS_CACHE=/tmp/events.php');

putenv('APP_STORAGE=/tmp');
// Memaksa logging ke stderr agar Vercel dapat membaca Log tanpa menulis ke file
putenv('LOG_CHANNEL=stderr');
putenv('CACHE_DRIVER=array');
putenv('SESSION_DRIVER=cookie');
putenv('VIEW_COMPILED_PATH=/tmp/framework/views');

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

require __DIR__ . '/../public/index.php';
