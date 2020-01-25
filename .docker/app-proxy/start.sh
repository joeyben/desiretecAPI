#!/usr/bin/env bash
ln -s /var/www/html/storage/app/public /var/www/html/public/storage
# Copy mix-manifest.json to make it avaible for the app container!
cp /var/www/html/public/mix-manifest.json /var/www/html/storage/mix-manifest.json
nginx -g "daemon off;"
