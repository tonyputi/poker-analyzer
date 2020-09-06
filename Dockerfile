FROM php:fpm-alpine

COPY src /app

RUN touch /app/storage/database.sqlite

WORKDIR /app

# CMD ["php", "artisan", "serve", "--host 0.0.0.0"]