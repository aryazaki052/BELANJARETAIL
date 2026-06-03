<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>69 Vape Distribution</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @livewireStyles
</head>
<body class="bg-gray-100/60 font-sans text-gray-800 antialiased min-h-screen">
    
    <div class="flex h-screen w-full overflow-hidden relative">
        
        @include('layouts.sidebar')

        <div class="flex-1 flex flex-col min-w-0 h-full overflow-y-auto pt-16 md:pt-0">
            <main class="p-4 sm:p-6 flex-1">
                
                {{ $slot }}

            </main>
        </div>

    </div>

    @livewireScripts
</body>
</html>