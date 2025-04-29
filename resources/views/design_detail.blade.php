@extends('master')

@php
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Helpers\ImageHelper;
@endphp

@section('content')
<style>
    button[type='submit']{
        background-color: #4CAF50;
        color: white;
    }
</style>
    <body class="leading-normal tracking-normal text-indigo-400 bg-cover bg-fixed"
        style="background-image: url('{{ asset('header.png') }}');">
        <div class="h-full">
            @include('navbar')

            <!-- Main Section -->
            <div class="container pt-24 pb-5 md:pt-36 mx-auto flex flex-wrap flex-col items-center">
                <!-- Left Col -->
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
                <div class="container mx-auto">
                    <h2 class="my-4 text-4xl md:text-5xl text-gray-800 font-bold leading-tight">
                        {{ $design->name }}
                    </h2>

                    <!-- Two Column Layout -->
                    <div class="flex flex-col md:flex-row items-start space-y-4 md:space-y-0 md:space-x-6">
                        <!-- Image Column -->
                        <div class="md:w-3/4">
                            {!! ImageHelper::renderImage($design->thumbnail, $design->name, "w-full h-auto mb-4 rounded-lg") !!}

                            @auth
                                @if ($userPayment && $userPayment->status)
                                    {{-- Payment is verified, show download button --}}
                                    <a href="{{ ImageHelper::getImageUrl($design->thumbnail) }}" 
                                       download
                                       class="inline-flex items-center bg-black text-white font-bold rounded-full px-4 py-2 hover:bg-blue-700 transition">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mr-2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
                                        </svg>
                                        Download
                                    </a>
                                @elseif($userPayment && $userPayment->status != 1)
                                    <div class="text-2xl text-red-500 font-bold">Your request is under review. Please wait
                                        until it is verified.</div>
                                @else
                                    {{-- Payment not made or not verified, show download button that triggers payment --}}
                                    <a href="javascript:void(0);" onclick="showPaymentForm()"
                                        class="inline-flex items-center bg-black text-white font-bold rounded-full px-4 py-2 hover:bg-blue-700 transition">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mr-2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
                                        </svg>
                                        Download
                                    </a>

                                    {{-- Payment Form --}}
                                    <div id="payment-form" class="hidden max-w-lg p-6 bg-white shadow-md rounded-lg mb-3">
                                        <div class="text-2xl text-black">Pay 100</div>
                                        <hr>
                                        <p>
                                            Subscribe now and get unlimited access to download all designs without any
                                            restrictions!
                                        </p>
                                        <form action="{{ route('payments.store') }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="mb-4">
                                                <label for="payment_via"
                                                    class="block text-gray-700 text-sm font-bold mb-2">Select Bank</label>
                                                <select name="payment_via" id="payment_via"
                                                    class="block w-full text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white"
                                                    required>
                                                    <option value="" disabled selected>-- Select Bank --</option>
                                                    <option value="easypaisa">Easypaisa - 9009090</option>
                                                    <option value="jazzcash">JazzCash - 9009090</option>
                                                    <option value="ubl">UBL - 9009090</option>
                                                </select>
                                            </div>

                                            <div class="mb-4">
                                                <label for="receipt" class="block text-gray-700 text-sm font-bold mb-2">Upload
                                                    Receipt</label>
                                                <input type="file" name="receipt" id="receipt"
                                                    class="block w-full text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white"
                                                    required>
                                            </div>

                                            <button type="submit"
                                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                                Submit Payment
                                            </button>
                                        </form>
                                    </div>

                                    <script>
                                        function showPaymentForm() {
                                            // Show the payment form using JavaScript
                                            document.getElementById('payment-form').classList.remove('hidden');
                                        }
                                    </script>
                                @endif
                            @else
                                {{-- Not logged in, redirect to login when trying to download --}}
                                <a href="{{ route('login') }}"
                                    class="inline-flex items-center bg-black text-white font-bold rounded-full px-4 py-2 hover:bg-blue-700 transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mr-2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
                                    </svg>
                                    Download
                                </a>
                            @endauth


                            @auth

                                <button type="button"
                                    class="inline-flex items-center bg-red-500 text-white font-bold rounded-full px-4 py-2 hover:bg-red-700 transition"
                                    onclick="addToWishlist({{ $design->id }})">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M17.593 3.322c1.1.128 1.907 1.077 1.907 2.185V21L12 17.25 4.5 21V5.507c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0 1 11.186 0Z" />
                                    </svg>
                                    Save
                                </button>
                            @endauth

                        </div>

                        <!-- Description Column -->
                        <div class="md:w-1/2">
                            <p class="text-gray-700"><strong>Marla:</strong> {{ $design->marla }}</p>
                            <p class="text-gray-700"><strong>Rooms:</strong> {{ $design->no_of_rooms }}</p>
                            <p class="text-gray-700"><strong>Floors:</strong> {{ $design->no_of_floors }}</p>
                            <p class="text-gray-700"><strong>Type:</strong> {{ $design->type }}</p>
                            <p class="text-gray-700"><strong>Price:</strong> {{ $design->price }}</p>

                            <p>
                                <span
                                    class="bg-pink-500 text-white rounded-full text-xs px-3 py-1 items-center">{{ $design->category->name }}</span>
                            </p>
                        </div>
                    </div>


                    <div class="mt-8">

                    
                        @php
                            $existingRequest = App\Models\Request::where('user_id', Auth::id())
                                ->where('design_id', $design->id)
                                ->first();
                        @endphp

                        <div class="mt-8">
                            @if ($existingRequest)
                                <!-- Show existing request information -->
                                <div class="p-6 bg-gray-100 rounded-lg shadow-md">
                                    <h2 class="text-lg font-semibold mb-4">Your Request Details</h2>
                                    <p><strong>Description:</strong> {{ $existingRequest->description ?? 'N/A' }}</p>
                                    <p><strong>Status:</strong>
                                        @if ($existingRequest->status)
                                            <span
                                                class="text-green-600 bg-green-100 px-2 py-1 rounded-full text-sm">Approved</span>
                                        @else
                                            <span
                                                class="text-red-600 bg-red-100 px-2 py-1 rounded-full text-sm">Pending</span>
                                        @endif
                                    </p>
                                    <table class="min-w-full bg-white border border-gray-200 mt-2">
                                        <thead>
                                            <tr>
                                               
                                                <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm leading-4 text-gray-600 tracking-wider">Old Design</th>
                                                 <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm leading-4 text-gray-600 tracking-wider">New Design</th>
                                              
                                             </tr>
                                        </thead>
                                        <tbody>
                                           
                                            <tr class="hover:bg-gray-100">
                                                
                                                <td class="px-6 py-4 border-b border-gray-200">
                                                    <!-- Display current design thumbnail and name -->
                                                    <img width="150" class="rounded" src="{{ Storage::url($existingRequest->design->thumbnail) ?? '' }}" alt="">  
                                                    {{ $existingRequest->design->name }}
                                                    <!-- File input for new design -->
                                                  
                                                </td>
                                                
                                                 <td>
                                                    <img width="150" class="rounded" src="{{ Storage::url($existingRequest->design_file) ?? '' }}" alt="">  

                                                    <a href="{{ Storage::url($existingRequest->design_file) ?? '' }}" download
                                                        class="inline-flex items-center bg-black text-white font-bold rounded-full px-4 py-1 mt-1 mb-2 hover:bg-blue-700 transition">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                            stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mr-2">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
                                                        </svg>
                                                        Download
                                                    </a>
                                                </td>
                                                
                                                
                                        
                                        
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                @if ($userPayment && $userPayment->status)
                                    <div class="p-6 bg-white rounded-lg shadow-md">
                                        <h2 class="text-xl font-semibold mb-4">Request This Design</h2>

                                        <form action="{{ route('designs.request.store') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="designId" value="{{ $design->id }}">
                                            <div class="mb-4">
                                                <label for="description"
                                                    class="block text-gray-700 text-sm font-bold mb-2">Description
                                                </label>
                                                <textarea required name="description" id="description" rows="3"
                                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
                                                    placeholder="Add a description or any special instructions..."></textarea>
                                                @error('description')
                                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <button type="submit"
                                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                                Submit Request
                                            </button>
                                        </form>
                                @endif

                                @if (session()->has('message'))
                                    <div class="mt-4 text-green-600">
                                        {{ session('message') }}
                                    </div>
                                @endif
                        </div>
                        @endif
                    </div>


                </div>

                <!-- Comments Section -->
                <div class="mt-8">

                    <livewire:comments :model="$design" />
                </div>
        </div>
        </section>
        </div>

        <script>
            function addToWishlist(designId) {
                fetch(`/wishlist/add/${designId}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}', // CSRF token for protection
                        },
                        body: JSON.stringify({
                            design_id: designId
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert(data.message); // Success message
                        } else {
                            alert(data.message); // Error message
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            }
        </script>

    </body>
@endsection
