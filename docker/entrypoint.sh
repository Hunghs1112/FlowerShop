#!/bin/sh
set -eu

if [ -z "${APP_KEY:-}" ]; then
    php artisan key:generate --force --no-interaction
fi

php artisan config:clear --no-ansi
php artisan migrate --force --no-ansi

# Keep legacy bundled images on the same public storage URL as uploads.
mkdir -p storage/app/public/images
cp -R public/images/. storage/app/public/images/
chown -R www-data:www-data storage/app/public
php artisan storage:link --force --no-ansi || true
php artisan config:cache --no-ansi

exec "$@"
