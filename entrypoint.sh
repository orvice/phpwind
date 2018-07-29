#!/bin/bash

set -e


echo 'Starting....'

cd /var/www/html && php artisan route:cache && php artisan view:clear && \
    php fans key:generate && php fans jwt:secret && php fans migrate --seed --force

exec "$@"
