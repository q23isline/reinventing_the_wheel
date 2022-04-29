FROM php:8.1.0-fpm-buster

# CakePHP が依存している拡張機能
RUN apt-get update \
    && apt-get install -y libicu-dev \
    && docker-php-ext-install intl \
    && docker-php-ext-install pdo_mysql

# デバッグ実行用拡張機能
RUN pecl install xdebug \
    && docker-php-ext-enable xdebug
