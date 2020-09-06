FROM php:fpm-alpine

COPY src /app

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && composer install -d /app \
    && touch /app/storage/database.sqlite \
    && cp /app/.env.example /app/.env

COPY ./docker-entrypoint.sh /
RUN chmod +x /docker-entrypoint.sh
ENTRYPOINT ["/docker-entrypoint.sh"]

WORKDIR /app

CMD ["serve"]