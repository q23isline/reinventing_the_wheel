# CakePHP Application Skeleton

[![Build Status](https://img.shields.io/travis/cakephp/app/master.svg?style=flat-square)](https://travis-ci.org/cakephp/app)
[![Total Downloads](https://img.shields.io/packagist/dt/cakephp/app.svg?style=flat-square)](https://packagist.org/packages/cakephp/app)
[![PHPStan](https://img.shields.io/badge/PHPStan-level%207-brightgreen.svg?style=flat-square)](https://github.com/phpstan/phpstan)

A skeleton for creating applications with [CakePHP](https://cakephp.org) 4.x.

The framework source code can be found here: [cakephp/cakephp](https://github.com/cakephp/cakephp).

## Installation

1. Download [Composer](https://getcomposer.org/doc/00-intro.md) or update `composer self-update`.
2. Run `php composer.phar create-project --prefer-dist cakephp/app [app_name]`.

If Composer is installed globally, run

```bash
composer create-project --prefer-dist cakephp/app
```

In case you want to use a custom app dir name (e.g. `/myapp/`):

```bash
composer create-project --prefer-dist cakephp/app myapp
```

You can now either use your machine's webserver to view the default home page, or start
up the built-in webserver with:

```bash
bin/cake server -p 8765
```

Then visit `http://localhost:8765` to see the welcome page.

## Update

Since this skeleton is a starting point for your application and various files
would have been modified as per your needs, there isn't a way to provide
automated upgrades, so you have to do any updates manually.

## Configuration

Read and edit the environment specific `config/app_local.php` and setup the 
`'Datasources'` and any other configuration relevant for your application.
Other environment agnostic settings can be changed in `config/app.php`.

## Layout

The app skeleton uses [Milligram](https://milligram.io/) (v1.3) minimalist CSS
framework by default. You can, however, replace it with any other library or
custom styles.

## はじめにやること

1. `git clone 'https://github.com/q23isline/reinventing_the_wheel.git'`コマンド実行
2. `config/.env.example`をコピーし、`config/.env`として貼り付ける
    - `SECURITY_SALT`の値は適当に書き換える
3. `config/app_local.example.php`をコピーし、`config/app_local.php`として貼り付ける
4. `docker-compose build`コマンド実行
5. `docker-compose up -d`コマンド実行
6. `docker exec -it app php composer.phar install`コマンド実行
7. `docker exec -it app bin/cake migrations migrate`コマンド実行
   - `exec: \"./bin/cake\": permission denied": unknown`が表示された場合  
     （windowsのUbuntuディストリビューションとかで）
       - `chmod -v 744 bin/cake*`コマンド実行
8. `docker exec -it app bin/cake migrations seed`コマンド実行

## 動作確認

### URL

- <http://localhost>

### ログイン情報

- Username
  - admin
- Password
  - admin00

## ユニットテスト

```bash
# テスト実行
php ./vendor/bin/phpunit
# カバレッジ生成
phpdbg -qrr ./vendor/bin/phpunit --coverage-html webroot/coverage
```

- カバレッジ確認URL
  - <http://localhost/coverage/index.html>
