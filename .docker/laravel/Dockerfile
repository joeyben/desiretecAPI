FROM horrorhorst/composer-prestissimo:latest as vendor

LABEL maintainer="desiretec"

COPY composer.json composer.json
COPY composer.lock composer.lock
COPY tests tests
COPY database database

RUN composer install \
    --ignore-platform-reqs \
    --no-interaction \
    --no-scripts \
    --prefer-dist


FROM node:lts-stretch as frontend

LABEL maintainer="desiretec"

RUN mkdir -p /myapp
COPY Modules /myapp/Modules
COPY public /myapp/public
COPY resources /myapp/resources
COPY package-lock.json package.json webpack.mix.js webpack.config.js yarn.lock /myapp/

WORKDIR /myapp
RUN npm config set "@fortawesome:registry" https://npm.fontawesome.com/ && \
      npm config set "//npm.fontawesome.com/:_authToken" 872992B4-8894-4152-95B3-FAA83ECC14D4
RUN cd /myapp && yarn install --ignore-engines && npm i && npm run production
RUN cd /myapp/Modules/Reiseexperten && yarn install --ignore-engines && npm run production
RUN cd /myapp/Modules/Lastminute && yarn install --ignore-engines && npm run production
RUN cd /myapp/Modules/Traveloverland && yarn install --ignore-engines && npm run production
RUN cd /myapp/Modules/Tui && yarn install --ignore-engines && npm run production
RUN cd /myapp/Modules/Kurenundwellness && yarn install --ignore-engines && npm run production
RUN cd /myapp/Modules/Bild && yarn install --ignore-engines && npm run production

FROM horrorhorst/laravel-base:latest

LABEL maintainer="desiretec"


COPY --chown=www-data:www-data . /var/www/html
COPY --chown=www-data:www-data --from=vendor /app/vendor/ /var/www/html/vendor/
COPY --chown=www-data:www-data --from=frontend /myapp/public /var/www/html/public
COPY docker/php/opcache.ini /usr/local/etc/php/conf.d/opcache.ini
COPY .docker/laravel/supervisord.conf /etc/supervisord.conf
COPY .docker/laravel/supervisord.d /etc/supervisord.d
COPY .docker/laravel/apache2-foreground /usr/local/bin/apache2-foreground
RUN chmod a+x /usr/local/bin/apache2-foreground

RUN mv /var/www/html/docker/php/laravel.ini /usr/local/etc/php/conf.d
RUN mv /var/www/html/docker/php/php.ini /usr/local/etc/php/php.ini
RUN mv /var/www/html/docker/php/opcache.ini /usr/local/etc/php/conf.d/opcache.ini
RUN a2enmod rewrite expires
RUN echo "SetEnvIf x-forwarded-proto https HTTPS=on" >> /etc/apache2/conf-available/docker-php.conf
ARG APP_KEY
ENV APP_KEY $APP_KEY
RUN composer dump-autoload

USER root

RUN curl -sL https://deb.nodesource.com/setup_8.x | bash - && apt install -y nodejs && apt install -y npm
RUN rm -r /var/www/html/docker
RUN make routes
RUN make message
RUN apt-get install nano
RUN docker-php-ext-install soap
RUN npm install
RUN chown -R www-data:www-data /var/www/html/node_modules/