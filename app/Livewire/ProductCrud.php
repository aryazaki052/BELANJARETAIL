<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Imports\ProductsImport;
use Maatwebsite\Excel\Facades\Excel;

class ProductCrud extends Component
{
    use WithPagination;
    use WithFileUploads;

    // Properti Pembantu Form
    public int $qty = 1; // Sudah aman di sini untuk mengikat data wire:model="qty"
    public bool $isOpen = false;
    
    // Properti Data Produk
    public ?int $productId = null;
    public string $name = '';
    public int|string $price = '';
    public mixed $excelFile = null; 
    
    // Properti Fitur Live Search & Pagination
    public string $search = '';
    public int $perPage = 10;

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingPerPage(): void
    {
        $this->resetPage();
    }

    public function importExcel(): void
    {
        $this->validate([
            'excelFile' => 'required|mimes:xlsx,xls|max:10240', 
        ]);

        try {
            Excel::import(new ProductsImport, $this->excelFile->getRealPath());
            $this->excelFile = null;

            session()->flash('message', 'Database barang berhasil diimpor dari Excel!');
        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi kesalahan saat mengimpor data: ' . $e->getMessage());
        }
    }
    
    public function render()
    {
        // Menggunakan trim() pada search agar pencarian lebih aman dari spasi kosong rewel
        $products = Product::where('name', 'like', '%' . trim($this->search) . '%')
            ->latest()
            ->paginate($this->perPage);

        return view('livewire.product-crud', [
            'products' => $products,
        ]);
    }

    public function create(): void
    {
        $this->resetInputFields();
        $this->openModal();
    }

    public function openModal(): void
    {
        $this->isOpen = true;
    }

    public function closeModal(): void
    {
        $this->isOpen = false;
    }

    private function resetInputFields(): void
    {
        $this->productId = null;
        $this->name = '';
        $this->price = '';
    }

    public function store(): void
    {
        $this->validate([
            'name' => 'required',
            'price' => 'required|numeric',
        ]);

        Product::updateOrCreate(['id' => $this->productId], [
            'name' => $this->name,
            'price' => $this->price,
        ]);

        session()->flash('message', 
            $this->productId ? 'Product Updated Successfully.' : 'Product Created Successfully.');

        $this->closeModal();
        $this->resetInputFields();
    }

    public function edit(int|string $id): void
    {
        $product = Product::findOrFail($id);
        $this->productId = (int)$id;
        $this->name = $product->name;
        $this->price = $product->price;
    
        $this->openModal();
    }

    public function delete(int|string $id): void
    {
        Product::findOrFail($id)->delete();
        session()->flash('message', 'Product Deleted Successfully.');
    }
}