<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageHelper
{
    /**
     * Generate a robust image URL that works across different environments
     * 
     * @param string|null $path The image path from the database
     * @param string $defaultImage Path to a default image if none is provided
     * @return string The URL to the image with fallback logic
     */
    public static function getImageUrl($path, $defaultImage = null)
    {
        if (empty($path)) {
            return $defaultImage ?: asset('images/no-image.jpg');
        }

        // If it's already a full URL or base64 data
        if (Str::startsWith($path, ['http://', 'https://', 'data:image'])) {
            return $path;
        }

        // Generate both URLs for our JavaScript fallback
        $storageUrl = Storage::url($path);
        $assetUrl = asset('storage/' . ltrim($path, 'public/'));
        
        // Choose the primary URL method (can be adjusted based on environment)
        $primaryUrl = $storageUrl;
        
        // Add a cache buster to prevent browser caching issues
        $cacheBuster = '?v=' . substr(md5(env('APP_NAME', 'laravel') . date('Ymd')), 0, 8);
        
        return $primaryUrl . $cacheBuster;
    }

    /**
     * Render an image tag with multiple fallback mechanisms for maximum compatibility
     * 
     * @param string|null $path The image path from the database
     * @param string $alt Alt text for the image
     * @param string $class CSS classes for the image tag
     * @param string $defaultImage Path to a default image if none is provided
     * @return string HTML for the image with fallback mechanisms
     */
    public static function renderImage($path, $alt = '', $class = '', $defaultImage = null)
    {
        if (empty($path)) {
            $url = $defaultImage ?: asset('images/no-image.jpg');
            return '<img src="' . $url . '" alt="' . e($alt) . '" class="' . $class . '">';
        }

        // If it's already a full URL or base64 data
        if (Str::startsWith($path, ['http://', 'https://', 'data:image'])) {
            return '<img src="' . $path . '" alt="' . e($alt) . '" class="' . $class . '">';
        }

        // Generate both URLs for our JavaScript fallback
        $storageUrl = Storage::url($path);
        $assetUrl = asset('storage/' . ltrim($path, 'public/'));
        $directUrl = '/storage/' . ltrim($path, 'public/');
        
        // Add a cache buster to prevent browser caching issues
        $cacheBuster = '?v=' . substr(md5(env('APP_NAME', 'laravel') . date('Ymd')), 0, 8);
        
        // Build an image tag with onerror fallbacks to try different URL formats
        return '<img src="' . $storageUrl . $cacheBuster . '" 
                    alt="' . e($alt) . '" 
                    class="' . $class . '"
                    onerror="if(!this.retryAsset){
                        console.log(\'Trying asset URL format\');
                        this.retryAsset=true;
                        this.src=\'' . $assetUrl . $cacheBuster . '\';
                    } else if(!this.retryDirect) {
                        console.log(\'Trying direct URL format\');
                        this.retryDirect=true;
                        this.src=\'' . $directUrl . $cacheBuster . '\';
                    } else {
                        console.log(\'All image paths failed\');
                        this.src=\'' . ($defaultImage ?: asset('images/no-image.jpg')) . '\';
                    }">';
    }
} 