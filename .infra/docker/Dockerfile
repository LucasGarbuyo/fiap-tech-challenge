FROM composer:2.1 AS composer
WORKDIR /opt/apps/projeto
COPY  . .
RUN composer install --prefer-dist --no-dev --no-scripts --no-progress --no-interaction --ignore-platform-reqs

FROM php:8.3-fpm-alpine AS fpm_server
RUN docker-php-ext-install pdo pdo_mysql
RUN apk --no-cache add pcre-dev ${PHPIZE_DEPS} \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && apk del pcre-dev ${PHPIZE_DEPS}
WORKDIR /opt/apps/projeto
COPY --from=composer /opt/apps/projeto /opt/apps/projeto
RUN mkdir -p /opt/apps/projeto/bootstrap/cache && \
    chmod -R 777 /opt/apps/projeto/bootstrap/cache
RUN mkdir -p /opt/apps/projeto/storage/framework/views && \
    chmod -R 777 /opt/apps/projeto/storage/framework/views
RUN mkdir -p /opt/apps/projeto/storage/framework/sessions && \
    chmod -R 777 /opt/apps/projeto/storage/framework/sessions

FROM nginx:alpine AS web_server
WORKDIR /opt/apps/projeto
COPY .infra/docker/nginx.conf.template /etc/nginx/templates/default.conf.template
COPY --from=composer /opt/apps/projeto/public /opt/apps/projeto/public

FROM php:8.3-alpine AS cli
RUN docker-php-ext-install pdo pdo_mysql
RUN apk --no-cache add pcre-dev ${PHPIZE_DEPS} \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && apk del pcre-dev ${PHPIZE_DEPS}
WORKDIR /opt/apps/projeto
COPY --from=composer /opt/apps/projeto /opt/apps/projeto

FROM cli AS cron
WORKDIR /opt/apps/projeto
RUN touch laravel.cron && \
    echo "* * * * * cd /opt/apps/projeto && php artisan schedule:run" >> laravel.cron && \
    crontab laravel.cron
CMD ["crond", "-l", "2", "-f"]

FROM cli