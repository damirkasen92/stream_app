FROM dunglas/frankenphp AS base

WORKDIR /usr/src

RUN apt-get update && apt-get install -y \
    supervisor ffmpeg unzip libpq-dev \
    && install-php-extensions pdo pdo_mysql mbstring zip exif pcntl bcmath gd intl \
    && apt-get clean

RUN useradd -G www-data,root -u 1000 -d /home/damir damir

FROM base AS copying

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
COPY ./api .
COPY ./docker/backend/Caddyfile ./Caddyfile

RUN chown -R damir:damir /usr/src
RUN mkdir -p storage bootstrap/cache && \
    chown -R damir:damir storage bootstrap/cache

FROM copying AS prod

RUN composer install --no-dev --optimize-autoloader

#php configs

RUN chown -R damir:damir /data /config

USER damir

CMD ["php", "artisan", "octane:start", "--server=frankenphp", "--caddyfile=/usr/src/Caddyfile", "--host=0.0.0.0", "--port=8000"]

FROM copying AS worker

RUN composer install --no-dev --optimize-autoloader

COPY ./docker/backend/worker.conf /etc/supervisor/conf.d/worker.conf

USER damir

CMD ["supervisord", "-n", "-c", "/etc/supervisor/conf.d/worker.conf"]

FROM copying AS migrate

COPY ./docker/backend/wait-for-it.sh /usr/local/bin/wait-for-it.sh
RUN chmod +x /usr/local/bin/wait-for-it.sh && \
    chown damir:damir /usr/local/bin/wait-for-it.sh

USER damir

CMD ["wait-for-it.sh", "db:3306", "--", "php", "artisan", "migrate", "--force"]
