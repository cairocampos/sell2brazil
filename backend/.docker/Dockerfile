FROM ambientum/php:7.4-nginx
USER root
ENV XDEBUG_ENABLED=true

RUN apk add php7.4-pdo_sqlite

COPY ./xdebug.ini /etc/php7/conf.d/xdebug.ini