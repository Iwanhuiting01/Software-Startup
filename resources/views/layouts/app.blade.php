<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

        <title>DealTrip</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            /* Ensure the full height is utilized */
            html, body {
                height: 100%;
                margin: 0; /* Remove default margins */
            }

            body {
                display: flex;
                flex-direction: column;
                min-height: 100%; /* Ensure the body takes the full height */
            }

            main {
                flex: 1; /* Push the footer to the bottom */
            }
        </style>
    </head>
    <body class="font-sans antialiased">
        <div class="bg-gray-100 flex flex-col min-h-full">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            @yield('header')

            <!-- Page Content -->
            <main class="bg-gray-100">
                @yield('content')
            </main>

            <!-- Footer Section -->
            <div class="bg-gray-100">
                <footer class="bg-gray-800 text-white p-6 mt-12">
                    <div class="container mx-auto flex flex-wrap justify-between">
                        <div class="w-full md:w-1/3 mb-6 md:mb-0">
                            <h3 class="font-bold text-lg mb-4">Contact</h3>
                            <p>Email: info@dealtrip.nl</p>
                            <p>Telefoon: +31 6 12345678</p>
                        </div>
                        <div class="w-full md:w-1/3 mb-6 md:mb-0">
                            <h3 class="font-bold text-lg mb-4">Volg ons</h3>
                            <p><a href="#" class="hover:underline">Instagram</a></p>
                            <p><a href="#" class="hover:underline">TikTok</a></p>
                        </div>
                        <div class="w-full md:w-1/3">
                            <h3 class="font-bold text-lg mb-4">Over DealTrip</h3>
                            <p>Wij bieden betaalbare groepsvakanties waarmee je kunt netwerken, nieuwe vrienden kunt maken en onvergetelijke herinneringen kunt creëren!</p>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
    </body>
</html>
