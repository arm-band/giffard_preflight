<?php

require dirname(__DIR__) . '/vendor/autoload.php';

use \Dotenv\Dotenv;

const ENV_PATH = '/../';
const ENV_SAMPLE = 'sample.env';
const ENV = '.env';
const HTACCESS = '.htaccess';
const HTACCESS_BASE = __DIR__ . '/htaccess/htaccess.txt';
const HTACCESS_REPLACE = '/@@ROOT_PATH@@/';

// find environment file
$dot_env = __DIR__ . ENV_PATH . ENV;
if (is_readable($dot_env)) {
    $dotenv = Dotenv::createImmutable(__DIR__ . ENV_PATH);
    $dotenv->load();
}

try {
    // .env copy
    if(!file_exists(__DIR__ . ENV_PATH . ENV)) {
        copy(__DIR__ . ENV_PATH . ENV_SAMPLE, __DIR__ . ENV_PATH . ENV);
        echo ENV . ' copy successed!';
    }
    // .htaccess copy
    if(!file_exists(__DIR__ . ENV_PATH . HTACCESS) && file_exists(HTACCESS_BASE)) {
        $content = file_get_contents(HTACCESS_BASE);
        $content = preg_replace(HTACCESS_REPLACE, $_ENV['ROOT_PATH'], $content);
        file_put_contents(__DIR__ . ENV_PATH . HTACCESS, $content);
        echo HTACCESS . ' make successed!';
    }
}
catch (Exception $e) {
    echo 'copy failed!:' . $e->getMessage();
}
