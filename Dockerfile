FROM archlinux:latest

RUN pacman -Sy

RUN pacman -S nginx-mainline php-fpm sqlite php-sqlite --noconfirm

COPY nginx.conf ./etc/nginx

# RUN mkdir /usr/share/nginx/html

WORKDIR /usr/share/nginx/html

EXPOSE 8000

# RUN php-fpm -F
# RUN nginx

# CMD ["nginx", "-g", "daemon off;"]

CMD /usr/bin/php-fpm -D; nginx