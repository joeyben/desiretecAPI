FROM composer:latest as vendor

COPY composer.json composer.json
COPY composer.lock composer.lock
COPY tests tests
COPY database database

RUN composer install \
    --ignore-platform-reqs \
    --no-interaction \
    --no-plugins \
    --no-scripts \
    --prefer-dist

FROM node:latest as frontend

RUN mkdir -p /myapp
COPY public /myapp/public
COPY resources /myapp/resources
COPY package-lock.json package.json webpack.mix.js webpack.config.js yarn.lock /myapp/


WORKDIR /myap

RUN cd /myapp && yarn install && npm run production

FROM horrorhorst/laravel-base:latest

RUN docker-php-ext-install zip

COPY . /var/www/html
COPY --from=vendor /app/vendor/ /var/www/html/vendor/
COPY --from=frontend /myapp/public /var/www/html/public
COPY docker/php/opcache.ini /usr/local/etc/php/conf.d/opcache.ini

RUN mv /var/www/html/docker/php/laravel.ini /usr/local/etc/php/conf.d
RUN mv /var/www/html/docker/php/php.ini /usr/local/etc/php/php.ini
RUN mv /var/www/html/docker/php/opcache.ini /usr/local/etc/php/conf.d/opcache.ini
RUN a2enmod rewrite expires
RUN echo "SetEnvIf x-forwarded-proto https HTTPS=on" >> /etc/apache2/conf-available/docker-php.conf
RUN composer dump-autoload

USER root

RUN rm -r /var/www/html/docker






