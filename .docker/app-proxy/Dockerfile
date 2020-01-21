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
#RUN cd /myapp/Modules/Trendtours && yarn install --ignore-engines && npm run production
RUN cd /myapp/Modules/Reiseexperten && yarn install --ignore-engines && npm run production
RUN cd /myapp/Modules/Lastminute && yarn install --ignore-engines && npm run production
RUN cd /myapp/Modules/Traveloverland && yarn install --ignore-engines && npm run production
RUN cd /myapp/Modules/Tui && yarn install --ignore-engines && npm run production
RUN cd /myapp/Modules/Demokreuzfahrtberatung && yarn install --ignore-engines && npm run production
RUN cd /myapp/Modules/Reiserebellen && yarn install --ignore-engines && npm run production
RUN cd /myapp/Modules/Testkurenundwellness && yarn install --ignore-engines && npm run production
RUN cd /myapp/Modules/Demoatw && yarn install --ignore-engines && npm run production
RUN cd /myapp/Modules/DesiretecDemo && yarn install --ignore-engines && npm run production
RUN cd /myapp/Modules/Bild && yarn install --ignore-engines && npm run production
RUN cd /myapp/Modules/Bentour && yarn install --ignore-engines && npm run production


FROM nginx:latest
COPY public/ /var/www/html/public/
COPY --from=frontend /myapp/public/whitelabel /var/www/html/public/whitelabel
COPY --from=frontend /myapp/public/mix-manifest.json /var/www/html/public/mix-manifest.json

COPY .docker/app-proxy/default.conf /etc/nginx/conf.d/default.conf
COPY .docker/app-proxy/proxy.conf /etc/nginx/conf.d/custom_proxy.conf
COPY .docker/app-proxy/start.sh /root/start.sh
RUN chmod +x /root/start.sh

CMD ["/root/start.sh"]