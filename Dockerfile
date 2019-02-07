FROM php:7.2-fpm

RUN apt-get update -y \
    && apt-get install -y --no-install-recommends \
        libbz2-dev \
        libmcrypt-dev \
        libmemcached-dev \
        libpcre3-dev \
        libssl-dev \
        libz-dev \
        zlib1g-dev \
        # gd
        libjpeg62-turbo-dev \
        libpng-dev \
        libfreetype6-dev \
        # rabbitmq
        librabbitmq-dev \
        # zip
        libzip-dev \
        # gmp
        libgmp-dev
        # intl
        libicu-dev g++ \
        # image opt
        jpegoptim optipng pngquant gifsicle \
        # imagick
        libmagickwand-dev imagemagick \
        # imap
        libc-client-dev libkrb5-dev \
    && apt-get clean \
        && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* \
    && docker-php-ext-install mcrypt bz2 mbstring pdo pdo_pgsql pcntl bcmath gmp exif opcache tokenizer \
    && docker-php-ext-configure zip --with-libzip \
        && docker-php-ext-install zip \
    && docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
        && docker-php-ext-install gd \
    && docker-php-ext-configure imap --with-kerberos --with-imap-ssl \
        && docker-php-ext-install imap \
    && pecl channel-update pecl.php.net \
    && pecl install memcached \
    && pecl install apcu \
    && pecl install swoole \
    && pecl install imagick \
    && docker-php-ext-enable memcached apcu swoole imagick \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && composer global require hirak/prestissimo

RUN mv $PHP_INI_DIR/php.ini-production $PHP_INI_DIR/php.ini

WORKDIR /srv
COPY . .

CMD ["php-fpm"]

EXPOSE 9000
