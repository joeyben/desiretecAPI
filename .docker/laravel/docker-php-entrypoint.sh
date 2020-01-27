#!/bin/sh
set -e

/usr/local/bin/artisan-cmds
/usr/bin/supervisord -n -c /etc/supervisord.conf &

# first arg is `-f` or `--some-option`
if [ "${1#-}" != "$1" ]; then
	set -- php-fpm "$@"
fi

exec "$@"
