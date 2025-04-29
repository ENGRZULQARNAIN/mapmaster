@extends('master')

@section('content')
<div class="container mx-auto py-12 px-4">
    <div class="bg-white rounded-lg shadow-xl p-6">
        <h1 class="text-2xl font-bold mb-6">Storage Path Debugging</h1>
        
        @php
        use Illuminate\Support\Facades\Storage;
        use App\Models\Design;
        
        // Get a sample design
        $design = Design::first();
        
        if ($design) {
            $thumbnailPath = $design->thumbnail;
            
            // Different path formats to test
            $assetPath = asset('storage/'.ltrim($thumbnailPath, 'public/'));
            $storagePath = Storage::url($thumbnailPath);
            
            // Check if files exist
            $publicPath = public_path('storage/'.ltrim($thumbnailPath, 'public/'));
            $fileExists = file_exists($publicPath);
            
            // Get available disk info
            $disks = config('filesystems.disks');
            $defaultDisk = config('filesystems.default');
            
            // Check for symlink
            $publicStoragePath = public_path('storage');
            $symlinkExists = file_exists($publicStoragePath) && is_link($publicStoragePath);
            $symlinkTarget = $symlinkExists ? readlink($publicStoragePath) : 'N/A';
        }
        @endphp
        
        @if($design)
            <div class="mb-8">
                <h2 class="text-xl font-bold mb-4">Design Information</h2>
                <table class="w-full border-collapse">
                    <tr class="bg-gray-100">
                        <th class="border border-gray-300 px-4 py-2 text-left">Parameter</th>
                        <th class="border border-gray-300 px-4 py-2 text-left">Value</th>
                    </tr>
                    <tr>
                        <td class="border border-gray-300 px-4 py-2 font-semibold">Design ID</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $design->id }}</td>
                    </tr>
                    <tr>
                        <td class="border border-gray-300 px-4 py-2 font-semibold">Name</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $design->name }}</td>
                    </tr>
                    <tr>
                        <td class="border border-gray-300 px-4 py-2 font-semibold">Thumbnail Path (DB)</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $thumbnailPath }}</td>
                    </tr>
                </table>
            </div>
            
            <div class="mb-8">
                <h2 class="text-xl font-bold mb-4">Path Testing</h2>
                <table class="w-full border-collapse">
                    <tr class="bg-gray-100">
                        <th class="border border-gray-300 px-4 py-2 text-left">Method</th>
                        <th class="border border-gray-300 px-4 py-2 text-left">Result</th>
                    </tr>
                    <tr>
                        <td class="border border-gray-300 px-4 py-2 font-semibold">asset('storage/'.ltrim($thumbnailPath, 'public/'))</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $assetPath }}</td>
                    </tr>
                    <tr>
                        <td class="border border-gray-300 px-4 py-2 font-semibold">Storage::url($thumbnailPath)</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $storagePath }}</td>
                    </tr>
                    <tr>
                        <td class="border border-gray-300 px-4 py-2 font-semibold">File Exists?</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $fileExists ? 'Yes' : 'No' }}</td>
                    </tr>
                    <tr>
                        <td class="border border-gray-300 px-4 py-2 font-semibold">Full Public Path</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $publicPath }}</td>
                    </tr>
                </table>
            </div>
            
            <div class="mb-8">
                <h2 class="text-xl font-bold mb-4">Storage Configuration</h2>
                <table class="w-full border-collapse">
                    <tr class="bg-gray-100">
                        <th class="border border-gray-300 px-4 py-2 text-left">Parameter</th>
                        <th class="border border-gray-300 px-4 py-2 text-left">Value</th>
                    </tr>
                    <tr>
                        <td class="border border-gray-300 px-4 py-2 font-semibold">Default Disk</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $defaultDisk }}</td>
                    </tr>
                    <tr>
                        <td class="border border-gray-300 px-4 py-2 font-semibold">Storage Symlink Exists?</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $symlinkExists ? 'Yes' : 'No' }}</td>
                    </tr>
                    <tr>
                        <td class="border border-gray-300 px-4 py-2 font-semibold">Symlink Target</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $symlinkTarget }}</td>
                    </tr>
                    <tr>
                        <td class="border border-gray-300 px-4 py-2 font-semibold">APP_URL</td>
                        <td class="border border-gray-300 px-4 py-2">{{ env('APP_URL') }}</td>
                    </tr>
                </table>
            </div>
            
            <div class="mb-8">
                <h2 class="text-xl font-bold mb-4">Image Preview Tests</h2>
                
                <div class="mb-4">
                    <h3 class="font-bold mb-2">Method 1: Using asset()</h3>
                    <img src="{{ $assetPath }}" alt="Asset Path Test" class="h-48 border border-gray-300 p-1 rounded">
                </div>
                
                <div class="mb-4">
                    <h3 class="font-bold mb-2">Method 2: Using Storage::url()</h3>
                    <img src="{{ $storagePath }}" alt="Storage Path Test" class="h-48 border border-gray-300 p-1 rounded">
                </div>
                
                <div class="mb-4">
                    <h3 class="font-bold mb-2">Method 3: Direct path</h3>
                    <img src="/storage/{{ ltrim($thumbnailPath, 'public/') }}" alt="Direct Path Test" class="h-48 border border-gray-300 p-1 rounded">
                </div>
            </div>
        @else
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4" role="alert">
                <p>No designs found in the database.</p>
            </div>
        @endif
        
        <div class="mt-8">
            <h2 class="text-xl font-bold mb-4">Troubleshooting Steps</h2>
            <ol class="list-decimal list-inside space-y-2">
                <li>Make sure you have run <code class="bg-gray-100 px-2 py-1 rounded">php artisan storage:link</code></li>
                <li>Check that APP_URL in your .env file is set correctly</li>
                <li>Verify file permissions on the storage directory</li>
                <li>Make sure images are properly uploaded to storage/app/public/thumbnails</li>
                <li>Check for any JS errors in the console that might be related to image loading</li>
            </ol>
            
            <div class="mt-4">
                <p class="font-bold">Manual Fix Steps:</p>
                <ol class="list-decimal list-inside space-y-2">
                    <li>Delete existing symlink: <code class="bg-gray-100 px-2 py-1 rounded">rm public/storage</code></li>
                    <li>Recreate symlink: <code class="bg-gray-100 px-2 py-1 rounded">php artisan storage:link</code></li>
                    <li>Ensure proper file permissions: <code class="bg-gray-100 px-2 py-1 rounded">chmod -R 775 storage</code></li>
                </ol>
            </div>
        </div>
    </div>
</div>
@endsection 