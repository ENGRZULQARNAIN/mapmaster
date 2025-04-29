@extends('master')
@section('content')

@php
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
@endphp

    <body class="leading-normal tracking-normal text-indigo-400   bg-cover bg-fixed"
        style="background-image: url('header.png');">
        <div class="h-full">
            <!--Nav-->
            @include('navbar')

            <!-- Debug info for checking paths - REMOVE AFTER FIXING -->
            @if(count($designs) > 0)
                @php 
                    $debug_design = $designs->first();
                    $debug_path = $debug_design->thumbnail;
                    $debug_file_exists = file_exists(public_path('storage/'.$debug_path));
                    $debug_full_path = public_path('storage/'.$debug_path);
                @endphp
                <!-- <div class="bg-white p-4 m-4 rounded shadow">
                    <h3 class="font-bold">Debug Info (remove after fixing):</h3>
                    <p>Thumbnail path: {{ $debug_path }}</p>
                    <p>Full path: {{ $debug_full_path }}</p>
                    <p>File exists: {{ $debug_file_exists ? 'Yes' : 'No' }}</p>
                    <p>Image tag to try: <code>&lt;img src="{{ asset('storage/'.$debug_path) }}"&gt;</code></p>
                </div> -->
            @endif

            <!--Main Section-->
            <div class="container pt-24 md:pt-36 mx-auto flex flex-wrap flex-col md:flex-row items-center">
                <!--Left Col-->
                <div class="flex flex-col w-full xl:w-2/5 justify-center lg:items-start overflow-y-hidden fade-in">
                    <h1
                        class="my-4 text-3xl md:text-5xl text-white opacity-75 font-bold leading-tight text-center md:text-left space-y-4">
                        Stunning
                        <span
                            class="bg-clip-text text-black">
                            2D & 3D Home Designs
                        </span>
                        for Modern Living!
                    </h1>
                    <p class="leading-normal md:text-2xl mb-8 text-center md:text-left text-white">
                        Bringing your dream home to life through cutting-edge 2D floor plans and immersive 3D
                        visualizations.
                    </p>
                    <a href="/generate"
                        class="bg-gradient-to-r mt-5 bg-green-700   text-white font-bold py-5 px-10 hover:bg-green-600 rounded-full shadow-lg   transition duration-300 ease-in-out">Generate</a>
                </div>

                <!--Right Col-->
                <div class="w-full xl:w-3/5 p-12 overflow-hidden">
                    <img class="mx-auto w-full md:w-4/5 transform -rotate-6 transition hover:scale-105 duration-700  border-4 border-purple-700 rounded-lg ease-in-out hover:rotate-6"
                        src="home2.png" />
                </div>
            </div>
 
            <section class="bg-white py-16 ">
                <div class="mt-6 grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4 mb-10 max-w-7xl mx-auto">
                    @foreach ($designs as $design)
                      
                        <div class="border border-gray-300 p-4 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300 mb-4 fade-in transform hover:scale-105">
                            @if($design->thumbnail)
                                @if(Str::startsWith($design->thumbnail, 'data:image') || Str::startsWith($design->thumbnail, 'http'))
                                    <!-- Display base64 or URL directly -->
                                    <img src="{{ $design->thumbnail }}" alt="{{ $design->name }}"
                                        class="w-full h-[200px] object-cover mb-2 rounded-lg">
                                @else
                                    <!-- Display from storage path with both methods for compatibility -->
                                    <img src="{{ asset('storage/'.ltrim($design->thumbnail, 'public/')) }}" 
                                        alt="{{ $design->name }}"
                                        class="w-full h-[200px] object-cover mb-2 rounded-lg"
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
                                <span
                                    class="bg-pink-500 text-white rounded-full text-xs px-3 py-1 items-center">{{ $design->category->name }}</span>
                            </p>
                            <p class="mt-4 ">
                                <a href="{{ route('design.detail', $design->id) }}"
                                    class="bg-pink-500 text-white font-bold py-2 px-4 rounded hover:bg-pink-600  ">
                                    View
                                </a>
                            </p>
                        </div>
                    @endforeach
                </div>

            </section>

            <!-- Services Section -->
          
        @endsection
