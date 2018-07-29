FROM orvice/laravel-base:71


ENV PHPWIND_VERSION 2.0.0

ADD entrypoint.sh /var/www/html

RUN touch /var/www/html/.env

ENTRYPOINT ["/var/www/html/entrypoint.sh"]