FROM php:8.3-apache

# Install system dependencies
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    libpq-dev \
    unzip \
    zip \
    git \
    && rm -rf /var/lib/apt/lists/*

# Install PHP extensions (gd, zip, pdo, pdo_pgsql untuk PostgreSQL, bcmath)
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd zip pdo pdo_pgsql bcmath

# Enable Apache mod_rewrite untuk routing Laravel
RUN a2enmod rewrite

# Set DocumentRoot Apache ke folder /public milik Laravel
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Ambil Composer terbaru
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set folder kerja di container
WORKDIR /var/www/html

# Copy semua file project
COPY . .

# Install dependensi PHP tanpa dev dependencies untuk production
RUN composer install --no-dev --optimize-autoloader

# Sesuaikan permission folder storage dan bootstrap/cache agar bisa ditulis oleh Apache
RUN chown -R www-data:www-data storage bootstrap/cache

# Expose port default
EXPOSE 80

# Jalankan migrasi database otomatis saat container start, lalu jalankan Apache
CMD ["sh", "-c", "php artisan migrate --force && apache2-foreground"]
