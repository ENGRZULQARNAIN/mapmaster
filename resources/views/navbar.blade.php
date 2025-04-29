<div class="w-full container mx-auto fade-in">
    <div class="w-full flex items-center justify-between">
        <a class="flex items-center text-indigo-400 no-underline hover:no-underline font-bold text-2xl lg:text-4xl p-2"
            href="/">
            <img width="80" class="rounded-lg" src="{{ asset('logo.jpg') }}" alt="">
        </a>

        <div class="flex w-1/2 justify-end content-center">
            <a class="inline-block hover:cursor-pointer text-white no-underline hover:text-white text-center h-10 p-2 md:h-auto md:p-4 transform hover:scale-125 duration-300 ease-in-out"
                href="/">
                Home
            </a>

            <a class="inline-block hover:cursor-pointer text-white no-underline hover:text-white text-center h-10 p-2 md:h-auto md:p-4 transform hover:scale-125 duration-300 ease-in-out"
                href="/about-us">
                About Us
            </a>
            <a class="inline-block hover:cursor-pointer text-white no-underline hover:text-white text-center h-10 p-2 md:h-auto md:p-4 transform hover:scale-125 duration-300 ease-in-out"
                href="/generate">
                Generate
            </a>

            <!-- Check if the user is logged in -->
            @guest
                <!-- If the user is not logged in, show Login and Register -->
                <a class="inline-block hover:cursor-pointer text-white no-underline hover:text-white text-center h-10 p-2 md:h-auto md:p-4 transform hover:scale-125 duration-300 ease-in-out"
                    href="{{ route('login') }}">
                    Login
                </a>
                <a class="inline-block hover:cursor-pointer text-white no-underline hover:text-white text-center h-10 p-2 md:h-auto md:p-4 transform hover:scale-125 duration-300 ease-in-out"
                    href="{{ route('register') }}">
                    Register
                </a>
            @else

            <a class="inline-block hover:cursor-pointer text-white no-underline hover:text-white text-center h-10 p-2 md:h-auto md:p-4 transform hover:scale-125 duration-300 ease-in-out"
                    href="{{ route('my_wishlist') }}">
                    My wishlist
                </a>
               <strong class="inline-block  mt-1 md:py-4 md:px-2"> {{ auth()->user()->name }}</strong>
                <a class="inline-block bg-gradient-to-r from-blue-500 to-indigo-600 text-white font-bold rounded-full  mt-1 md:py-4 md:px-8 shadow-lg hover:shadow-2xl transform transition-all duration-300 ease-in-out hover:scale-110 hover:from-pink-500 hover:to-purple-600"
                    href="{{ route('logout') }}"
                     >
                    Logout
                </a>

 
            @endguest
        </div>

    </div>
</div>
