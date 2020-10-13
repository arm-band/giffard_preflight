# Giffard Preflight

## Abstract

CORS と preflight request の検証のためのプロジェクトです。

## Setup

2つのターミナルを使用します。

### Terminal 1

```
git clone https://github.com/arm-band/giffard_preflight.git
cd giffard_preflight
composer install
composer start
```

PHPサーバのタイムアウト時間に注意。

### Terminal 2

```
cd giffard_preflight
cd giffard
yarn
yarn start
```

### Verification

`http://localhost:3000` にアクセス。

## Configuration

```
app/config/config.php
```

## Environment

Enviroment file setups by `composer reqiure` or `composer install` from `sample.env`

```
.env
```

## Run with PHP built-in server

```
composer start
```
## Use below the sub directory

`.htaccess` setups by `composer reqiure` or `composer install`

```
DirectoryIndex index.html index.php

RewriteEngine On
RewriteBase /PATH/TO/dietcube-kyokotsu/

RewriteRule ^$ webroot/index.php [QSA,L]

RewriteCond %{REQUEST_FILENAME} -f [OR]
RewriteCond %{REQUEST_FILENAME} -d
RewriteRule (.*) - [QSA,L]

RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteCond %{REQUEST_FILENAME} \.(css|js|jpg|jpeg|gif|png|svg|ico)$
RewriteCond %{REQUEST_FILENAME} !^(.*)(webroot)+(.*)$
RewriteRule ^(.*)$ webroot/$1 [QSA,L]

RewriteCond %{REQUEST_FILENAME} !-f
RewriteRule ^(.*)$ webroot/index.php [QSA,L]
```

and write parameter `ROOT_PATH` in `.env`

```
ROOT_PATH=/PATH/TO/dietcube-kyokotsu/
```

---

Powered by [dietcube/project](https://github.com/dietcube/project).