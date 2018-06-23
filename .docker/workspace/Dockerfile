#
#--------------------------------------------------------------------------
# Fans 2 工作区构建
#--------------------------------------------------------------------------
#

FROM registry.docker-cn.com/library/php:7.2-cli

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

RUN apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libmcrypt-dev \
        libpng-dev

RUN docker-php-ext-install -j$(nproc) iconv
RUN docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
    && docker-php-ext-install -j$(nproc) gd

RUN apt-get install -y libxml2-dev
RUN docker-php-ext-install soap

RUN pecl install channel://pecl.php.net/mcrypt-1.0.1 \
	&& docker-php-ext-enable mcrypt

# PDO MYSQL
RUN docker-php-ext-install pdo_mysql

# Zip
RUN docker-php-ext-install zip

# Mbstring
RUN docker-php-ext-install mbstring

# XDebug
ARG DOCKER_PHP_INSTALL_XDEBUG=false
RUN if [ ${DOCKER_PHP_INSTALL_XDEBUG} = true ]; then\
    pecl install xdebug-2.6.0 \
    && docker-php-ext-enable xdebug \
;fi

# Memcached
RUN apt-get install -y libmemcached-dev zlib1g-dev \
    && pecl install memcached \
    && docker-php-ext-enable memcached

#
#--------------------------------------------------------------------------
# Mandatory Software's Installation
#--------------------------------------------------------------------------
#

# Install composer and add its bin to the PATH.
USER root

RUN curl -s http://getcomposer.org/installer | php && \
    echo "export PATH=${PATH}:/var/www/vendor/bin" >> ~/.bashrc && \
    mv composer.phar /usr/local/bin/composer

USER root

# Add the composer.json
COPY ./composer.json /home/${DOCKER_CONTAINER_USER}/.composer/composer.json

# Make sure that ~/.composer belongs to laradock
RUN chown -R ${DOCKER_CONTAINER_USER}:${DOCKER_CONTAINER_GROUP} /home/${DOCKER_CONTAINER_USER}/.composer

USER ${DOCKER_CONTAINER_USER}

# RUN mkdir /home/web/.composer
# run the install
RUN composer global install
RUN composer config -g repo.packagist composer https://packagist.phpcomposer.com

# Export composer vendor path
RUN echo "" >> ~/.bashrc && \
    echo 'export PATH="~/.composer/vendor/bin:$PATH"' >> ~/.bashrc


#
#--------------------------------------------------------------------------
# Final Touch
#--------------------------------------------------------------------------
#

USER root

# Clean up
RUN apt-get clean && \
    rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* && \
    rm /var/log/lastlog /var/log/faillog

# Set default work directory
WORKDIR /var/www
