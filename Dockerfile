FROM php:7.2.10-apache-stretch

ENV DEBIAN_FRONTEND=nointeractive

RUN apt-get update --quiet \
    && apt-get install --yes --quiet zip unzip git-core \
    && apt-get install -y libxml2-dev openssl \
    && docker-php-ext-install soap \
    && apt-get install -y libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql \
    && a2enmod rewrite \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && apt-get --yes --quiet autoremove \
    && apt-get --quiet clean \
    && rm -rf /var/lib/apt/lists/* /var/tmp/* /tmp/*

COPY host.conf /etc/apache2/sites-available/000-default.conf

WORKDIR /var/www/html
