FROM registry.docker-cn.com/library/php:7.2-fpm

LABEL maintainer="Seven Du <shiweidu@outlook.com>"

# Start as root
USER root

# Add a non-root user to prevent files being created with root permissions on host machine.
ARG DOCKER_CONTAINER_PUID=1000
ENV DOCKER_CONTAINER_PUID ${DOCKER_CONTAINER_PUID}

ARG DOCKER_CONTAINER_PGID=1000
ENV DOCKER_CONTAINER_PGID ${DOCKER_CONTAINER_PGID}

ARG DOCKER_CONTAINER_USER=fans
ENV DOCKER_CONTAINER_USER ${DOCKER_CONTAINER_USER}

ARG DOCKER_CONTAINER_GROUP=fans
ENV DOCKER_CONTAINER_GROUP ${DOCKER_CONTAINER_GROUP}

# always run apt update when start and after add new source list, then clean up at end.
RUN apt-get update -yqq && \
    pecl channel-update pecl.php.net
RUN apt-get install -y apt-utils
RUN groupadd -g ${DOCKER_CONTAINER_PGID} ${DOCKER_CONTAINER_GROUP} && \
    useradd -u ${DOCKER_CONTAINER_PUID} -g ${DOCKER_CONTAINER_GROUP} -m ${DOCKER_CONTAINER_USER} -G ${DOCKER_CONTAINER_GROUP} && \
    usermod -p "*" ${DOCKER_CONTAINER_USER}

###########################################################################
# Set Timezone
###########################################################################

ARG APP_TIMEZONE=UTC
ENV APP_TIMEZONE ${APP_TIMEZONE}

RUN ln -snf /usr/share/zoneinfo/${APP_TIMEZONE} /etc/localtime && echo ${APP_TIMEZONE} > /etc/timezone

#
#--------------------------------------------------------------------------
# Install PHP Exts.
#--------------------------------------------------------------------------
#

USER root

RUN apt-get update && apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libmcrypt-dev \
        libpng-dev

RUN docker-php-ext-install -j$(nproc) iconv
RUN docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
    && docker-php-ext-install -j$(nproc) gd

RUN apt-get install -y libxml2-dev
RUN docker-php-ext-install soap

# RUN docker-php-ext-install mcrypt
RUN pecl install channel://pecl.php.net/mcrypt-1.0.1 \
	&& docker-php-ext-enable mcrypt

RUN docker-php-ext-install pdo_mysql
RUN docker-php-ext-install zip
RUN docker-php-ext-install mbstring

ARG DOCKER_PHP_INSTALL_XDEBUG=false
RUN if [ ${DOCKER_PHP_INSTALL_XDEBUG} = true ]; then \
    pecl install xdebug-2.6.0 \
    && docker-php-ext-enable xdebug \
;fi
# Copy xdebug configuration for remote debugging
COPY ./xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini

# Memcached
RUN apt-get install -y libmemcached-dev zlib1g-dev
RUN pecl install memcached \
    && docker-php-ext-enable memcached

# OPcache
RUN docker-php-ext-install opcache
COPY ./opcache.ini /usr/local/etc/php/conf.d/opcache.ini

#
#--------------------------------------------------------------------------
# Final Touch
#--------------------------------------------------------------------------
#

COPY ./project.ini /usr/local/etc/php/conf.d/
RUN sed -i "s/date.timezone=UTC/date.timezone=${APP_TIMEZONE}/g" /usr/local/etc/php/conf.d/project.ini


COPY ./www.conf /usr/local/etc/php-fpm.d/
RUN sed -i "s/{{USER}}/${DOCKER_CONTAINER_USER}/g" /usr/local/etc/php-fpm.d/www.conf
RUN sed -i "s/{{GROUP}}/${DOCKER_CONTAINER_GROUP}/g" /usr/local/etc/php-fpm.d/www.conf

USER root

# Clean up
RUN apt-get clean && \
    rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* && \
    rm /var/log/lastlog /var/log/faillog

# Set default work directory
WORKDIR /var/www

CMD ["php-fpm"]

EXPOSE 9000
