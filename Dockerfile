FROM php:7.3-fpm-alpine

RUN apk add --no-cache \
    bash \
    git \
    unzip \
    libzip-dev \
    oniguruma-dev \
    icu-dev

RUN docker-php-ext-install pdo pdo_mysql zip intl mbstring
