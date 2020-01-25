#!/bin/bash

if [ -f /var/www/html/storage/mix-manifest.json ]; then
    touch /var/www/html/storage/mix-manifest.json
fi
ln -s /var/www/html/storage/mix-manifest.json /var/www/html/public/mix-manifest.json

#ä Using su to avoid that the logfile of laravel is created as root when an fatal error happens while executing those commands

su -s /bin/bash www-data -c "php /var/www/html/artisan migrate --force"

su -s /bin/bash www-data -c "php /var/www/html/artisan cache:clear"
su -s /bin/bash www-data -c "php /var/www/html/artisan config:clear"

su -s /bin/bash www-data -c "php /var/www/html/artisan config:cache"
#php /var/www/html/artisan view:cache

# create symbolic link from storage/app/public to public/storage!
su -s /bin/bash www-data -c "php /var/www/html/artisan storage:link"
su -s /bin/bash www-data -c "php /var/www/html/artisan laroute:generate -p public/storage/js"
su -s /bin/bash www-data -c "php /var/www/html/artisan lang:js --no-lib resources/assets/js/utils/messages.js"
su -s /bin/bash www-data -c "php /var/www/html/artisan lang:js public/storage/js/messages.js"


exit 0
