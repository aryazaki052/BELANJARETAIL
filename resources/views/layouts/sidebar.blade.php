<input type="checkbox" id="sidebar-toggle" class="hidden peer" />

<div class="md:hidden fixed top-4 left-4 z-50">
    <label for="sidebar-toggle" class="block p-2.5 rounded-lg bg-slate-900 text-slate-300 hover:text-white cursor-pointer shadow-lg border border-slate-800 transition active:scale-95">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
        </svg>
    </label>
</div>

<label for="sidebar-toggle" class="fixed inset-0 bg-slate-950/60 z-40 md:hidden backdrop-blur-sm opacity-0 pointer-events-none transition-opacity duration-300 peer-checked:opacity-100 peer-checked:pointer-events-auto">
</label>

<div class="w-64 bg-slate-900 text-slate-300 h-screen fixed md:relative top-0 left-0 z-40 flex flex-col justify-between shadow-2xl border-r border-slate-800 transition-transform duration-300 ease-in-out -translate-x-full md:translate-x-0 peer-checked:translate-x-0 flex-shrink-0">
    
    <div class="md:hidden absolute top-4 right-4">
        <label for="sidebar-toggle" class="block p-1.5 rounded-md text-gray-400 hover:text-white bg-slate-800/50 cursor-pointer">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </label>
    </div>

    <div class="flex flex-col overflow-y-auto h-full">
        <div class="flex items-center gap-2 px-6 py-5 bg-slate-950 text-white flex-shrink-0">
            <span class="text-2xl">💨</span>
            <span class="font-black text-lg tracking-wider uppercase">Jekiniie</span>
        </div>

        <nav class="px-4 py-6 space-y-1.5 flex-1">
            <ul>
                <li class="mb-2">
                    <a href="{{ route('rencana.belanja') }}" 
                       class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-semibold transition {{ request()->routeIs('rencana.belanja') ? 'bg-slate-800 text-white shadow-sm' : 'hover:bg-slate-800 hover:text-white' }}">
                        Rencana Belanja
                    </a>
                </li>
                
                <li class="mb-2">
                    <a href="{{ route('purchase-orders.index') }}" 
                       class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-semibold transition {{ request()->routeIs('purchase-orders.*') ? 'bg-slate-800 text-white shadow-sm' : 'hover:bg-slate-800 hover:text-white' }}">
                        List PO
                    </a>
                </li>

                <li class="mb-2">
                    <a href="{{ route('database.barang') }}" 
                       class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-semibold transition {{ request()->routeIs('database.barang') ? 'bg-slate-800 text-white shadow-sm' : 'hover:bg-slate-800 hover:text-white' }}">
                        Database Barang
                    </a>
                </li>
            </ul>
        </nav>
    </div>

    <div class="p-4 bg-slate-950/60 border-t border-slate-800 flex items-center gap-3 flex-shrink-0">
        <div class="w-9 h-9 rounded-full bg-purple-600 flex items-center justify-center font-bold text-white text-sm flex-shrink-0">
            ADM
        </div>
        <div class="overflow-hidden">
            <h4 class="text-xs font-bold text-white truncate">Administrator</h4>
            <p class="text-[10px] text-gray-400 truncate">Finance Division</p>
        </div>
    </div>

</div>