FROM php:8.4-fpm

# Установка системных зависимостей
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libpq-dev

# Очистка кэша
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Установка PHP-расширений
RUN docker-php-ext-install pdo_pgsql pgsql mbstring exif pcntl bcmath gd

## Создание пользователя и настройка прав
#RUN groupadd -g 1000 www
#RUN useradd -u 1000 -ms /bin/bash -g www www

# Настройка PHP-FPM
RUN mkdir -p /usr/local/etc/php-fpm.d

## Создаём конфигурацию пула www
#RUN echo '[www]' > /usr/local/etc/php-fpm.d/www.conf \
#    && echo 'user = www' >> /usr/local/etc/php-fpm.d/www.conf \
#    && echo 'group = www' >> /usr/local/etc/php-fpm.d/www.conf \
#    && echo 'listen = 9000' >> /usr/local/etc/php-fpm.d/www.conf \
#    && echo 'listen.owner = www' >> /usr/local/etc/php-fpm.d/www.conf \
#    && echo 'listen.group = www' >> /usr/local/etc/php-fpm.d/www.conf \
#    && echo 'listen.mode = 0660' >> /usr/local/etc/php-fpm.d/www.conf \
#    && echo 'pm = dynamic' >> /usr/local/etc/php-fpm.d/www.conf \
#    && echo 'pm.max_children = 5' >> /usr/local/etc/php-fpm.d/www.conf \
#    && echo 'pm.start_servers = 2' >> /usr/local/etc/php-fpm.d/www.conf \
#    && echo 'pm.min_spare_servers = 1' >> /usr/local/etc/php-fpm.d/www.conf \
#    && echo 'pm.max_spare_servers = 3' >> /usr/local/etc/php-fpm.d/www.conf \
#    && echo 'pm.max_requests = 500' >> /usr/local/etc/php-fpm.d/www.conf \
#    && echo 'chdir = /var/www' >> /usr/local/etc/php-fpm.d/www.conf

# Установка Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www