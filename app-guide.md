# Homelab Full-Stack Web Application Guide

This document is a **complete, production-oriented README.md** for building a **full-stack web application** on a **homelab server** using **Ubuntu Server, Nginx, PHP, and MySQL**, extended to an **industrial-grade stack** with containerization, security hardening, monitoring, and CI/CD.

---

## 1. Target Architecture (Docker-Based)

All components in this stack run **entirely on Docker**. The host OS (Ubuntu Server) is used **only as a container runtime**, not for installing Nginx, PHP, or MySQL directly.

```
[ Internet ]
     |
[ Nginx (Docker) + SSL ]
     |
[ PHP-FPM (Docker, Laravel) ]
     |
[ MySQL (Docker) ] -- [ Redis (Docker, optional) ]
```

Key principles:

* No services installed directly on the host (except Docker)
* Environment parity (dev = prod)
* Easy rebuild, rollback, and migration

---

## 2. Host System (Docker Runtime Only)

### 2.1 Host Requirements

* Ubuntu Server 22.04 LTS
* Docker Engine
* Docker Compose v2

The host is treated as **immutable infrastructure**.

### 2.2 Install Docker Engine

```bash
sudo apt update
sudo apt install -y ca-certificates curl gnupg
sudo install -m 0755 -d /etc/apt/keyrings
curl -fsSL https://download.docker.com/linux/ubuntu/gpg | sudo gpg --dearmor -o /etc/apt/keyrings/docker.gpg
sudo chmod a+r /etc/apt/keyrings/docker.gpg

echo "deb [arch=$(dpkg --print-architecture) signed-by=/etc/apt/keyrings/docker.gpg] https://download.docker.com/linux/ubuntu $(lsb_release -cs) stable" | sudo tee /etc/apt/sources.list.d/docker.list > /dev/null

sudo apt update
sudo apt install -y docker-ce docker-ce-cli containerd.io docker-buildx-plugin docker-compose-plugin
```

Enable Docker:

```bash
sudo systemctl enable docker
sudo usermod -aG docker $USER
```

Logout/login required after this step.

---

## 3. Web Server Layer (Nginx – Docker)

Nginx runs **inside a container** and acts as:

* Reverse proxy
* Static file server
* SSL termination

### 3.1 Nginx Container Configuration

Directory structure:

```
infrastructure/
 ├── nginx/
 │   └── default.conf
```

`default.conf`:

```nginx
server {
    listen 80;
    server_name localhost;

    root /var/www/app/public;
    index index.php index.html;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass php:9000;
        fastcgi_index index.php;
        include fastcgi_params;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
    }
}
```

---

## 4. PHP Runtime Layer (PHP-FPM – Docker)

PHP runs in its own container using **php-fpm**.

### 4.1 Custom PHP Image

Directory:

```
infrastructure/php/
 └── Dockerfile
```

`Dockerfile`:

```dockerfile
FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    git unzip libzip-dev libpng-dev libonig-dev \
    && docker-php-ext-install pdo pdo_mysql mbstring zip

WORKDIR /var/www/app
```

---

## 5. Database Layer (MySQL – Docker)

The database runs as a **stateful container** with mounted volumes.

Key rules:

* Data lives in Docker volumes
* Containers are disposable

---

## 6. Application Layer (Laravel)

### 6.1 Install Laravel

```bash
composer create-project laravel/laravel app
cd app
php artisan key:generate
```

### 6.2 Environment Configuration (.env)

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://app.local

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_DATABASE=appdb
DB_USERNAME=appuser
DB_PASSWORD=STRONG_PASSWORD
```

### 6.3 File Permissions

```bash
chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache
```

---

## 7. Docker Compose (Single Source of Truth)

All services are orchestrated using **docker-compose.yml**.

### 7.1 Project Structure

```
project-root/
 ├── app/                # Laravel source code
 ├── infrastructure/
 │   ├── nginx/
 │   │   └── default.conf
 │   └── php/
 │       └── Dockerfile
 ├── docker-compose.yml
 └── .env
```

### 7.2 docker-compose.yml

```yaml
version: '3.9'

services:
  nginx:
    image: nginx:alpine
    ports:
      - "80:80"
      - "443:443"
    volumes:
      - ./app:/var/www/app
      - ./infrastructure/nginx:/etc/nginx/conf.d
    depends_on:
      - php

  php:
    build: ./infrastructure/php
    volumes:
      - ./app:/var/www/app

  db:
    image: mysql:8.0
    environment:
      MYSQL_DATABASE: appdb
      MYSQL_USER: appuser
      MYSQL_PASSWORD: strongpassword
      MYSQL_ROOT_PASSWORD: rootpassword
    volumes:
      - db_data:/var/lib/mysql

volumes:
  db_data:
```

Run the stack:

```bash
docker compose up -d --build
```

---

## 8. Security Layer (Docker-Aware)

### 8.1 SSL Termination

Options:

* Nginx + Certbot container
* External reverse proxy (Traefik / Caddy)

### 8.2 Application Security

* Secrets via `.env` (never commit)
* Read-only containers where possible
* Non-root containers

---

## 9. Observability & Monitoring (Containers)

Recommended Docker-native tooling:

* Prometheus (container metrics)
* Grafana
* Loki (logs)

All observability tools run as containers.

---

## 10. CI/CD Pipeline (Docker-First)

```yaml
name: Docker Deploy
on: [push]

