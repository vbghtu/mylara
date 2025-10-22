#!/bin/bash
php-fpm -c /usr/local/etc/php/php.ini -D
php artisan migrate &>/dev/null &
nginx -g "daemon off;"
