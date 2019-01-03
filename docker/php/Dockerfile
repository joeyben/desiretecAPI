FROM node:latest

RUN npm install
RUN npm run production


FROM composer:latest

RUN composer update

FROM php:7.1-apache

COPY . /var/www

RUN apt-get update && \
apt-get install -y --no-install-recommends \
curl \
libmemcached-dev \
libz-dev \
libpq-dev \
libjpeg-dev \
libpng12-dev \
libfreetype6-dev \
libssl-dev \
libmcrypt-dev

# always run apt update when start and after add new source list, then clean up at end.
RUN apt-get update -yqq && \
apt-get install -y apt-utils && \
pecl channel-update pecl.php.net

# Composer
RUN curl -s http://getcomposer.org/installer | php && \
echo "export PATH=${PATH}:/var/www/vendor/bin" >> ~/.bashrc && \
mv composer.phar /usr/local/bin/composer

# Install the PHP mcrypt extention
RUN docker-php-ext-install mcrypt

# Install the PHP pdo_mysql & mysqli extention
RUN docker-php-ext-install pdo_mysql
RUN docker-php-ext-install mysqli

RUN printf "\n" | pecl install -o -f redis \
&&  rm -rf /tmp/pear \
&&  docker-php-ext-enable redis

# Install the PHP gd library
RUN docker-php-ext-configure gd \
--enable-gd-native-ttf \
--with-jpeg-dir=/usr/lib \
--with-freetype-dir=/usr/include/freetype2 && \
docker-php-ext-install gd

RUN docker-php-ext-install opcache
COPY docker/php/opcache.ini /usr/local/etc/php/conf.d/opcache.ini

RUN apt-get install -y zlib1g-dev libicu-dev g++ && \
docker-php-ext-configure intl && \
docker-php-ext-install intl

RUN apt-get install -y libmagickwand-dev imagemagick && \
pecl install imagick && \
docker-php-ext-enable imagick


COPY docker/php/laravel.ini /usr/local/etc/php/conf.d
COPY docker/php/php.ini /usr/local/etc/php/php.ini
COPY docker/php/opcache.ini /usr/local/etc/php/conf.d/opcache.ini

USER root

# Clean up
RUN apt-get clean && \
    rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* && \
    rm /var/log/lastlog /var/log/faillog

RUN usermod -u 1000 www-data


WORKDIR /var/www