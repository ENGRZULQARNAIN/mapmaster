# Troubleshooting Image Display Issues

If you're experiencing issues with image display in the MapMaster application, please follow these steps to resolve them.

## Quick Fix

Run these commands in your project root:

```bash
# Make sure storage link is properly created
php artisan storage:link

# Clear all caches
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear

# Set proper permissions (on Unix/Linux/Mac systems)
# On Windows, skip this step
chmod -R 775 storage
chmod -R 775 bootstrap/cache
```

## Environment Configuration

Make sure your `.env` file has the correct configuration:

```
APP_URL=http://localhost:8000  # Change to your actual local URL
FILESYSTEM_DISK=public
```

## For Windows Users Specifically

If you're on Windows, you might need extra steps for permissions:

1. Check that the symlink from `public/storage` to `storage/app/public` is created correctly
2. In some Windows environments, you need to run as Administrator to create symlinks
3. Run command prompt as administrator and navigate to your project folder
4. Run `php artisan storage:link` again

## Detailed Image Path Debugging

If you're still having issues:

1. Visit the debugging page at `/debug-storage` to see detailed information about image paths
2. Check the browser's console for any errors related to image loading
3. Verify that image files actually exist in the storage directories

## Browser Cache Issues

Sometimes browser caching can cause image display problems:

1. Hard refresh your browser (Ctrl+F5 or Cmd+Shift+R)
2. Clear your browser cache completely
3. Try a different browser to see if the issue persists

## New ImageHelper Class

We've added a new `ImageHelper` class to help with image paths. You can use it like this:

```php
// In your Blade templates:
{!! ImageHelper::renderImage($design->thumbnail, $design->name, "your-css-classes") !!}

// For image URLs in attributes:
href="{{ ImageHelper::getImageUrl($design->thumbnail) }}"
```

## File Permissions and Storage Structure

Ensure your storage structure is set up correctly:

1. The `storage/app/public/thumbnails` directory should exist
2. Files should be properly uploaded to this directory
3. Permissions should allow web server access (775 for directories, 664 for files)

## Additional Resources

-   [Laravel File Storage Documentation](https://laravel.com/docs/10.x/filesystem)
-   [Laravel Storage Symlinks](https://laravel.com/docs/10.x/filesystem#the-public-disk)

If you're still having issues after trying these solutions, please consult with the development team.
