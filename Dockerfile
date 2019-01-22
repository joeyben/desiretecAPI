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

RUN mkdir -p /public
COPY public/css /public/css
COPY public/js /public/js
COPY public/fonts /public/fonts

COPY package.json webpack.mix.js yarn.lock /
COPY resources/assets/ /resources/assets/

WORKDIR /

RUN npm install && npm run production

FROM horrorhorst/laravel-base:latest

RUN docker-php-ext-install zip

COPY . /var/www/html
COPY --from=vendor /app/vendor/ /var/www/html/vendor/
COPY --from=frontend /public/js/ /var/www/html/public/js/
COPY --from=frontend /public/css/ /var/www/html/public/css/
COPY --from=frontend /public/fonts/ /var/www/html/public/fonts/
COPY --from=frontend /mix-manifest.json /var/www/html/public/mix-manifest.json
COPY docker/php/opcache.ini /usr/local/etc/php/conf.d/opcache.ini

RUN mv /var/www/html/docker/php/laravel.ini /usr/local/etc/php/conf.d
RUN mv /var/www/html/docker/php/php.ini /usr/local/etc/php/php.ini
RUN mv /var/www/html/docker/php/opcache.ini /usr/local/etc/php/conf.d/opcache.ini
RUN a2enmod rewrite expires
RUN echo "SetEnvIf x-forwarded-proto https HTTPS=on" >> /etc/apache2/conf-available/docker-php.conf
RUN composer dump-autoload

USER root

RUN rm -r /var/www/html/docker






