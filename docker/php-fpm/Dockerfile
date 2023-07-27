FROM php:8.1-fpm

RUN apt-get update && apt-get install -y --no-install-recommends apt-utils

RUN \
    apt-get update && apt-get install -y lsb-base curl && \
    curl -sL https://deb.nodesource.com/setup_12.x | bash - && \
    apt-get install -y nodejs && \
    curl -sS https://dl.yarnpkg.com/debian/pubkey.gpg | apt-key add - && \
    echo "deb https://dl.yarnpkg.com/debian/ stable main" | tee /etc/apt/sources.list.d/yarn.list &&\
    apt update && apt install -y yarn

# basic software
RUN apt-get update && apt-get install -y \
    apt-transport-https \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libxml2-dev \
    libxslt-dev \
    libpng-dev \
    zlib1g-dev \
    libonig-dev \
    libzip-dev \
    curl \
    cron \
    mariadb-client \
# and admin tools
    sudo \
    openssh-client \
    net-tools \
    iputils-ping \
    telnet \
    nmap \
    git \
    git-flow \
    vim \
    nano \
    mc

# PHP extensions
RUN \
    docker-php-ext-configure gd --with-freetype=/usr/include/ --with-jpeg=/usr/include/ \
    && docker-php-ext-install -j$(nproc) \
    gd \
    bcmath \
    gettext \
    iconv \
    pdo_mysql \
    mbstring \
    pcntl \
    soap \
    intl \
    xsl \
    zip \
    exif \
    sockets \
    pcntl

RUN \
    pecl install xdebug \
    && docker-php-ext-enable xdebug

COPY composer.* /var/www/

WORKDIR /var/www

VOLUME /var/www

RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www

COPY --chown=www:www . /var/www

USER www
