<?php
/**
 *
 */

use Monolog\Logger;

return [
    'debug' => false,

    'logger' => [
        'path' => dirname(dirname(__DIR__)) . '/tmp/app.log',
        'level' => Logger::WARNING,
    ],
    'appconfig' => [
        'appname'     => 'Giffard Preflight',
        'description' => 'CORS と preflight request の検証のためのプロジェクトです。',
        'author'      => 'アルム＝バンド',
        'year'        => 2020,
        'url'         => 'http://localhost:8889/',
        'themecolor'  => '#e5b786',
        'ogp'         => [
            'card'    => 'photo',
            'account' => 'Bredtn_1et',
            'type'    => 'website',
            'image'   => 'webroot/img/eyecatch.jpg',
            'initImg' => 'https://upload.wikimedia.org/wikipedia/commons/4/41/SekienKyokotsu.jpg',
        ],
    ],
];
