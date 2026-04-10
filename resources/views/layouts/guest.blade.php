<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'SchoolCanteen') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800,900&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex">
            <!-- Left: Branding Panel -->
            <div class="hidden lg:flex lg:w-1/2 bg-gradient-to-br from-canteen-500 via-canteen-600 to-canteen-700 relative overflow-hidden items-center justify-center p-12">
                <div class="absolute inset-0 opacity-10">
                    <div class="absolute top-10 left-10 w-40 h-40 bg-white rounded-full blur-3xl"></div>
                    <div class="absolute bottom-20 right-10 w-64 h-64 bg-yellow-300 rounded-full blur-3xl"></div>
                    <div class="absolute top-1/2 left-1/4 w-32 h-32 bg-white rounded-full blur-2xl"></div>
                </div>
                <div class="relative z-10 text-white max-w-lg">
                    <div class="flex items-center gap-3 mb-8">
                        <span class="flex items-center justify-center w-14 h-14 bg-white/20 backdrop-blur-sm rounded-2xl text-3xl shadow-lg">🍽</span>
                        <span class="text-3xl font-black italic tracking-tighter">SCHOOLCANTEEN</span>
                    </div>
                    <h1 class="text-5xl font-black leading-tight mb-6 tracking-tight">
                        Order your favorite meals with ease.
                    </h1>
                    <p class="text-canteen-100 text-lg font-medium leading-relaxed">
                        Browse the menu, place orders, and track your queue in real-time — all in one place.
                    </p>
                    <div class="mt-12 flex items-center gap-6 text-sm font-semibold text-white/70">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-canteen-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                            Fast Ordering
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-canteen-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            Live Queue
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right: Form Panel -->
            <div class="w-full lg:w-1/2 flex flex-col items-center justify-center p-6 sm:p-12 bg-[#FFFBF5]">
                <div class="lg:hidden mb-8">
                    <a href="/" class="flex items-center gap-2">
                        <span class="flex items-center justify-center w-10 h-10 bg-gradient-to-br from-canteen-400 to-canteen-600 rounded-xl text-white text-xl shadow-sm">🍽</span>
                        <span class="text-xl font-black italic tracking-tighter text-gray-900">SCHOOL<span class="text-canteen-500">CANTEEN</span></span>
                    </a>
                </div>

                <div class="w-full sm:max-w-md">
                    <div class="bg-white p-8 sm:p-10 rounded-2xl shadow-sm border border-gray-100">
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
