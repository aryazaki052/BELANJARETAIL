<div class="max-w-7xl mx-auto my-10 px-4 sm:px-6 lg:px-8">
    <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100">
        
        <div class="p-5 bg-gray-50 border-b border-gray-100 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <h3 class="font-bold text-gray-700 uppercase text-sm tracking-wider">📦 Database Barang</h3>
            
            <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 w-full sm:w-auto">
                <form wire:submit.prevent="importExcel" class="flex items-center justify-between gap-2 bg-white border border-gray-200 p-1.5 rounded-lg shadow-sm w-full sm:w-auto overflow-hidden">
                    <input 
                        type="file" 
                        wire:model="excelFile" 
                        accept=".xlsx, .xls"
                        class="text-xs text-gray-500 file:mr-2 file:py-1.5 file:px-2.5 file:rounded-md file:border-0 file:text-xs file:font-bold file:bg-purple-50 file:text-purple-700 hover:file:bg-purple-100 cursor-pointer min-w-0 flex-1"
                    />
                    <button 
                        type="submit" 
                        wire:loading.attr="disabled"
                        class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold px-3 py-2 rounded-md text-xs transition shadow-sm flex items-center gap-1 flex-shrink-0 whitespace-nowrap"
                    >
                        <span wire:loading.remove wire:target="excelFile">📥 Impor Excel</span>
                        <span wire:loading wire:target="excelFile">Mengunggah...</span>
                    </button>
                </form>

                <button wire:click="create()" class="bg-purple-600 hover:bg-purple-700 text-white font-bold px-4 py-2.5 rounded-lg transition shadow-md text-sm flex items-center justify-center gap-1 whitespace-nowrap w-full sm:w-auto">
                    ✨ Tambah Produk Baru
                </button>
            </div>
        </div>

        @if (session()->has('message'))
            <div class="p-4 bg-green-100 text-green-700 font-medium text-sm border-b border-green-200">
                {{ session('message') }}
            </div>
        @endif
        @if (session()->has('error'))
            <div class="p-4 bg-red-100 text-red-700 font-medium text-sm border-b border-red-200">
                {{ session('error') }}
            </div>
        @endif

        <div class="p-5 bg-white border-b border-gray-100 flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-4">
            
            <div class="relative w-full max-w-md">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </span>
                <input 
                    type="text" 
                    wire:model.live="search" 
                    placeholder="Cari nama produk di database..." 
                    class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:outline-none transition text-sm text-gray-700 bg-gray-50/50"
                />
            </div>
            
            <div class="flex items-center gap-2 justify-between sm:justify-end">
                <div wire:loading wire:target="search, perPage" class="text-xs text-purple-600 font-semibold animate-pulse mr-2">
                    Memproses data...
                </div>
                
                <label for="perPage" class="text-xs font-semibold text-gray-500 uppercase tracking-wider whitespace-nowrap">Tampilkan:</label>
                <select 
                    id="perPage"
                    wire:model.live="perPage" 
                    class="py-1.5 pl-3 pr-8 border border-gray-300 bg-white rounded-lg text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-purple-500 transition cursor-pointer font-medium shadow-sm"
                >
                    <option value="10">10 Baris</option>
                    <option value="30">30 Baris</option>
                    <option value="50">50 Baris</option>
                </select>
            </div>
        </div>

        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-100/50 text-gray-500 text-xs font-bold uppercase border-b border-gray-100">
                    <th class="p-4">Nama Produk</th>
                    <th class="p-4 text-right">Harga</th>
                    <th class="p-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-sm">
                @forelse($products as $product)
                    <tr class="hover:bg-gray-50/50 transition">
                        <td class="p-4 font-medium text-gray-800">{{ $product->name }}</td>
                        <td class="p-4 text-right font-mono text-gray-600">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                        <td class="p-4 text-center">
                            <div class="flex justify-center gap-4">
                                <button wire:click="edit({{ $product->id }})" class="text-yellow-500 hover:text-yellow-700 font-semibold transition">Edit</button>
                                <button wire:click="delete({{ $product->id }})" wire:confirm="Yakin ingin menghapus produk ini?" class="text-red-500 hover:text-red-700 font-semibold transition">Hapus</button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="p-8 text-center text-gray-400 italic bg-gray-50/30">
                            Produk dengan nama "{{ $search }}" tidak ditemukan di database.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="p-4 border-t border-gray-100">
            {{ $products->links() }}
        </div>
    </div>

    @if($isOpen)
        @include('livewire.product-form')
    @endif
</div>