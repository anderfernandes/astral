FROM archlinux:latest

RUN pacman -Sy

RUN pacman -S nginx-mainline php-fpm php-sqlite --noconfirm

RUN echo 'extension=pdo_sqlite' >> /etc/php/php.ini
RUN echo 'extension=sqlite3' >> /etc/php/php.ini

COPY nginx.conf ./etc/nginx

# RUN mkdir /usr/share/nginx/html

WORKDIR /usr/share/nginx/html

EXPOSE 8000

# RUN php-fpm -F
# RUN nginx

# CMD ["nginx", "-g", "daemon off;"]

CMD /usr/bin/php-fpm -D; nginx