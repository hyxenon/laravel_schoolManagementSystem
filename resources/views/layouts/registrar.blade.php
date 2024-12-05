<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />


        <!-- Scripts -->
        <script src="//unpkg.com/alpinejs" defer></script>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @vite('resources/js/app.js')
        @livewireStyles

    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen">
            @include('layouts.header')
            @include('registrar.sidenav')
            <!-- Page Content -->
            <main class="w-full bg-gray-100 flex flex-col lg:ps-[17rem] px-4 py-8 min-h-[calc(100vh-59px)]">

                    {{ $slot }}


            </main>
        </div>
    </body>
    @livewireScripts


</html>
