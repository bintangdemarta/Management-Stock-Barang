FROM php:8.2-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    default-mysql-client

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy entrypoint script
COPY entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/entrypoint.sh

# Set working directory
WORKDIR /var/www/app

# Create necessary directories and set permissions
RUN mkdir -p /var/www/app/storage /var/www/app/bootstrap/cache
RUN chown -R www-data:www-data /var/www/app
RUN chmod -R 775 /var/www/app/storage /var/www/app/bootstrap/cache

USER www-data

# Use the entrypoint script
ENTRYPOINT ["sh", "-c", "/usr/local/bin/entrypoint.sh", "--"]

EXPOSE 9000

CMD ["php-fpm"]