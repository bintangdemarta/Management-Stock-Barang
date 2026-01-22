#!/bin/bash

# Wait for MySQL to be ready
echo "Waiting for MySQL to be ready..."
while ! mysqladmin ping -h "$DB_HOST" -u "$DB_USERNAME" -p"$DB_PASSWORD" --skip-ssl --silent; do
    sleep 1
done

echo "MySQL is ready. Running migrations..."

# Run migrations
php artisan migrate --force

# Start PHP-FPM
exec "$@"