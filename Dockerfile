# Используем официальный образ PHP 8.1 с Apache
FROM php:7.4-apache

# Устанавливаем необходимые зависимости
RUN apt-get update && apt-get install -y \
    git unzip curl libpng-dev libjpeg-dev libfreetype6-dev \
    libonig-dev libxml2-dev zip libzip-dev \
    && docker-php-ext-install pdo pdo_mysql mbstring zip exif pcntl \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd

# Устанавливаем Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Устанавливаем рабочую директорию
WORKDIR /var/www/html

# Копируем проект в контейнер
COPY . .

# Устанавливаем зависимости
RUN composer install --no-dev --optimize-autoloader

# Открываем порты
EXPOSE 80
RUN a2enmod rewrite
COPY ./docker/apache/000-default.conf /etc/apache2/sites-available/000-default.conf

