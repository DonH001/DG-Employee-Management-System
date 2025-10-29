<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'DG Computer EMS') }}</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700&display=swap" rel="stylesheet" />
        <script src="https://cdn.tailwindcss.com"></script>
        <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
        <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
        <style>
            .gradient-bg {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            }
            .glass-effect {
                backdrop-filter: blur(16px);
                -webkit-backdrop-filter: blur(16px);
                background: rgba(255, 255, 255, 0.95);
                border: 1px solid rgba(255, 255, 255, 0.18);
            }
        </style>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen gradient-bg flex flex-col justify-center py-12 sm:px-6 lg:px-8">
            <!-- Background Pattern -->
            <div class="absolute inset-0 overflow-hidden">
                <div class="absolute -top-40 -right-32 w-80 h-80 rounded-full bg-white opacity-10"></div>
                <div class="absolute -bottom-40 -left-32 w-80 h-80 rounded-full bg-white opacity-10"></div>
                <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-96 h-96 rounded-full bg-white opacity-5"></div>
            </div>

            <div class="relative z-10">
                <!-- Header -->
                <div class="sm:mx-auto sm:w-full sm:max-w-md text-center mb-8">
                    <div class="flex justify-center items-center mb-6">
                        <div class="w-16 h-16 bg-white rounded-2xl shadow-lg flex items-center justify-center">
                            <svg class="w-10 h-10 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <h1 class="text-3xl font-bold text-white mb-2">DG Computer EMS</h1>
                    <p class="text-blue-100 text-lg">Digital workforce management solutions</p>
                </div>

                <!-- Main Content -->
                <div class="sm:mx-auto sm:w-full sm:max-w-md">
                    <div class="glass-effect py-10 px-8 shadow-2xl sm:rounded-2xl">
                        {{ $slot }}
                    </div>
                </div>

                <!-- Footer -->
                <div class="mt-8 text-center">
                    <p class="text-blue-100 text-sm">
                        © {{ date('Y') }} DG Computer EMS. All rights reserved.
                    </p>
                </div>
            </div>
        </div>
    </body>
</html>