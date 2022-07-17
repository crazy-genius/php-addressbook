#FROM php:5.6-fpm-alpine
FROM php:8.1-fpm-alpine

RUN apk add --no-cache $PHPIZE_DEPS \
    icu-dev \
    gettext-dev \
    && docker-php-ext-install -j$(nproc)  pdo mysqli pdo_mysql gettext intl \
    && docker-php-source delete \
    && apk del --purge $PHPIZE_DEPS
