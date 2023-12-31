FROM php:8.2-fpm


# install non php modules
RUN apt-get update \
    && apt-get install --no-install-recommends -y \
        libssl-dev \
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

# Configure imap
RUN docker-php-ext-install \
    zip \
    mbstring \
    xml \
    curl

COPY --from=composer /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
