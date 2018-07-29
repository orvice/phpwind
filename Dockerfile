FROM orvice/laravel-base


ENV PHPWIND_VERSION 2.0.0

ADD entrypoint.sh /var/www/html/entrypoint.sh

RUN touch /var/www/html/.env

ENTRYPOINT ["/var/www/html/entrypoint.sh"]
