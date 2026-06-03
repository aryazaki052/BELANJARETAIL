<div class="fixed inset-0 z-50 overflow-y-auto flex items-center justify-center p-4">
    
    <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" wire:click="closeModal()"></div>

    <div class="relative bg-white rounded-xl shadow-2xl max-w-md w-full overflow-hidden border border-gray-100 z-10 transform transition-all animate-in fade-in zoom-in-95 duration-200">
        
        <div class="bg-gray-50 px-6 py-4 border-b border-gray-100 flex justify-between items-center">
            <h3 class="text-sm font-bold text-gray-700 uppercase tracking-wide">
                📦 Formulir Data Produk
            </h3>
            <button type="button" wire:click="closeModal()" class="text-gray-400 hover:text-gray-600 focus:outline-none">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        <form wire:submit.prevent="store()" class="p-6 space-y-4">
            <div>
                <label class="block text-xs font-bold text-gray-600 uppercase tracking-wider mb-1">Nama Produk:</label>
                <input 
                    type="text" 
                    wire:model="name" 
                    placeholder="Masukkan Nama Produk" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:outline-none transition text-sm"
                />
                @error('name') <span class="text-red-500 text-xs mt-1 block font-medium">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-600 uppercase tracking-wider mb-1">Harga (Rp):</label>
                <input 
                    type="number" 
                    wire:model="price" 
                    placeholder="Masukkan Harga" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:outline-none transition text-sm font-semibold"
                />
                @error('price') <span class="text-red-500 text-xs mt-1 block font-medium">{{ $message }}</span> @enderror
            </div>

            <div class="pt-4 flex justify-end gap-3 border-t border-gray-100 mt-6">
                <button 
                    type="button" 
                    wire:click="closeModal()" 
                    class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-600 rounded-lg font-bold text-sm transition"
                >
                    Batal
                </button>
                <button 
                    type="submit" 
                    class="px-5 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded-lg font-bold text-sm transition shadow-md"
                >
                    Simpan
                </button>
            </div>
        </form>

    </div>
</div>