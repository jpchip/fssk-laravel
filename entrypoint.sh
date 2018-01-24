#!/bin/bash

echo "Setting directory permissions";
chown -R www-data.www-data /var/www && chmod 775 /var/www;

exec "$@"
