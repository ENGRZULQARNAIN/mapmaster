<!DOCTYPE html>
<html lang="en" data-theme="aqua">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Map Master</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="min-h-screen  font-sans antialiased bg-base-200/50 dark:bg-base-200">
 
    {{-- The navbar with `sticky` and `full-width` --}}
    <x-mary-nav sticky full-width>
 
        <x-slot:brand >
            {{-- Drawer toggle for "main-drawer" --}}
            <label for="main-drawer" class="lg:hidden mr-3">
                <x-mary-icon name="o-bars-3" class="cursor-pointer" />
            </label>
            
            {{-- Brand --}}
            <div>Map Master</div>
        </x-slot:brand>
 
        {{-- Right side actions --}}
        <x-slot:actions>
       
            <x-mary-theme-toggle darkTheme="dark" lightTheme="light"  />
            {{-- <x-mary-button icon="o-bell" class="btn-ghost btn-sm relative">
                <x-mary-badge value="2" class="badge-error absolute -right-2 -top-2"/>
            </x-mary-button> --}}
        </x-slot:actions>
    </x-mary-nav>
    
   
    <x-mary-toast position="toast-top toast-right" />
    {{-- MAIN --}}
    <x-mary-main with-nav full-width>
        {{-- SIDEBAR --}}
        
        @include('components.layouts.sidebar')
        {{-- The `$slot` goes here --}}
        <x-slot:content>
            {{ $slot }}
        </x-slot:content>
    </x-mary-main>
 
    {{-- Toast --}}
    <x-mary-toast />
    @livewireScripts

</body>
</html>