#!/bin/sh
set -eu

if [ -z "${APP_KEY:-}" ]; then
    php artisan key:generate --force --no-interaction
fi

php artisan config:clear --no-ansi
php artisan migrate --force --no-ansi
php artisan storage:link --force --no-ansi || true
php artisan config:cache --no-ansi

exec "$@"
