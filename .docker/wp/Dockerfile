ARG WORDPRESS_VERSION=$WORDPRESS_VERSION
ARG PHP_VERSION=$PHP_VERSION

FROM php:$PHP_VERSION-fpm

RUN docker-php-ext-install mysqli

WORKDIR /var/www/html
RUN set -x \
    && curl -o /usr/local/bin/wp https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar \
    && chmod 755 /usr/local/bin/wp \
    && /usr/local/bin/wp --allow-root core download --version $WORDPRESS_VERSION \
