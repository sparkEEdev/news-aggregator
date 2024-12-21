FROM php:8.3-fpm as php

RUN docker-php-ext-install pdo pdo_mysql

RUN apt-get update && apt-get install -y supervisor

RUN mkdir -p "/etc/supervisor/logs"

COPY ./supervisord.conf /etc/supervisor/supervisord.conf

CMD ["/usr/bin/supervisord", "-n", "-c",  "/etc/supervisor/supervisord.conf"]