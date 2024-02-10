FROM php:8.2-fpm

ENV XDEBUG_MODE='coverage' \
    XDEBUG_CONFIG='client_host=host.docker.internal output_dir=/var/www/tmp'

# install non php modules
RUN apt-get update \
    && apt-get install --no-install-recommends -y \
        libssl-dev \
        libcurl4-openssl-dev \
        libzip-dev \
        libxml2-dev \
        libonig-dev \
        libc-client-dev \
        libkrb5-dev \
        zlib1g-dev \
        zip \
        unzip \
        git \
    && rm -rf /var/lib/apt/lists/*

# Install PHP Extension for PHPUnit und Composer
RUN docker-php-ext-install \
    zip \
    mbstring \
    xml \
    curl

RUN pecl install xdebug \
    && docker-php-ext-enable xdebug;

COPY --from=composer /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
