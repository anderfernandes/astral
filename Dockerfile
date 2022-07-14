FROM ubuntu:focal

RUN apt update

RUN echo 'America/Chicago' > /etc/timezone
RUN apt install -y tzdata --reinstall

RUN apt install -y sqlite3 php-cli php-fpm php-sqlite3 php-gd php-xml nginx-core composer git

#RUN echo 'extension=pdo_sqlite' >> /etc/php/7.4/cli/php.ini
RUN echo 'extension=sqlite3' >> /etc/php/7.4/php.ini

#COPY nginx.conf ./etc/nginx

WORKDIR /usr/share/nginx/html

COPY . .

RUN sqlite3 database/database.sqlite .databases .quit

RUN cd vendor && cd.. || composer install

RUN php artisan storage:link

RUN php artisan migrate:fresh --seed

RUN php artisan key:generate

EXPOSE 8000

# RUN php-fpm -F
# RUN nginx

# CMD ["nginx", "-g", "daemon off;"]

# CMD /usr/bin/php-fpm7 -D; nginx

#CMD php -S 0.0.0.0:8000 -t public

CMD php artisan serve --host=0.0.0.0 --env=development