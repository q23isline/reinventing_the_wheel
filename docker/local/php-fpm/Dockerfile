# composer で関連ライブラリインストール用イメージ
FROM php:8.2.7-fpm-alpine AS composer

# CakePHP が依存している拡張機能
RUN apk update \
    && apk add icu-dev \
    && docker-php-ext-install intl

RUN mkdir /app
WORKDIR /app

COPY composer.phar /app/composer.phar
COPY composer.json /app/composer.json
COPY composer.lock /app/composer.lock

RUN php composer.phar install

# node で関連ライブラリインストール用イメージ
FROM node:16.17.0-alpine3.15 AS node

RUN mkdir /app
WORKDIR /app

COPY front/package.json /app/package.json
COPY front/yarn.lock /app/yarn.lock

RUN yarn install

# アプリ用イメージ
FROM php:8.2.7-fpm-alpine

# CakePHP が依存している拡張機能
RUN apk update \
    && apk add icu-dev \
    && docker-php-ext-install intl

# MySQL へ DB 保存する拡張機能
RUN docker-php-ext-install pdo_mysql

# デバッグ実行用拡張機能
RUN apk add autoconf \
    && apk add gcc \
    && apk add g++ \
    && apk add make \
    && apk add linux-headers \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug

# Vue.js が依存している拡張機能
RUN apk add nodejs \
    && apk add npm \
    && apk add yarn

WORKDIR /var/www/html

COPY ./docker/local/php-fpm/php.ini /usr/local/etc/php/php.ini
COPY . /var/www/html
COPY --from=composer /app/vendor /var/www/html/vendor

COPY --from=node /app/node_modules /var/www/html/front/node_modules

RUN chmod ugo+w -R logs
RUN chmod 777 -R tmp
