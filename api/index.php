<?php

/**
 * Vercel Serverless Function entry point
 * Memaksa Laravel menggunakan /tmp folder karena server Vercel bersifat Read-Only
 */

$_ENV['VIEW_COMPILED_PATH'] = '/tmp';
$_ENV['SESSION_DRIVER'] = 'cookie';
$_ENV['LOG_CHANNEL'] = 'stderr';
$_ENV['APP_STORAGE'] = '/tmp';
$_ENV['APP_DEBUG'] = 'true'; // FORCE DEBUG MODE

// Memaksa cache framework ke /tmp
putenv('VIEW_COMPILED_PATH=/tmp');
putenv('CACHE_DRIVER=array');

require __DIR__ . '/../public/index.php';
