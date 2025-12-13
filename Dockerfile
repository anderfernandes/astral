FROM debian:11

RUN mkdir /run/php

RUN apt update

RUN echo 'America/Chicago' > /etc/timezone
RUN apt install -y tzdata --reinstall

RUN apt install -y sqlite3 php-cli php-fpm php-sqlite3 php-gd php-xml nginx-core composer git

RUN echo 'extension=sqlite3' >> /etc/php/7.4/php.ini
RUN echo 'clear_env = no' >> /etc/php/7.4/fpm/pool.d/www.conf

COPY nginx.conf /etc/nginx/nginx.conf

WORKDIR /var/www/html

COPY . .

RUN mv .env.development .env

RUN sqlite3 database/database.sqlite .databases .quit

RUN cd vendor && cd.. || composer install --optimize-autoloader

RUN php artisan storage:link

RUN php artisan migrate:fresh --seed

RUN php artisan key:generate

RUN php artisan config:clear
RUN php artisan config:cache
#RUN php artisan route:cache

RUN nginx -t

EXPOSE 8000

CMD /usr/sbin/php-fpm7.4; /usr/sbin/nginx -g "daemon off;"
