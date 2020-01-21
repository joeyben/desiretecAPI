FROM horrorhorst/composer-prestissimo:latest as vendor
LABEL maintainer="Aljoscha <horrorhorst> Dembowsky - aljoscha@dembowsky.io"

COPY composer.json composer.json
COPY composer.lock composer.lock
COPY tests tests
COPY database database

RUN composer install \
    --ignore-platform-reqs \
    --no-interaction \
    --no-scripts \
    --prefer-dist

FROM horrorhorst/laravel-fpm-base:latest
LABEL maintainer="Aljoscha <horrorhorst> Dembowsky - aljoscha@dembowsky.io"

COPY --chown=www-data:www-data . /var/www/html
COPY --chown=www-data:www-data --from=vendor /app/vendor/ /var/www/html/vendor/
COPY .docker/laravel/opcache.ini /usr/local/etc/php/conf.d/opcache.ini
COPY .docker/laravel/supervisord.conf /etc/supervisord.conf
COPY .docker/laravel/supervisord.d /etc/supervisord.d
COPY .docker/laravel/laravel.ini /usr/local/etc/php/conf.d
COPY .docker/laravel/php.ini /usr/local/etc/php/php.ini
COPY .docker/laravel/opcache.ini /usr/local/etc/php/conf.d/opcache.ini

RUN docker-php-ext-install zip && \
    docker-php-ext-install soap && \
    apt update && \
    apt-get install nano && \
    rm -rf /tmp/* /var/tmp/* && \
    apt-get clean && \
    rm -rf /var/lib/apt/lists/*

COPY .docker/laravel/docker-php-entrypoint.sh /usr/local/bin/docker-php-entrypoint
COPY .docker/laravel/artisan.sh /usr/local/bin/artisan-cmds
RUN chmod +x /usr/local/bin/docker-php-entrypoint && chmod +x /usr/local/bin/artisan-cmds

ARG APP_KEY
ARG AWS_KEY
ARG AWS_SECRET
ARG AWS_REGION
ARG AWS_BUCKET
RUN composer dump-autoload

USER root

RUN apt update && curl -sL https://deb.nodesource.com/setup_12.x | bash - && apt install -y nodejs
RUN rm -rf /var/www/html/.docker && /var/www/html/docker-compose*.yml && /var/www/html/.gitlab-ci*.yml
RUN make routes
RUN make message
RUN npm install
RUN chown -R www-data:www-data /var/www/html/node_modules/
