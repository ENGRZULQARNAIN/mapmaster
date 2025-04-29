@extends('master')
@section('content')

@php
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
@endphp

<body class="leading-normal tracking-normal text-indigo-400   bg-cover bg-fixed"
    style="background-image: url('{{ asset('header.png') }}');">
    <div class="h-full">
        @include('navbar')

        <!--Main Section-->
        <div class="container pt-24 pb-5 md:pt-36 mx-auto flex flex-wrap flex-col items-center">
            <!--Left Col-->
            <div class="text-center w-full xl:w-2/5 overflow-y-hidden fade-in">
                <h1 class="my-4 text-4xl md:text-6xl text-white opacity-90 font-bold leading-tight space-y-4">
                    Stunning
                    <span
                        class="bg-clip-text text-transparent bg-gradient-to-r from-green-400 via-pink-500 to-purple-500">
                        2D & 3D Home Designs
                    </span>
                    for Modern Living!
                </h1>
            </div>
        </div>

        <section class="bg-white py-16">
            <h1 class="my-4 text-4xl text-center md:text-6xl text-white font-bold leading-tight space-y-4">
                <span
                    class="bg-clip-text text-transparent bg-gradient-to-r from-green-400 via-pink-500 to-purple-500 fade-in"">
                    My Wishlist
                </span>
            </h1>
            @if(count($designs) > 0)
                <div class="mt-6 grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4 mb-10 max-w-7xl mx-auto">
                    @foreach ($designs as $wishlistItem)
                        <div class="border border-gray-300 p-4 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300 mb-4 fade-in transform hover:scale-105">
                            @if($wishlistItem->design->thumbnail)
                                @if(Str::startsWith($wishlistItem->design->thumbnail, 'data:image') || Str::startsWith($wishlistItem->design->thumbnail, 'http'))
                                    <!-- Display base64 or URL directly -->
                                    <img src="{{ $wishlistItem->design->thumbnail }}" alt="{{ $wishlistItem->design->name }}" 
                                         class="w-full h-[200px] object-cover mb-2 rounded-lg transition-transform duration-300 transform hover:scale-110">
                                @else
                                    <!-- Display from storage path with asset helper -->
                                    <img src="{{ asset('storage/'.$wishlistItem->design->thumbnail) }}" alt="{{ $wishlistItem->design->name }}" 
                                         class="w-full h-[200px] object-cover mb-2 rounded-lg transition-transform duration-300 transform hover:scale-110">
                                @endif
                            @else
                                <div class="w-full h-[200px] bg-gray-200 flex items-center justify-center rounded-lg mb-2">
                                    <span class="text-gray-500">No Image</span>
                                </div>
                            @endif
                            <h2 class="text-xl font-bold mb-2">{{ $wishlistItem->design->name }}</h2>
        
                            <p class="text-gray-700"><strong>Marla:</strong> {{ $wishlistItem->design->marla }}</p>
                            <p class="text-gray-700"><strong>Rooms:</strong> {{ $wishlistItem->design->no_of_rooms }}</p>
                            <p class="text-gray-700"><strong>Floors:</strong> {{ $wishlistItem->design->no_of_floors }}</p>
                            <p class="text-gray-700"><strong>Type:</strong> {{ $wishlistItem->design->type }}</p>
                            <p class="text-gray-700"><strong>Price:</strong> {{ $wishlistItem->design->price }}</p>
                            <p>
                                <span class="bg-pink-500 text-white rounded-full text-xs px-3 py-1 items-center">{{ $wishlistItem->design->category->name }}</span>
                            </p>
                            <p class="mt-4">
                                <a href="{{ route('design.detail', $wishlistItem->design->id) }}"
                                    class="bg-pink-500 text-white font-bold py-2 px-4 rounded hover:bg-pink-600 transition duration-300 transform hover:scale-105">
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
                        Generate
                    </a>
                    
                    <h1 class="text-7xl mt-40 mb-40 font-bold text-red-500">No Record found</h1>
                </div>
            @endif
        </section>


        <div class="mt-16"></div>
@endsection