jobs:
  deploy:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v4
      - name: Build & Deploy
        run: |
          ssh user@server "cd /srv/app && docker compose pull && docker compose up -d"
```

---

## 11. Scaling Roadmap (Container-Native)

* Add Redis container
* Add queue workers
* Horizontal scaling with Docker Swarm / Kubernetes
* HA storage (Ceph / ZFS)

---

## 12. Final Recommended Technology Stack

| Layer      | Technology           |
| ---------- | -------------------- |
| OS         | Ubuntu Server LTS    |
| Web Server | Nginx                |
| Runtime    | PHP 8.2 FPM          |
| Framework  | Laravel              |
| Database   | MySQL / PostgreSQL   |
| Cache      | Redis                |
| Container  | Docker + Compose     |
| CI/CD      | GitHub Actions       |
| Monitoring | Prometheus + Grafana |
| Security   | UFW, Fail2ban, SSL   |

---

## 13. Next Improvements

* Multi-environment setup (dev / staging / prod)
* Automated backups (database + volumes)
* Secrets management
* Zero-downtime deployment strategy

---

---

# Management Stock Barang – Full-Stack Web Application

This repository implements a **Management Stock Barang (Inventory Management System)** as a **full-stack web application**, fully containerized using **Docker** and designed to run on a **homelab or on-premise server**.

The system is intended for:

* Small to medium warehouses
* Retail stores
* UMKM / SMEs
* Internal company inventory tracking

It focuses on **accuracy, auditability, and operational visibility**.

---

## 14. Project Overview

### 14.1 Business Problem

Manual stock tracking (Excel, paper, ad-hoc tools) causes:

* Inaccurate stock levels
* No real-time visibility
* Difficult audit trails
* High risk of human error

This application solves those problems by providing a **centralized, role-based, web-based inventory management system**.

---

## 15. Core Features

### 15.1 Inventory Management

* Item master data (SKU, name, category, unit)
* Stock-in and stock-out transactions
* Real-time stock calculation
* Minimum stock threshold alerts

### 15.2 Warehouse & Location

* Multi-warehouse support
* Rack / location labeling
* Stock per location

### 15.3 User & Role Management

* Admin
* Warehouse staff
* Read-only / auditor role

### 15.4 Reporting

* Daily / monthly stock movement
* Current stock snapshot
* Low-stock report
* Export to CSV / Excel

### 15.5 Audit & Traceability

* Transaction history
* User action logs
* Timestamped records

---

## 16. Technology Stack (Project-Specific)

| Layer      | Technology                        |
| ---------- | --------------------------------- |
| Frontend   | Blade / Tailwind CSS (Phase 1)    |
| Backend    | Laravel (PHP 8.2)                 |
| API        | RESTful API (Laravel Controllers) |
| Database   | MySQL 8 (Docker)                  |
| Cache      | Redis (Optional)                  |
| Web Server | Nginx (Docker)                    |
| Container  | Docker + Docker Compose           |
| Auth       | Laravel Auth / Sanctum            |
| Monitoring | Prometheus + Grafana              |

---

## 17. High-Level Data Model

### 17.1 Core Tables

* `users`
* `roles`
* `items`
* `categories`
* `warehouses`
* `locations`
* `stock_transactions`
* `audit_logs`

### 17.2 Stock Transaction Logic

* Stock **never updated directly**
* Stock is derived from **immutable transactions**
* Supports accurate audits and rollbacks

---

## 18. Application Flow

```
User Action
   |
   v
Controller (Validation)
   |
   v
Service Layer (Business Logic)
   |
   v
Database Transaction
   |
   v
Audit Log Written
```

---

## 19. API Design (Example)

```http
POST /api/stock/in
POST /api/stock/out
GET  /api/stock/current
GET  /api/reports/low-stock
```

All write operations are:

* Authenticated
* Validated
* Logged

---

## 20. Security Considerations

* Role-based access control (RBAC)
* CSRF protection
* Input validation
* Prepared statements (ORM)
* Secrets managed via `.env`
* No credentials stored in images

---

## 21. Deployment (Docker)

```bash
docker compose up -d --build
```

Environment variables (`.env`):

```env
APP_NAME="Stock Management"
APP_ENV=production
APP_DEBUG=false

DB_HOST=db
DB_DATABASE=inventory
DB_USERNAME=inventory_user
DB_PASSWORD=strongpassword
```

---

## 22. Future Enhancements

* Barcode / QR code scanning
* Purchase & sales integration
* Mobile-friendly UI
* Multi-tenant support
* ERP integration

---

## 23. Target Maturity Level

This project is designed to scale from:

* **Single warehouse, single server**
* To **multi-warehouse, multi-user, HA deployment**

Without architectural rewrite.

---

**This README.md now represents a complete, Docker-native, production-grade full-stack project: *Management Stock Barang*.**
