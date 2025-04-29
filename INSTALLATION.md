# MapMaster Installation Guide

This document provides detailed instructions for setting up the MapMaster application on your local environment or server.

## System Requirements

- PHP >= 8.1
- Composer
- Node.js >= 14.x and NPM
- MySQL 5.7+ or PostgreSQL 9.6+
- Apache/Nginx web server
- PHP Extensions:
  - BCMath
  - Ctype
  - Fileinfo
  - JSON
  - Mbstring
  - OpenSSL
  - PDO
  - Tokenizer
  - XML
  - GD (for image processing)

## Step-by-Step Installation

### 1. Clone the Repository

```bash
git clone <repository-url>
cd mapmaster
```

### 2. Install Composer Dependencies

```bash
composer install
```

If you're deploying to production:

```bash
composer install --optimize-autoloader --no-dev
```

### 3. Install NPM Dependencies

```bash
npm install
```

For production:

```bash
npm ci
```

### 4. Configure Environment Variables

Copy the example environment file:

```bash
cp .env.example .env
```

Then edit the `.env` file with your configuration:

```
APP_NAME=MapMaster
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost:8000

LOG_CHANNEL=stack
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=mapmaster
DB_USERNAME=root
DB_PASSWORD=

BROADCAST_DRIVER=log
CACHE_DRIVER=file
FILESYSTEM_DISK=public
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120

MEMCACHED_HOST=127.0.0.1

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379
```

### 5. Generate Application Key

```bash
php artisan key:generate
```

### 6. Create Database

Create a new database on your MySQL/PostgreSQL server that matches the `DB_DATABASE` value in your `.env` file.

### 7. Run Migrations and Seeders

```bash
php artisan migrate
php artisan db:seed
```

For a fresh installation on an existing database:

```bash
php artisan migrate:fresh --seed
```

### 8. Create Storage Symbolic Link

```bash
php artisan storage:link
```

### 9. Set Directory Permissions

On Unix systems:

```bash
chmod -R 775 storage bootstrap/cache
chown -R $USER:www-data storage bootstrap/cache
```

### 10. Compile Assets

For development:

```bash
npm run dev
```

For production:

```bash
npm run build
```

### 11. Start Development Server

```bash
php artisan serve
```

The application should now be accessible at http://localhost:8000.

## Production Deployment

For production environments, follow these additional steps:

### Optimize Configuration

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### Web Server Configuration

#### Apache

Ensure the `DocumentRoot` points to the `public` directory and that `.htaccess` files are enabled with `AllowOverride All`.

Example virtual host configuration:

```apache
<VirtualHost *:80>
    ServerName mapmaster.example.com
    DocumentRoot /path/to/mapmaster/public

    <Directory "/path/to/mapmaster/public">
        AllowOverride All
        Require all granted
    </Directory>

    ErrorLog ${APACHE_LOG_DIR}/mapmaster-error.log
    CustomLog ${APACHE_LOG_DIR}/mapmaster-access.log combined
</VirtualHost>
```

#### Nginx

```nginx
server {
    listen 80;
    server_name mapmaster.example.com;
    root /path/to/mapmaster/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

## Troubleshooting

### Image Display Issues

If images are not displaying correctly:

1. Verify storage symlink exists: `php artisan storage:link`
2. Check filesystem configuration in `.env`: `FILESYSTEM_DISK=public`
3. Ensure proper permissions on storage directory
4. Clear cache: `php artisan cache:clear`

### Migration Issues

If you encounter migration errors:

1. Check database connection in `.env`
2. Try force running migrations: `php artisan migrate --force`
3. If needed, rollback: `php artisan migrate:rollback`

### Permission Issues

Common permission errors and solutions:

1. Storage directory not writable:

   ```bash
   chmod -R 775 storage
   chown -R $USER:www-data storage
   ```

2. Bootstrap cache not writable:
   ```bash
   chmod -R 775 bootstrap/cache
   chown -R $USER:www-data bootstrap/cache
   ```

## Setting Up Admin User

Create a new admin user via Tinker:

```bash
php artisan tinker
$user = new \App\Models\User();
$user->name = "Admin User";
$user->email = "admin@example.com";
$user->password = Hash::make("secure_password");
$user->role = "admin";
$user->save();
exit
```

## Scheduled Tasks

If the application has scheduled tasks, set up a cron job to run Laravel's scheduler:

```
* * * * * cd /path/to/mapmaster && php artisan schedule:run >> /dev/null 2>&1
```
