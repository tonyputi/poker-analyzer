#!/bin/sh
set -e

initialize()
{    
    php /app/artisan db:wipe
    php /app/artisan migrate --seed
    php /app/artisan key:generate
}

[ ! -d /app/vendor ] && {
    composer install -d /app;
    initialize
}

if [ "$1" = "serve" ]; then
    php /app/artisan serve --host 0.0.0.0
elif [ "$1" = "initialize" ]; then
    initialize
elif [ "$1" = "test" ]; then
    php /app/artisan test
fi

exec "$@"