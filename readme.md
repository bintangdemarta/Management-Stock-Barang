# Full-Stack Web Application

This is a full-stack web application built with Laravel, Nginx, MySQL, and Redis using Docker.

## Prerequisites

- Docker
- Docker Compose

## Getting Started

1. Clone this repository
2. Navigate to the project directory
3. Run the following command to start the application:

```bash
docker-compose up -d
```

4. The application will be accessible at `http://localhost`

## Services

- **Nginx**: Web server (port 80)
- **PHP**: PHP-FPM runtime (port 9000 internally)
- **MySQL**: Database server (port 3306)
- **Redis**: Caching server (port 6379)

## Installing Laravel

If you want to install a fresh Laravel application:

1. Enter the PHP container:
```bash
docker exec -it fullstack-web-app-php-1 bash
```

2. Install Laravel in the app directory:
```bash
composer create-project laravel/laravel .
```

3. Generate the application key:
```bash
php artisan key:generate
```

4. Set proper permissions:
```bash
chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache
```

## Stopping the Application

To stop the application, run:

```bash
docker-compose down
```

## Viewing Logs

To view logs for all services:

```bash
docker-compose logs
```

To view logs for a specific service (e.g., nginx):

```bash
docker-compose logs nginx
```

## Troubleshooting

If you encounter issues:

1. Check that Docker and Docker Compose are properly installed
2. Make sure no other services are running on ports 80, 443, 3306, or 6379
3. Check the logs using `docker-compose logs`
4. Ensure file permissions are correct in the app directory