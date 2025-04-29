@extends('master')
@section('content')
<body class="leading-normal tracking-normal text-indigo-400   bg-cover bg-fixed"
    style="background-image: url('header.png');">
    <div class="h-full">
        <!--Nav-->
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



        <!-- Form Section -->
        <section class="bg-white py-16">
            <div class="container mx-auto ">
                <h2 class="my-4 text-4xl text-center md:text-5xl text-gray-800 font-bold leading-tight">
                    Design Your Dream Home
                </h2>
                <p class="text-gray-600 text-lg mb-8  text-center">
                    Fill in the details below to get started with your 2D or 3D home design.
                </p>
                <form id="filterForm" class="w-full max-w-lg mx-auto" action="generate-design" method="get">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div class="flex flex-col">
                            <label class="text-gray-700 text-lg font-bold mb-2" for="category">Category</label>
                            <select id="category" name="category" required
                                class="border border-gray-300 p-4 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-400">
                                <option value="">Select Category</option>
                                <option value="Apartment">Apartment</option>
                                <option value="Flat">Flat</option>
                                <!-- <option value="cottage"></option> -->
                                <option value="bungalow">Bungalow</option>
                                <option value="Guest House">Guest House</option>
                                <!-- <option value="contemporary">Contemporary House</option>
                                <option value="colonial">Colonial House</option> -->
                            </select>
                        </div>

                        <div class="flex flex-col">
                            <label class="text-gray-700 text-lg font-bold mb-2" for="floors">Number of Floors</label>
                            <input type="number" id="floors" name="floors" placeholder="Enter number of floors" required
                                class="border border-gray-300 p-4 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-400">
                        </div>

                        <div class="flex flex-col">
                            <label class="text-gray-700 text-lg font-bold mb-2" for="rooms">Number of Rooms</label>
                            <input type="number" id="rooms" name="rooms" placeholder="Enter number of rooms" required
                                class="border border-gray-300 p-4 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-400">
                        </div>

                        <div class="flex flex-col">
                            <label class="text-gray-700 text-lg font-bold mb-2" for="marla">Marla</label>
                            <input required type="text" id="marla" name="marla" placeholder="Enter marla"
                                class="border border-gray-300 p-4 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-400">
                        </div>

                        <div class="flex flex-col w-full">
                            <label class="text-gray-700 text-lg font-bold mb-2" for="type">Type</label>
                            <select id="type" name="type" required
                                class="border border-gray-300 p-4 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-400">
                                <option value="">Select Type</option>
                                <option value="2D">2D</option>
                                <option value="3D">3D</option>
                            </select>
                        </div>
                    </div>

                    <button type="submit"
                        class="bg-gradient-to-r from-green-400 to-pink-500 text-white font-bold py-4 rounded-lg w-full transition duration-300 ease-in-out hover:bg-green-600 flex items-center justify-center">
                        <span>Generate Design</span>
                        <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </button>
                </form>

                <div id="results" class="mt-6 grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4 mb-10"></div>


            </div>
        </section>


        <div class="mt-16"></div>

@endsection