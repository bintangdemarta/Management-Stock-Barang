#!/bin/bash

# Wait for MySQL to be ready
echo "Waiting for MySQL to be ready..."
while ! mysqladmin ping -h db --silent; do
    sleep 1
done

echo "MySQL is ready. Running migrations..."

# Run migrations
php artisan migrate --force

# Start PHP-FPM
exec "$@"