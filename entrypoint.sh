#!/bin/bash

echo "Composer install";
composer install -d=/var/www/fssk-laravel

echo "Setting directory permissions";
chown -R www-data.www-data /var/www && chmod 775 /var/www;

exec "$@"
