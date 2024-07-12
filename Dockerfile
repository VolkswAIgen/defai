ARG WORDPRESS_VERSION=$WORDPRESS_VERSION
ARG PHP_VERSION=$PHP_VERSION

FROM wordpress:$WORDPRESS_VERSION-php$PHP_VERSION

ARG TARGETOS
ARG TARGETARCH

RUN set -x \
    && apt-get update \
    && apt-get install -y libldap2-dev ldap-utils\
    && rm -rf /var/lib/apt/lists/* \
    && ls -al /usr/lib/ \
    && echo $TARGETOS $TARGETARCH \
    && case "$TARGETARCH" in \
         arm64) export ARCH='aarch64';; \
    	 amd64) export ARCH='x86_64' ;; \
         *) export ARCH=$TARGETARCH;; \
       esac \
    && docker-php-ext-configure ldap --with-libdir=lib/$ARCH-$TARGETOS-gnu/ \
    && docker-php-ext-install ldap \
    && pecl install xdebug${XDEBUG_VERSION} \
    && docker-php-ext-enable xdebug \
    && echo "xdebug.mode=debug" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.discover_client_host=on" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
	&& apt-get purge -y --auto-remove libldap2-dev

RUN set -x \
    && curl -o /usr/local/bin/wp https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar \
    && chmod 755 /usr/local/bin/wp

