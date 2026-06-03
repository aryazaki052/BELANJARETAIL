<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\VapePlanner;
use App\Livewire\PurchaseOrderList; // Baris ini sekarang akan terbaca aktif!
use App\Livewire\PurchaseOrderDetail;
use App\Livewire\ProductCrud;
use App\Http\Controllers\PdfController;

// Halaman Utama / Rencana Belanja
Route::get('/', VapePlanner::class)->name('rencana.belanja');
Route::get('/rencana-belanja/{id}/edit', VapePlanner::class)->name('rencana.belanja.edit');

// Purchase Orders (Sudah ringkas karena menggunakan import di atas)
Route::get('/purchase-orders', PurchaseOrderList::class)->name('purchase-orders.index');
Route::get('/purchase-orders/{id}', PurchaseOrderDetail::class)->name('purchase-orders.show');
Route::get('/purchase-orders/{id}/download', [PdfController::class, 'download'])->name('purchase-orders.download');

// Database Barang
Route::get('/database-barang', ProductCrud::class)->name('database.barang');