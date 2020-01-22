#!/bin/bash

if [ -f /var/www/html/storage/mix-manifest.json ]; then
    touch /var/www/html/storage/mix-manifest.json
fi
ln -s /var/www/html/storage/mix-manifest.json /var/www/html/public/mix-manifest.json

php /var/www/html/artisan migrate --force

php /var/www/html/artisan cache:clear
php /var/www/html/artisan config:clear

php /var/www/html/artisan config:cache
#php /var/www/html/artisan view:cache

# create symbolic link from storage/app/public to public/storage!
php /var/www/html/artisan storage:link
php /var/www/html/artisan laroute:generate -p public/storage/js
php /var/www/html/artisan lang:js --no-lib resources/assets/js/utils/messages.js
php /var/www/html/artisan lang:js public/storage/js/messages.js


exit 0
