# composer で関連ライブラリインストール用イメージ
FROM php:8.2.10-fpm-alpine AS composer

# CakePHP が依存している拡張機能
RUN apk update \
    && apk add --no-cache icu-data-full icu-dev \
    && docker-php-ext-install intl

RUN mkdir /app
WORKDIR /app

COPY composer.phar /app/composer.phar
COPY composer.json /app/composer.json
COPY composer.lock /app/composer.lock

RUN php composer.phar install

# アプリ用イメージ
FROM php:8.2.10-fpm-alpine

# CakePHP が依存している拡張機能
RUN apk update \
    && apk add --no-cache icu-data-full icu-dev \
    && docker-php-ext-install intl

# MySQL へ DB 保存する拡張機能
RUN docker-php-ext-install pdo_mysql

# デバッグ実行用拡張機能
RUN apk update \
    && apk add --no-cache autoconf gcc g++ make linux-headers \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug

WORKDIR /var/www/html

COPY ./docker/local/php-fpm/php.ini /usr/local/etc/php/php.ini
COPY . /var/www/html
COPY --from=composer /app/vendor /var/www/html/vendor

RUN chmod ugo+w -R logs
RUN chmod 777 -R tmp
