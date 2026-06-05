<div class="max-w-7xl mx-auto my-10 px-4 sm:px-6 lg:px-8">
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-visible">
        
        <div class="p-5 bg-gray-50 border-b border-gray-100">
            <h3 class="font-bold text-gray-700 uppercase text-sm tracking-wider">🛒 Daftar Purchase Order</h3>
        </div>

        <div class="w-full overflow-x-auto md:overflow-x-visible block">
            <table class="w-full text-left border-collapse min-w-[768px]">
                <thead>
                    <tr class="bg-gray-100/50 text-gray-500 text-xs font-bold uppercase border-b border-gray-100">
                        <th class="p-4 w-28">Tanggal</th>
                        <th class="p-4">Nama Toko</th>
                        <th class="p-4 w-48">Distribusi</th>
                        <th class="p-4 text-right w-36">Total Belanja</th>
                        <th class="p-4 text-center w-44">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm">
                    @forelse($purchaseOrders as $po)
                        <tr class="hover:bg-gray-50/50 transition">
                            <td class="p-4 font-medium text-gray-800 whitespace-nowrap">
                                {{ $po->created_at->format('d M Y') }}
                            </td>
                            <td class="p-4 font-medium text-gray-600 uppercase">
                                {{ $po->store->name }}
                            </td>
                            <td class="p-4 whitespace-nowrap">
                                @if($po->distributor)
                                    <span class="px-2.5 py-1 rounded-md bg-purple-50 text-purple-700 text-xs font-bold border border-purple-100 uppercase">
                                        {{ $po->distributor->name }}
                                    </span>
                                @else
                                    <span class="text-gray-400 italic text-xs">-</span>
                                @endif
                            </td>
                            <td class="p-4 text-right font-mono text-gray-600 whitespace-nowrap">
                                Rp {{ number_format($po->total_amount, 0, ',', '.') }}
                            </td>
                            <td class="p-4">
                                <div class="flex items-center justify-center gap-2 md:gap-3 text-xs">
                                    
                                    <a href="{{ route('purchase-orders.show', $po->id) }}" class="text-blue-500 hover:text-blue-700 p-1 md:p-0 flex items-center gap-1 transition font-bold" title="View">
                                        <svg class="w-5 h-5 md:w-4 md:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                        <span class="hidden md:inline">View</span>
                                    </a>
                                    
                                    <span class="text-gray-200 hidden md:inline">|</span>

                                    <a href="{{ route('rencana.belanja.edit', $po->id) }}" class="text-yellow-500 hover:text-yellow-700 p-1 md:p-0 flex items-center gap-1 transition font-bold" title="Edit">
                                        <svg class="w-5 h-5 md:w-4 md:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                        <span class="hidden md:inline">Edit</span>
                                    </a>
                                    
                                    <span class="text-gray-200 hidden md:inline">|</span>

                                    <button wire:click="delete({{ $po->id }})" wire:confirm="Apakah Anda yakin ingin menghapus PO ini?" class="text-red-500 hover:text-red-700 p-1 md:p-0 flex items-center gap-1 transition font-bold" title="Hapus">
                                        <svg class="w-5 h-5 md:w-4 md:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                        <span class="hidden md:inline">Hapus</span>
                                    </button>
                                    
                                    <span class="text-gray-200 hidden md:inline">|</span>

                                    <div class="relative inline-block text-left" x-data="{ open: false }">
                                        <button @click="open = !open" @click.away="open = false" class="text-green-600 hover:text-green-800 p-1 md:p-0 flex items-center gap-0.5 transition font-bold" title="Download">
                                            <svg class="w-5 h-5 md:w-4 md:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                            </svg>
                                            <span class="hidden md:inline">Download</span>
                                            <svg class="w-3 h-3 hidden md:inline ml-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                        </button>

                                        <div x-show="open" 
                                             x-transition:enter="transition ease-out duration-100"
                                             x-transition:enter-start="transform opacity-0 scale-95"
                                             x-transition:enter-end="transform opacity-100 scale-100"
                                             x-transition:leave="transition ease-in duration-75"
                                             x-transition:leave-start="transform opacity-100 scale-100"
                                             x-transition:leave-end="transform opacity-0 scale-95"
                                             class="absolute right-0 mt-2 w-52 rounded-lg bg-white shadow-xl ring-1 ring-black ring-opacity-5 divide-y divide-gray-100 z-50 text-left border border-gray-100"
                                             style="display: none;" x-cloak>
                                            
                                            <div class="py-1">
                                                <a href="{{ route('purchase-orders.download', $po->id) }}?type=gudang" @click="open = false" class="flex items-center px-4 py-2 text-xs text-gray-700 hover:bg-amber-50 hover:text-amber-700 transition font-medium">
                                                    <span class="w-2 h-2 rounded-full bg-amber-500 mr-2.5 flex-shrink-0"></span>
                                                    Nama Barang & Qty (Gudang)
                                                </a>
                                            </div>
                                            
                                            <div class="py-1">
                                                <a href="{{ route('purchase-orders.download', $po->id) }}?type=lengkap" @click="open = false" class="flex items-center px-4 py-2 text-xs text-gray-700 hover:bg-green-50 hover:text-green-700 transition font-medium">
                                                    <span class="w-2 h-2 rounded-full bg-green-500 mr-2.5 flex-shrink-0"></span>
                                                    Lengkap + Harga (Finance)
                                                </a>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-8 text-center text-gray-400 italic bg-gray-50/30">
                                Belum ada Purchase Order.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>