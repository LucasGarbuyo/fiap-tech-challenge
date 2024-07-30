FROM php:8.2-apache-buster

LABEL maintainer="Grupo 47 < 6SOAT"
LABEL description=" Grupo 47's Docker image for the Tech Challenge"

# Enable mod_rewrite
RUN a2enmod rewrite

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install necessary build tools
RUN apt-get update && apt-get install -y \
    gcc \
    make \
    autoconf \
    && rm -rf /var/lib/apt/lists/*

# Install required extensions and dependencies
RUN apt-get update && apt-get install -y \
    libbz2-dev \
    libcurl4-openssl-dev \
    libxml2-dev \
    mariadb-client \
    libssl-dev \
    libldap-dev \
    libpcre3-dev \
    libmariadb-dev \
    libonig-dev \
    libpng-dev \
    libjpeg-dev \
    libzip-dev \
    zip \
    unzip \
    libicu-dev \
    libldap2-dev \
    libgd-dev \
    libpq-dev
    
# Remove default PHP extensions
RUN docker-php-ext-install -j$(nproc) \
    mysqli \
	pdo_mysql \
    ctype \
    session \
    dom 

# Install additional PHP extensions
RUN docker-php-ext-install -j$(nproc) \
    bcmath \
    zip \
    intl \
    gd \
    mbstring \
    opcache

# Copy virtual host configuration
COPY ./docker/php/vhost.conf /etc/apache2/sites-available/000-default.conf

# Install required extensions and dependencies
RUN apt-get update && apt-get install -y

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN pear config-set php_ini /usr/local/etc/php/php.ini

ARG UID=1000
ARG GID=1000

COPY ./ /var/www/html

RUN groupmod -g ${GID} www-data \
  && usermod -u ${UID} -g www-data www-data \
  && chown -hR www-data:www-data \
  /var/www \
  /usr/local/ \
  /etc/ssl/ \
  /etc/apache2/ \
  /var/lock/apache2/ \
  /var/run/apache2/ \
  /var/log/apache2/

# Expose ports
EXPOSE 80
EXPOSE 443

USER www-data:www-data
WORKDIR /var/www/html
ENV PATH=$PATH:/var/www/.composer/vendor/bin

RUN composer install

# Start Apache in the foreground
CMD ["apache2ctl", "-D", "FOREGROUND"]

