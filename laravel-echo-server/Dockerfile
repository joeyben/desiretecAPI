FROM node:alpine

# Create app directory
RUN mkdir -p /usr/src/app
WORKDIR /usr/src/app

# Install app dependencies
COPY package.json /usr/src/app/

RUN apk add --update \
    python \
    python-dev \
    py-pip \
    build-base

RUN npm install

# Bundle app source
COPY laravel-echo-server.json /usr/src/app/laravel-echo-server.json

#RUN mkdir mvp_certs
#COPY  mvp_certs/mvp.desiretec.com.chain.pem /usr/src/app/mvp_certs
#COPY  mvp_certs/mvp.desiretec.com.crt /usr/src/app/mvp_certs
#COPY  mvp_certs/mvp.desiretec.com.dhparam.pem /usr/src/app/mvp_certs
#COPY  mvp_certs/mvp.desiretec.com.key /usr/src/app/mvp_certs

EXPOSE 6001
CMD [ "npm", "start" ]
