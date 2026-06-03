<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Management Vape</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @livewireStyles
</head>

<body class="bg-gray-100/60 font-sans text-gray-800 antialiased" x-data="{ sidebarOpen: false }">

    <div class="flex h-screen overflow-hidden">

        <div :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
            class="fixed inset-y-0 left-0 z-30 w-64 bg-slate-900 text-slate-300 transition-transform duration-300 transform md:translate-x-0 md:static md:inset-0 flex flex-col justify-between shadow-xl">

            <div>
                <div class="flex items-center justify-between px-6 py-5 bg-slate-950 text-white">
                    <div class="flex items-center gap-2">
                        <span class="text-2xl">💨</span>
                        <span class="font-black text-lg tracking-wider uppercase">VapeStore AI</span>
                    </div>
                    <button @click="sidebarOpen = false" class="md:hidden text-gray-400 hover:text-white">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <nav class="px-4 py-6 space-y-1.5">
                    <a href="{{ route('rencana.belanja') }}"
                        class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium transition bg-slate-800 text-white shadow-sm">
                        <svg class="w-5 h-5 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                            </path>
                        </svg>
                        Rencana Belanja
                    </a>

                    <a href="{{ route('database.barang') }}"
                        class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium transition hover:bg-slate-800 hover:text-white group">
                        <svg class="w-5 h-5 text-slate-400 group-hover:text-purple-400" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                        Database Barang
                    </a>
                </nav>
