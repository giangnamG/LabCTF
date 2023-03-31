FROM php:fpm-alpine

RUN docker-php-ext-install pdo pdo_mysql mysqli && \
    docker-php-ext-enable mysqli


EXPOSE 9000