FROM php:8.2-fpm

# Install dependencies dan ekstensi PHP
RUN apt-get update && apt-get install -y \
    libpng-dev libjpeg-dev libfreetype6-dev \
    libzip-dev zip unzip git curl libicu-dev \
    && docker-php-ext-configure intl \
    && docker-php-ext-install intl pdo pdo_mysql gd zip

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set direktori kerja ke dalam container
WORKDIR /var/www/html

# Salin semua isi repo ke container
COPY . .

# Jalankan composer install
RUN composer install --ignore-platform-reqs --no-interaction --prefer-dist

EXPOSE 9000
CMD ["php-fpm"]
