FROM php:7.4-alpine

COPY cron_jobs.txt /etc/cron.d/cron_jobs

RUN docker-php-ext-install pdo_mysql \
    && /usr/bin/crontab /etc/cron.d/cron_jobs \
    && touch /var/log/cron.log

WORKDIR /var/www

CMD ["/usr/sbin/crond", "-f"]
