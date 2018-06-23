FROM registry.docker-cn.com/library/nginx:alpine

LABEL maintainer="Seven Du <shiweidu@outlook.com>"

RUN sed -i 's/dl-cdn.alpinelinux.org/mirrors.aliyun.com/' /etc/apk/repositories

ARG PUID=1000
ENV PUID ${PUID}

ARG USERNAME=web
ENV USERNAME ${USERNAME}

RUN rm -rf /etc/nginx/nginx.conf
COPY ./nginx.conf /etc/nginx/
RUN sed -i "s/{{SET_RUNTIME_USER}}/${USERNAME}/g" /etc/nginx/nginx.conf

RUN apk update \
    && apk upgrade
RUN apk add --no-cache bash \
    && adduser -D -H -u ${PUID} -s /bin/bash ${USERNAME}

# Set upstream conf and remove the default conf
RUN echo "upstream php-upstream { server php-fpm:9000; }" > /etc/nginx/conf.d/upstream.conf \
    && rm /etc/nginx/conf.d/default.conf

###########################################################################
# Set Timezone
###########################################################################

ARG APP_TIMEZONE=UTC
ENV APP_TIMEZONE ${APP_TIMEZONE}

RUN ln -snf /usr/share/zoneinfo/${APP_TIMEZONE} /etc/localtime && echo ${APP_TIMEZONE} > /etc/timezone

CMD ["nginx"]

EXPOSE 80
