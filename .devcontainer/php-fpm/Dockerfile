FROM php:8.1-fpm-alpine

RUN apk update \
    && apk add --no-cache bash curl git vim \
    && docker-php-ext-configure pdo_mysql \
    && docker-php-ext-install pdo_mysql \
    && curl https://getcomposer.org/installer | php -- --quiet \
    && mv composer.phar /usr/bin/composer