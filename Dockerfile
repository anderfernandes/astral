FROM archlinux/base:latest

# OS dependencies
RUN pacman -Sy --noconfirm
#RUN pacman -Syu --noconfirm

# PHP/nginx dependencies
RUN pacman -S nodejs-lts-fermium npm git composer php-sqlite php-gd imagemagick php-imagick php-imap --noconfirm

# RUN pacman -S nginx-mainline php-fpm

# Enabling PHP extensions
RUN echo "extension=pdo_sqlite" >> /etc/php/php.ini
RUN echo "extension=sqlite3" >> /etc/php/php.ini

# Creating Astral's directory
RUN mkdir /usr/share/astral

# Setting Astral's workdir
WORKDIR /usr/share/nginx/astral

# Copying files to workdir
COPY . .

# Create database
RUN sqlite3 database/database.sqlite .databases .quit

# Enable GD extension
RUN echo "extension=gd" >> /etc/php/php.ini

# Astral Environment Variables
RUN touch .env
RUN echo "APP_NAME=Astral" >> .env
RUN echo "APP_ENV=local" >> .env
RUN echo "APP_KEY=" >> .env
RUN echo "APP_DEBUG=true" >> .env
RUN echo "APP_LOG_LEVEL=debug" >> .env
RUN echo "APP_URL=http://0.0.0.0" >> .env
RUN echo "TIMEZONE=America/Chicago" >> .env
RUN echo "" >> .env
RUN echo "DB_CONNECTION=sqlite" >> .env
# RUN echo -e "DB_HOST=127.0.0.1" >> .env
# RUN echo -e "DB_PORT=3306" >> .env
RUN echo "DB_DATABASE=/usr/share/nginx/astral/database/database.sqlite" >> .env
# RUN echo -e "DB_USERNAME=homestead >> .env"
# RUN echo -e "DB_PASSWORD=secret >> .env"

RUN echo "BROADCAST_DRIVER=log" >> .env
RUN echo "CACHE_DRIVER=file" >> .env
RUN echo "SESSION_DRIVER=file" >> .env
RUN echo "QUEUE_DRIVER=sync" >> .env
RUN echo "" >> .env
RUN echo "REDIS_HOST=127.0.0.1" >> .env
RUN echo "REDIS_PASSWORD=null" >> .env
RUN echo "REDIS_PORT=6379" >> .env
RUN echo "" >> .env
RUN echo "MAIL_DRIVER=smtp" >> .env
RUN echo "MAIL_HOST=" >> .env
RUN echo "MAIL_PORT=25" >> .env
RUN echo "MAIL_FROM_ADDRESS=" >> .env
RUN echo "MAIL_FROM_NAME=" >> .env
RUN echo "MAIL_ENCRYPTION=null" >> .env
RUN echo "" >> .env
RUN echo "MAIL_USERNAME=" >> .env
RUN echo "MAIL_PASSWORD=" >> .env
RUN echo "" >> .env
RUN echo "PUSHER_APP_ID=" >> .env
RUN echo "PUSHER_APP_KEY=" >> .env
RUN echo "PUSHER_APP_SECRET=" >> .env

# Astral's PHP dependencies
RUN composer install

# Generate Astral encrypion keys
RUN php artisan key:generate

# Seeding database
RUN php artisan migrate:fresh --seed

# Expose container port
EXPOSE 8000

CMD ["php", "artisan", "serve", "--host=0.0.0.0"]