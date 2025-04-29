@extends('master')
@section('content')

@php
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
@endphp

<body class="leading-normal tracking-normal text-indigo-400 bg-cover bg-fixed"
    style="background-image: url('{{ asset('header.png') }}');">
    <div class="h-full">
        @include('navbar')

        <!-- Loading Spinner -->
        <div id="loader" class="hidden fixed top-0 left-0 right-0 bottom-0 w-full h-screen z-50 overflow-hidden bg-gray-700 opacity-75 flex flex-col items-center justify-center">
            <div class="loader ease-linear rounded-full border-4 border-t-4 border-gray-200 h-12 w-12 mb-4"></div>
            <h2 class="text-center text-white text-xl font-semibold">Generating...</h2>
            <p class="w-1/3 text-center text-white">This may take a few seconds</p>
        </div>

        <!--Main Section-->
        <div class="container pt-24 pb-5 md:pt-36 mx-auto flex flex-wrap flex-col items-center">
            <!-- Generated Image Section -->
            @if(isset($apiResult))
                <div class="bg-white rounded-lg shadow-xl p-6 mb-8 w-full max-w-4xl">
                    <h2 class="text-2xl font-bold mb-4 text-gray-800">
                        @if(isset($apiResult['from_database']) && $apiResult['from_database'])
                            Similar Design Found
                        @else
                            Generated Design
                        @endif
                    </h2>
                    
                    <div class="aspect-w-16 aspect-h-9">
                        @if(isset($apiResult['from_database']) && $apiResult['from_database'])
                            <!-- Display image from database with fallback -->
                            <img src="{{ $apiResult['image'] }}" 
                                 alt="Similar House Design" 
                                 class="rounded-lg object-cover w-full h-full"
                                 onerror="this.onerror=null; if(this.src.indexOf('/storage/') === -1) { 
                                     console.log('Image error, trying fallback'); 
                                     this.src='{{ asset('storage/'.ltrim(str_replace(url('/storage/'), '', $apiResult['image'] ?? ''), 'public/')) }}';
                                 }">
                                 
                            @if(isset($apiResult['design_id']))
                                <div class="mt-4 text-center">
                                    <a href="{{ route('design.detail', $apiResult['design_id']) }}" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-500 to-indigo-600 text-white rounded-md hover:opacity-90">
                                        View Design Details
                                    </a>
                                </div>
                            @endif
                        @elseif(isset($apiResult['image_base64']))
                            <!-- Display base64 image from API -->
                            <img src="data:image/png;base64,{{ $apiResult['image_base64'] }}" 
                                 alt="Generated House Design" 
                                 class="rounded-lg object-cover w-full h-full">
                                 
                            <div class="mt-4 text-center">
                                <a href="#" onclick="downloadImage()" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-green-400 to-pink-500 text-white rounded-md hover:opacity-90">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                    </svg>
                                    Download Design
                                </a>
                            </div>
                        @elseif(isset($apiResult['image']))
                            <!-- Display image URL from API (if not base64) -->
                            <img src="{{ $apiResult['image'] }}" 
                                 alt="Generated House Design" 
                                 class="rounded-lg object-cover w-full h-full">
                                 
                            <div class="mt-4 text-center">
                                <a href="{{ $apiResult['image'] }}" download class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-green-400 to-pink-500 text-white rounded-md hover:opacity-90">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                    </svg>
                                    Download Design
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            @endif
        </div>

        <section class="bg-white py-16">
            <div class="container mx-auto px-4">
                <h2 class="text-2xl font-bold mb-6 text-gray-800">Other Designs You May Like</h2>
                
                @if(count($designs) > 0)
                <div class="mt-6 grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4 mb-10">
                    @foreach ($designs as $design)
                    <div class="border border-gray-300 p-4 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300 mb-4 fade-in">
                        <!-- Existing design card content -->
                        @if($design->thumbnail)
                            @if(Str::startsWith($design->thumbnail, 'data:image') || Str::startsWith($design->thumbnail, 'http'))
                                <!-- Display base64 or URL directly -->
                                <img src="{{ $design->thumbnail }}" alt="{{ $design->name }}" class="w-full h-[200px] mb-2 rounded-lg object-cover">
                            @else
                                <!-- Display from storage path with both methods for compatibility -->
                                <img src="{{ asset('storage/'.ltrim($design->thumbnail, 'public/')) }}" 
                                     alt="{{ $design->name }}" 
                                     class="w-full h-[200px] mb-2 rounded-lg object-cover"
                                     onerror="this.onerror=null; this.src='{{ Storage::url($design->thumbnail) }}'; console.log('Fallback to Storage::url')">
                            @endif
                        @else
                            <div class="w-full h-[200px] bg-gray-200 flex items-center justify-center rounded-lg mb-2">
                                <span class="text-gray-500">No Image</span>
                            </div>
                        @endif
                        
                        <h2 class="text-xl font-bold mb-2">{{ $design->name }}</h2>
                        <p class="text-gray-700"><strong>Marla:</strong> {{ $design->marla }}</p>
                        <p class="text-gray-700"><strong>Rooms:</strong> {{ $design->no_of_rooms }}</p>
                        <p class="text-gray-700"><strong>Floors:</strong> {{ $design->no_of_floors }}</p>
                        <p class="text-gray-700"><strong>Type:</strong> {{ $design->type }}</p>
                        <p class="text-gray-700"><strong>Price:</strong> {{ $design->price }}</p>
                        <p>
                            <span class="bg-pink-500 text-white rounded-full text-xs px-3 py-1 items-center">{{ $design->category->name }}</span>
                        </p>
                        <p class="mt-4">
                            <a href="{{ route('design.detail', $design->id) }}"
                                class="bg-pink-500 text-white font-bold py-2 px-4 rounded hover:bg-pink-600">
                                View
                            </a>
                        </p>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="text-center">
                    <a href="/generate"
                        class="bg-gradient-to-r mx-auto mt-5 from-green-400 to-pink-500 text-black font-bold py-5 px-10 hover:bg-green-600 rounded-full shadow-lg transition duration-300 ease-in-out">
                        Generate More Designs
                    </a>
                </div>
                @endif
            </div>
        </section>
    </div>

    <style>
        .loader {
            border-top-color: #3498db;
            -webkit-animation: spinner 1.5s linear infinite;
            animation: spinner 1.5s linear infinite;
        }

        @-webkit-keyframes spinner {
            0% { -webkit-transform: rotate(0deg); }
            100% { -webkit-transform: rotate(360deg); }
        }

        @keyframes spinner {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('filterForm');
            const loader = document.getElementById('loader');

            if (form) {
                form.addEventListener('submit', function() {
                    loader.classList.remove('hidden');
                });
            }

            window.downloadImage = function() {
                const base64Image = "{{ isset($apiResult['image_base64']) ? $apiResult['image_base64'] : '' }}";
                if (base64Image) {
                    const link = document.createElement('a');
                    link.href = `data:image/png;base64,${base64Image}`;
                    link.download = 'generated-house-design.png';
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);
                }
            }
        });
    </script>
</body>
@endsection