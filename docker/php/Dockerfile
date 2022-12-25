FROM php:8.0.11-fpm-alpine

RUN apk add icu-dev php-curl

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer

RUN docker-php-ext-configure intl && docker-php-ext-install mysqli pdo pdo_mysql intl

RUN set -eux \
    & apk add \
        --no-cache \
        nodejs \
        yarn

RUN echo 'memory_limit = 2048M' >> /usr/local/etc/php/conf.d/docker-php-memlimit.ini
