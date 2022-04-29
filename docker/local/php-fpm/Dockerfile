FROM php:8.1.0-fpm-alpine

# CakePHP が依存している拡張機能
RUN apk update \
    && apk add icu-dev \
    && docker-php-ext-install intl \
    && docker-php-ext-install pdo_mysql

# デバッグ実行用拡張機能
RUN apk add autoconf \
    && apk add gcc \
    && apk add g++ \
    && apk add make \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug
