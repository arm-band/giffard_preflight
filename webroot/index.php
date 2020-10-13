<?php
/**
 *
 */
date_default_timezone_set('Asia/Tokyo');
mb_language('ja');
mb_internal_encoding('UTF-8');

require dirname(__DIR__) . '/vendor/autoload.php';

use Dietcube\Dispatcher;
use \Dotenv\Dotenv;

const ENV_PATH = '/../';
const ENV = '.env';

// find environment file
$dot_env = __DIR__ . ENV_PATH . ENV;
if (is_readable($dot_env)) {
    $dotenv = Dotenv::createImmutable(__DIR__ . ENV_PATH);
    $dotenv->load();
}

// debug (development)
if(!(Integer)$_ENV['PROD_FLG']) {
    ini_set('xdebug.var_display_max_children', -1);
    ini_set('xdebug.var_display_max_data', -1);
    ini_set('xdebug.var_display_max_depth', -1);
}

Dispatcher::invoke(
    '\\DietcubeKyokotsu\\Application',
    dirname(__DIR__) . '/app',
    Dispatcher::getEnv()
);
