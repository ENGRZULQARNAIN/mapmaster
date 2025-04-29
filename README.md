# MapMaster

MapMaster is a Laravel-based web application that helps users generate, view, and manage architectural design layouts. It allows users to generate house designs based on parameters like number of rooms, floors, and plot size (marlas).

## Features

- Generate custom house designs based on specifications
- Browse design catalog with thumbnail previews
- Add designs to wishlist for later reference
- User authentication system with admin and customer roles
- Admin dashboard to manage categories, designs, customers and requests
- Payment system for premium designs
- Responsive UI with modern design

## Requirements

- PHP 8.1 or higher
- Composer
- Node.js and NPM
- MySQL/PostgreSQL database
- Web server (Apache, Nginx)

## Installation

Follow these steps to set up the project locally:

1. **Clone the repository**

   ```bash
   git clone <repository-url>
   cd mapmaster
   ```

2. **Install PHP dependencies**

   ```bash
   composer install
   ```

3. **Install Node.js dependencies**

   ```bash
   npm install
   ```

4. **Set up environment variables**

   ```bash
   cp .env.example .env
   ```

   Then edit the `.env` file with your database credentials and other configuration options:

   ```
   APP_URL=http://localhost:8000

   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=mapmaster
   DB_USERNAME=root
   DB_PASSWORD=

   FILESYSTEM_DISK=public
   ```

5. **Generate an application key**

   ```bash
   php artisan key:generate
   ```

6. **Create a symbolic link for storage**

   ```bash
   php artisan storage:link
   ```

7. **Run database migrations and seeders**

   ```bash
   php artisan migrate
   php artisan db:seed
   ```

8. **Build frontend assets**

   ```bash
   npm run dev
   ```

9. **Start the development server**

   ```bash
   php artisan serve
   ```

   The application should now be running at http://localhost:8000

## Database Migrations

The system uses the following main tables:

- `users` - Stores user information with role-based access control
- `categories` - Stores design categories
- `designs` - Stores design information including thumbnails and details
- `wishlists` - Stores user's saved designs
- `payments` - Stores payment information
- `requests` - Stores custom design requests from users

To run migrations separately:

```bash
# Run all pending migrations
php artisan migrate

# Roll back the latest migration operation
php artisan migrate:rollback

# Create a new migration
php artisan make:migration create_new_table
```

## File Storage

This application uses Laravel's public disk for storing design thumbnails and images. Make sure storage symlinks are properly set up:

```bash
php artisan storage:link
```

## Troubleshooting

If you encounter image display issues:

1. Ensure symlinks are properly created with `php artisan storage:link`
2. Clear application caches:
   ```bash
   php artisan config:clear
   php artisan cache:clear
   php artisan view:clear
   php artisan route:clear
   ```
3. Check proper permissions (Unix/Linux/Mac systems):
   ```bash
   chmod -R 775 storage
   chmod -R 775 bootstrap/cache
   ```
4. For Windows users, run command prompt as administrator when creating symlinks

For more detailed troubleshooting, refer to the TROUBLESHOOTING.md file.

## Development Team Usage

### Adding New Design Categories

```bash
php artisan tinker
$category = new \App\Models\Category();
$category->name = "Modern";
$category->save();
```

### Managing User Roles

The application has two main roles: `admin` and `customer`. You can change a user's role via the admin panel or using Tinker:

```bash
php artisan tinker
$user = \App\Models\User::find(1);
$user->role = 'admin';
$user->save();
```

## License

This project is licensed under the MIT License.
