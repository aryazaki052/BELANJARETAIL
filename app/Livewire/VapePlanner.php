<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
use App\Models\Store;
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

    // Properti untuk mode edit
    public ?int $editingPoId = null; 

    // Properti untuk highlight navigasi keyboard
    public int $highlightIndex = -1;

    // Properti untuk menampung daftar belanjaan yang ditambahkan ke keranjang/list
    public array $shoppingList = [];
    public int|float $grandTotal = 0;

    public function mount($id = null): void
    {
        // Mengonversi data Store ke Array agar aman saat perpindahan jaringan lokal PC-HP
        $this->stores = Store::all();
        
        if ($id) {
            $this->editingPoId = (int)$id;
            $po = PurchaseOrder::with('items')->findOrFail($id);
            /** @var PurchaseOrder $po */
            $this->selectedStore = $po->store_id;
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

    public function updatedQty(): void
    {
        $this->calculateSubtotal();
    }

    public function calculateSubtotal(): void
    {
        $this->subtotal = $this->selectedPrice * (int)$this->qty;
    }

    // Fungsi untuk memasukkan barang yang dipilih ke list keranjang belanja bawah
    public function addItemToList(): void
    {
        if ($this->selectedPrice == 0 || empty($this->search) || empty($this->selectedStore)) {
            return;
        }

        $store = Store::find($this->selectedStore);
        $storeName = $store ? $store->name : '';

        $this->shoppingList[] = [
            'store' => $storeName,
            'name' => $this->search,
            'price' => $this->selectedPrice,
            'qty' => $this->qty,
            'total' => $this->subtotal
        ];

       $this->search = '';
        $this->selectedPrice = 0;
        $this->qty = (int) 1; // Ditambahkan casting murni (int) agar tipenya stabil di Livewire v3
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
        $this->editingPoId = null;

        return redirect()->route('purchase-orders.index');
    }

    public function render()
    {
        return view('livewire.vape-planner');
    }
}