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
COPY Modules /myapp/Modules
COPY public /myapp/public
COPY resources /myapp/resources
COPY package-lock.json package.json webpack.mix.js webpack.config.js yarn.lock /myapp/


WORKDIR /myap
RUN npm config set "@fortawesome:registry" https://npm.fontawesome.com/ && \
      npm config set "//npm.fontawesome.com/:_authToken" 872992B4-8894-4152-95B3-FAA83ECC14D4
RUN cd /myapp && yarn install --ignore-engines && npm run production
RUN cd /myapp/Modules/Trendtours && yarn install --ignore-engines && npm run production
RUN cd /myapp/Modules/Novasol && yarn install --ignore-engines && npm run production

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

RUN apt update && \
    apt install -y mysql-client
RUN rm -r /var/www/html/docker
RUN make routes
RUN make message






