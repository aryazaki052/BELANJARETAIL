<div class="max-w-7xl mx-auto my-10 px-4 sm:px-6 lg:px-8">
    
    <div class="bg-white rounded-xl shadow-lg p-6 mb-8 border border-gray-100 overflow-visible">
        <h2 class="text-2xl font-extrabold text-gray-800 mb-6 flex items-center gap-2">
            💨 Rencana Biaya Belanja Vape
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-end">

            <div class="md:col-span-3">
                <label class="block text-xs font-bold text-gray-600 uppercase mb-1 tracking-wider">Pilih Toko</label>
                <select wire:model="selectedStore" class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:outline-none transition text-sm bg-white cursor-pointer font-medium text-gray-700">
                    @foreach($stores as $store)
                        <option value="{{ $store->id }}">{{ $store->name }}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="relative md:col-span-4">
                <label class="block text-xs font-bold text-gray-600 uppercase mb-1 tracking-wider">Ketik Nama Barang</label>
                <input 
                    type="text" 
                    wire:model.live="search" 
                    placeholder="Contoh: oxva, juta juice, dll..." 
                    class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:outline-none transition text-sm bg-white text-gray-700"
                    wire:keydown.arrow-down.prevent="incrementHighlight"
                    wire:keydown.arrow-up.prevent="decrementHighlight"
                    wire:keydown.enter.prevent="selectHighlightedProduct"
                />

                @if(!empty($searchResults))
                    <div class="absolute z-20 w-full bg-white border border-gray-200 mt-1 rounded-lg shadow-xl overflow-hidden max-h-60 overflow-y-auto">
                        @foreach($searchResults as $index => $product)
                            <button 
                                type="button"
                                wire:click="selectProduct('{{ $product['name'] }}', {{ $product['price'] }})"
                                class="w-full text-left px-4 py-3 hover:bg-purple-50 text-sm text-gray-700 flex justify-between items-center border-b border-gray-50 last:border-0 transition {{ $highlightIndex === $index ? 'bg-purple-100' : '' }}"
                            >
                                <span class="font-medium">{{ $product['name'] }}</span>
                                <span class="text-purple-600 font-bold">Rp {{ number_format($product['price'], 0, ',', '.') }}</span>
                            </button>
                        @endforeach
                    </div>
                @endif
            </div>

            <div class="md:col-span-2">
                <label class="block text-xs font-bold text-gray-600 uppercase mb-1 tracking-wider">Harga Satuan</label>
                <input 
                    type="text" 
                    value="Rp {{ number_format($selectedPrice ?? 0, 0, ',', '.') }}" 
                    disabled 
                    class="w-full px-3 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-gray-500 font-semibold text-sm cursor-not-allowed"
                />
            </div>

            <div class="md:col-span-1.5">
                <label class="block text-xs font-bold text-gray-600 uppercase mb-1 tracking-wider">Jumlah (Qty)</label>
                <input 
                    type="number" 
                    wire:model.live="qty" 
                    min="1"
                    class="w-full px-2 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:outline-none text-sm text-center font-bold bg-white text-gray-800"
                />
            </div>

            <div class="md:col-span-1.5 w-full">
                <button 
                    type="button" 
                    wire:click="addItemToList" 
                    class="w-full bg-purple-600 hover:bg-purple-700 text-white font-bold py-2.5 rounded-lg transition shadow-md text-center text-sm whitespace-nowrap flex items-center justify-center gap-1 active:scale-95"
                >
                    ➕ <span>Tambah</span>
                </button>
            </div>

        </div>

        <div class="mt-4 flex md:hidden">
            <button 
                type="button" 
                wire:click="finishShopping" 
                class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-3 rounded-lg transition shadow-md text-sm flex items-center justify-center gap-1 active:scale-95"
            >
                💾 Simpan Rencana Belanja
            </button>
        </div>

        @if(($selectedPrice ?? 0) > 0)
            <div class="mt-4 text-right text-xs text-gray-500">
                Subtotal item ini: <span class="font-bold text-gray-700 text-sm">Rp {{ number_format($subtotal ?? 0, 0, ',', '.') }}</span>
            </div>
        @endif
    </div>

    <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-visible">
        <div class="p-5 bg-gray-50 border-b border-gray-100 flex justify-between items-center">
            <h3 class="font-bold text-gray-700 uppercase text-sm tracking-wider">📋 Daftar Belanjaan Anda</h3>
            <span class="text-xs bg-purple-100 text-purple-700 font-extrabold px-2.5 py-1 rounded-full">
                {{ count($shoppingList ?? []) }} Item
            </span>
        </div>

        <div class="w-full overflow-x-auto">
            <table class="w-full text-left border-collapse min-w-[650px] md:min-w-full">
                <thead>
                    <tr class="bg-gray-100/50 text-gray-500 text-xs font-bold uppercase border-b border-gray-100">
                        <th class="p-4 w-36">Toko</th>
                        <th class="p-4">Nama Barang</th>
                        <th class="p-4 text-right w-36">Harga</th>
                        <th class="p-4 text-center w-20">Qty</th>
                        <th class="p-4 text-right w-40">Total</th>
                        <th class="p-4 text-center w-28">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm">
                    @forelse(($shoppingList ?? []) as $index => $item)
                        <tr class="hover:bg-gray-50/50 transition">
                            <td class="p-4 font-medium text-gray-600 uppercase whitespace-nowrap">{{ $item['store'] }}</td>
                            <td class="p-4 font-medium text-gray-800">{{ $item['name'] }}</td>
                            <td class="p-4 text-right font-mono text-gray-600 whitespace-nowrap">Rp {{ number_format($item['price'], 0, ',', '.') }}</td>
                            <td class="p-4 text-center font-mono text-gray-600 whitespace-nowrap">{{ $item['qty'] }}</td>
                            <td class="p-4 text-right font-bold text-purple-600 whitespace-nowrap">Rp {{ number_format($item['total'], 0, ',', '.') }}</td>
                            <td class="p-4 text-center">
                                <button type="button" wire:click="removeItem({{ $index }})" class="text-red-500 hover:text-red-700 font-semibold text-xs border border-red-200 px-3 py-1.5 rounded bg-red-50 hover:bg-red-100 transition active:scale-95">
                                    Hapus
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-8 text-center text-gray-400 italic bg-gray-50/30">
                                Belum ada barang di daftar rencana belanja. Ketik nama barang di atas dan klik tambah!
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-5 bg-purple-50 flex flex-col sm:flex-row justify-between items-center border-t border-purple-100 gap-4">
            
            <div class="hidden md:block">
                <button type="button" wire:click="finishShopping" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold px-6 py-2.5 rounded-lg transition shadow-sm text-sm active:scale-95 flex items-center gap-1">
                    💾 Selesai & Simpan PO
                </button>
            </div>
            
            @if(($grandTotal ?? 0) > 0)
                <div class="w-full sm:w-auto flex justify-between sm:justify-end items-center gap-4 ml-auto">
                    <span class="font-extrabold text-purple-950 uppercase tracking-wide text-xs sm:text-sm">Total Estimasi Biaya:</span>
                    <span class="text-xl sm:text-2xl font-black text-purple-700">
                        Rp {{ number_format($grandTotal, 0, ',', '.') }}
                    </span>
                </div>
            @endif
        </div>
    </div>
</div>

@script
<script>
    document.addEventListener('livewire:navigating', (event) => {
        const list = @this.get('shoppingList');
        if (list && list.length > 0) {
            if (!confirm("Anda memiliki item yang belum disimpan. Apakah Anda yakin ingin meninggalkan halaman?")) {
                event.preventDefault();
            }
        }
    });
</script>
@endscript