#!/usr/bin/env bash
echo 'Running composer'
composer install --no-dev --working-dir=/var/www/html
php artisan cache:clear 

echo 'Caching config...'
php artisan config:cache

echo 'Caching routes...'
php artisan route:cache
 
echo 'Running migrations...'
php artisan migrate --force
php artisan cache:clear

echo 'Running storage...'
php artisan storage:link
php artisan cache:clear

echo 'Running queue...'
php artisan queue:work & php artisan cache:clear