#!/bin/sh

composer dump-autoload
composer install
php artisan optimize
rm ./public/storage
php artisan storage:link
# npm install
# npm run production

# Crucial to make container keep running
php-fpm