<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use App\Helpers\ImageHelper;

class ImageHelperServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Register a Blade directive for image rendering
        Blade::directive('image', function ($expression) {
            return "<?php echo \App\Helpers\ImageHelper::renderImage($expression); ?>";
        });
    }
} 