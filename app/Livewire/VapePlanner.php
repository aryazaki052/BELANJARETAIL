<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
use App\Models\Store;
use App\Models\Distributor; // Ditambahkan untuk data master distributor
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;

class VapePlanner extends Component
{
    // Properti untuk form pencarian tunggal
    public string $search = '';
    
    // PERBAIKAN UTAMA: Mengunci tipe data ke array murni agar Livewire v3 bisa melakukan hidrasi secara instan di HP tanpa error 500
    public array $searchResults = []; 
    public int|float $selectedPrice = 0;
    public int $qty = 1;
    public int|float $subtotal = 0;

    // Properti untuk toko
    public $stores = []; 
    public string|int $selectedStore = '';

    // Properti untuk distributor (Fitur Baru)
    public $distributors = [];
    public string|int $selectedDistributor = '';

    // Properti untuk mode edit
    public ?int $editingPoId = null; 

    // Properti untuk highlight navigasi keyboard
    public int $highlightIndex = -1;

    // Properti untuk menampung daftar belanjaan yang ditambahkan ke keranjang/list
    public array $shoppingList = [];
    public int|float $grandTotal = 0;

    public function mount($id = null): void
    {
        // Mengonversi data Store & Distributor ke Array / Collection agar aman di jaringan lokal
        $this->stores = Store::all();
        $this->distributors = Distributor::all();
        
        if ($id) {
            $this->editingPoId = (int)$id;
            $po = PurchaseOrder::with('items')->findOrFail($id);
            /** @var PurchaseOrder $po */
            $this->selectedStore = $po->store_id;
            $this->selectedDistributor = $po->distributor_id ?? ''; // Mengambil data distributor lama saat edit
            $this->grandTotal = $po->total_amount;
            $this->shoppingList = $po->items->map(function (PurchaseOrderItem $item) {
                return [
                    'store' => $item->purchaseOrder->store->name ?? '',
                    'name' => $item->name,
                    'price' => $item->price,
                    'qty' => $item->quantity,
                    'total' => $item->total,
                ];
            })->toArray();
        } else {
            if (empty($this->selectedStore) && count($this->stores) > 0) {
                $this->selectedStore = $this->stores->first()->id;
            }
            // Set default distributor pertama jika form baru dibuka
            if (empty($this->selectedDistributor) && count($this->distributors) > 0) {
                $this->selectedDistributor = $this->distributors->first()->id;
            }
        }
    }

    // Fungsi otomatis berjalan saat kolom input $search diketik oleh user
    public function updatedSearch(): void
    {
        if (strlen($this->search) > 1) {
            // PERBAIKAN: Menggunakan ->toArray() agar data produk dikirim sebagai array mentah yang sangat ringan bagi browser HP
            $this->searchResults = Product::where('name', 'like', '%' . $this->search . '%')
                ->take(5)
                ->get()
                ->toArray();
        } else {
            $this->searchResults = [];
        }

        $this->highlightIndex = -1; 
    }

    // Fungsi saat item rekomendasi diklik 
    public function selectProduct(string $name, int|float $price): void
    {
        $this->search = $name;
        $this->selectedPrice = $price;
        $this->searchResults = []; // Sembunyikan dropdown pencarian
        $this->calculateSubtotal();
    }

    public function incrementHighlight(): void
    {
        if ($this->highlightIndex < count($this->searchResults) - 1) {
            $this->highlightIndex++;
        }
    }

    public function decrementHighlight(): void
    {
        if ($this->highlightIndex > 0) {
            $this->highlightIndex--;
        }
    }

    public function selectHighlightedProduct(): void
    {
        if ($this->highlightIndex > -1 && isset($this->searchResults[$this->highlightIndex])) {
            $product = $this->searchResults[$this->highlightIndex];
            // Karena data sudah dikonversi ke array, panggil menggunakan index array [] bukan objek ->
            $this->selectProduct($product['name'], $product['price']);
        }
    }

    // Perbaikan: Menambahkan parameter fallback agar jika Livewire mengirimkan data kosong tidak crash
    public function updatedQty($value = null): void
    {
        // Pastikan nilai qty minimal adalah 1 dan bertipe integer
        $this->qty = $value ? (int)$value : 1;
        $this->calculateSubtotal();
    }

