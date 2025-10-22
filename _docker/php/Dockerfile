## Prebuild image for composer install
################################

FROM php:8.4.12-fpm-trixie AS prebuild

COPY ../.. /var/www/html

RUN apt-get update && apt-get install -y \
    curl \
    wget \
    gnupg \
    ca-certificates \
    lsb-release \
    apt-transport-https \
    cron \
    locales && \
    sed -i '/en_US.UTF-8/s/^# //g' /etc/locale.gen && \
    locale-gen en_US.UTF-8 && \
    apt-get clean && \
    rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*


RUN apt-get update && apt-get install -y \
      apt-utils \
      libpq-dev \
      libpng-dev \
      libzip-dev \
      libicu-dev \
      zip unzip \
      git && \
      pecl install redis && docker-php-ext-enable redis && \
      docker-php-ext-install pdo pdo_mysql && \
      docker-php-ext-install bcmath && \
      docker-php-ext-install gd && \
      docker-php-ext-install zip && \
      docker-php-ext-configure intl && \
      docker-php-ext-install intl && \
      apt-get clean && \
      rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*


RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer && \
    composer install


## Build JS files
################################
FROM node:lts-bookworm as build

COPY --from=prebuild /var/www/html /var/www/html/

WORKDIR /var/www/html

RUN npm install && npm run build

#############################

## Start
#############################
FROM php:8.4.12-fpm-trixie AS start

RUN apt-get update && apt-get install -y \
    curl \
    wget \
    gnupg \
    ca-certificates \
    lsb-release \
    apt-transport-https \
    cron \
    locales && \
    sed -i '/en_US.UTF-8/s/^# //g' /etc/locale.gen && \
    locale-gen en_US.UTF-8 && \
    apt-get clean && \
    rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*


RUN apt update && apt-get install -y libaio1t64 libaio-dev && \
    wget -O /etc/apt/trusted.gpg.d/nginx.asc https://nginx.org/keys/nginx_signing.key && \
    echo "deb http://nginx.org/packages/mainline/debian bookworm nginx" > /etc/apt/sources.list.d/nginx.list && \
    echo "deb-src http://nginx.org/packages/mainline/debian bookworm nginx" >> /etc/apt/sources.list.d/nginx.list && \
    apt update && apt-get install -y nginx && \
    sed -i '2c\user www-data;' /etc/nginx/nginx.conf && \
    apt-get clean && \
    rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*


RUN apt-get update && apt-get install -y \
      apt-utils \
      libpq-dev \
      libpng-dev \
      libzip-dev \
      libicu-dev \
      zip unzip \
      git && \
      pecl install redis && docker-php-ext-enable redis && \
      docker-php-ext-install pdo pdo_mysql && \
      docker-php-ext-install bcmath && \
      docker-php-ext-install gd && \
      docker-php-ext-install zip && \
      docker-php-ext-configure intl && \
      docker-php-ext-install intl && \
      apt-get clean && \
      rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*


RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini" && \
    sed -i 's/upload_max_filesize = 2M/upload_max_filesize = 100M/' "$PHP_INI_DIR/php.ini" && \
    sed -i 's/post_max_size = 8M/post_max_size = 100M/' "$PHP_INI_DIR/php.ini" && \
    sed -i 's/pm.max_children = 5/pm.max_children = 128/' "/usr/local/etc/php-fpm.d/www.conf" && \
    sed -i 's/pm.min_spare_servers = 1/pm.min_spare_servers = 10/' "/usr/local/etc/php-fpm.d/www.conf" && \
    sed -i 's/pm.max_spare_servers = 3/pm.max_spare_servers = 20/' "/usr/local/etc/php-fpm.d/www.conf" && \
    sed -i 's/pm.start_servers = 2/pm.start_servers = 15/' "/usr/local/etc/php-fpm.d/www.conf" && \
    sed -i 's/;date.timezone =/date.timezone = Europe\/Moscow/' "$PHP_INI_DIR/php.ini" && \
    sed -i 's/display_errors = Off/display_errors = stderr/' "$PHP_INI_DIR/php.ini"

COPY --from=build /var/www/html /var/www/html/
COPY _docker/nginx/mylara.conf /etc/nginx/conf.d/

RUN php artisan migrate &>/dev/null

RUN chown -R www-data:www-data /var/www/html

EXPOSE 80 443

ENTRYPOINT ["/bin/bash", "./_docker/php/entrypoint.sh"]
