<?php

use \Phpmig\Adapter;
use \Pimple\Container;
use \Dotenv\Dotenv;

// find environment file
$dot_env = __DIR__ . '/.env';
if (is_readable($dot_env)) {
    $dotenv = Dotenv::createImmutable(__DIR__ . '/');
    $dotenv->load();
}

//$container = new ArrayObject();
$container = new Container();

// replace this with a better Phpmig\Adapter\AdapterInterface
$container['phpmig.adapter'] = new Adapter\File\Flat(__DIR__ . DIRECTORY_SEPARATOR . 'migrations/.migrations.log');

//DBの接続情報
$container['db'] = function(){
    $dbh = new PDO('mysql:dbname=' . $_ENV['MYSQL_DBNAME'] . ';host='  . $_ENV['MYSQL_HOST'] .  ';port=' . $_ENV['MYSQL_PORT'] . ';charset=utf8', $_ENV['MYSQL_USER'] , $_ENV['MYSQL_PASSWORD']);
    $dbh -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $dbh;
};

$container['phpmig.migrations_path'] = __DIR__ . DIRECTORY_SEPARATOR . 'migrations';

// You can also provide an array of migration files
// $container['phpmig.migrations'] = array_merge(
//     glob('migrations_1/*.php'),
//     glob('migrations_2/*.php')
// );

return $container;
