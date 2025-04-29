@extends('master')
@section('content')
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
                    About Us
                </span>
            </h1>
         <p class="px-20 text-black text-2xl text-center">
            <b>The world’s destination
            for design</b>
        </p>
          <p class="px-16 text-black fade-in text-center">
          We’re on a mission to build
the world’s best platform for 2D and 3D home designs
to share with architects.
          </p>
          <div class="flex items-center justify-center min-h-[100vh]">
    <img width="400" class="rounded-lg  mb-8" src="{{ asset('about us.png') }}" alt="duration-300 ease-in-out">
</div>

          <p class="px-20 text-black text-2xl text-center">
            <b>Our Mission And Vision</b>
        </p>
        <p class="px-16 text-black fade-in text-left">
        We’re on a mission to simplify home design by providing a platform to generate high-quality 2D and 3D home designs. Our goal is to help homeowners, architects, and designers easily create, customize, and visualize their dream spaces.
        To become the world’s leading destination for 2D and 3D home design, making the process more accessible, efficient, and inspiring for everyone involved in creating beautiful living spaces. </p>
        </section>


        <div class="mt-16"></div>
@endsection