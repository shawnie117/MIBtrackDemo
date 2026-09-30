<?php
/**
 * DEMO BUILD RIG - router for PHP's built-in server.
 *
 * The production app relies on Apache mod_rewrite (.htaccess) to funnel every
 * request into index.php. php -S has no rewrite engine, so this script does
 * the same job: serve real files as-is, send everything else to index.php.
 *
 * Usage:  php -S localhost:8080 -t . router.php
 */

$uri  = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri  = urldecode($uri);
$root = __DIR__;
$file = realpath($root . $uri);

// Serve existing static assets (css/js/images) directly, but never let a
// request escape the build root.
if ($uri !== '/' && $file !== FALSE && is_file($file) && strpos($file, realpath($root)) === 0) {
    return FALSE;
}

// Everything else is a CodeIgniter route.
$_SERVER['SCRIPT_NAME']     = '/index.php';
$_SERVER['SCRIPT_FILENAME'] = $root . '/index.php';
$_SERVER['PHP_SELF']        = '/index.php';

require $root . '/index.php';