    public function calculateSubtotal(): void
    {
        // PERBAIKAN: Menggunakan properti internal yang aman dari manipulasi request kosong
        $currentQty = isset($this->qty) ? (int)$this->qty : 1;
        $this->subtotal = $this->selectedPrice * $currentQty;
    }

    // =========================================================================
    // PERBAIKAN UTAMA: LOGIKA ANTI-DUPLIKAT BARANG PADA LIST BELANJA
    // =========================================================================
    public function addItemToList(): void
    {
        if ($this->selectedPrice == 0 || empty($this->search) || empty($this->selectedStore)) {
            return;
        }

        $store = Store::find($this->selectedStore);
        $storeName = $store ? $store->name : '';

        $isDuplicated = false;

        // Looping untuk mencari apakah nama barang yang diinput sudah ada di keranjang bawah
        foreach ($this->shoppingList as $index => $item) {
            if (strcasecmp($item['name'], $this->search) === 0) {
                // Jika ketemu barang kembar, akumulasikan Qty lama + Qty baru
                $newQty = $this->shoppingList[$index]['qty'] + (int)$this->qty;
                $this->shoppingList[$index]['qty'] = $newQty;
                
                // Hitung ulang subtotal harga baris tersebut
                $this->shoppingList[$index]['total'] = $this->shoppingList[$index]['price'] * $newQty;
                
                $isDuplicated = true;
                break;
            }
        }

        // Jika barang belum pernah ada di list bawah, barulah masukkan sebagai baris baru
        if (!$isDuplicated) {
            $this->shoppingList[] = [
                'store' => $storeName,
                'name' => $this->search,
                'price' => $this->selectedPrice,
                'qty' => (int)$this->qty,
                'total' => $this->subtotal
            ];
        }

        // Reset form input atas agar kosong kembali
        $this->search = '';
        $this->selectedPrice = 0;
        $this->qty = (int) 1; 
        $this->subtotal = 0;

        $this->calculateGrandTotal();
    }

    // Fungsi menghapus item dari list keranjang belanja 
    public function removeItem(int $index): void
    {
        unset($this->shoppingList[$index]);
        $this->shoppingList = array_values($this->shoppingList); 
        $this->calculateGrandTotal();
    }

    public function calculateGrandTotal(): void
    {
        $this->grandTotal = collect($this->shoppingList)->sum('total');
    }

    public function finishShopping()
    {
        if (empty($this->shoppingList) || empty($this->selectedStore)) {
            return;
        }

        if ($this->editingPoId) {
            $po = PurchaseOrder::findOrFail($this->editingPoId);
            $po->update([
                'store_id' => $this->selectedStore,
                'distributor_id' => !empty($this->selectedDistributor) ? $this->selectedDistributor : null, // UPDATE ID DISTRIBUTOR
                'total_amount' => $this->grandTotal,
            ]);

            $po->items()->delete();
            foreach ($this->shoppingList as $item) {
                PurchaseOrderItem::create([
                    'purchase_order_id' => $po->id,
                    'name' => $item['name'],
                    'quantity' => $item['qty'],
                    'price' => $item['price'],
                    'total' => $item['total'],
                ]);
            }
        } else {
            $po = PurchaseOrder::create([
                'store_id' => $this->selectedStore,
                'distributor_id' => !empty($this->selectedDistributor) ? $this->selectedDistributor : null, // SIMPAN ID DISTRIBUTOR BARU
                'total_amount' => $this->grandTotal,
            ]);

            foreach ($this->shoppingList as $item) {
                PurchaseOrderItem::create([
                    'purchase_order_id' => $po->id,
                    'name' => $item['name'],
                    'quantity' => $item['qty'],
                    'price' => $item['price'],
                    'total' => $item['total'],
                ]);
            }
        }

        $this->shoppingList = [];
        $this->grandTotal = 0;
        $this->selectedDistributor = '';
        $this->editingPoId = null;

        return redirect()->route('purchase-orders.index');
    }

    public function render()
    {
        return view('livewire.vape-planner');
    }
}