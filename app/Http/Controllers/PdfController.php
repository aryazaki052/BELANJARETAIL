<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PurchaseOrder;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;

class PdfController extends Controller
{
    public function download($id)
    {
        // 1. Ambil data PO beserta relasi store dan items
        $po = PurchaseOrder::with(['store', 'items'])->findOrFail($id);
        
        // 2. Tangkap pilihan tipe download dari URL (default-nya 'lengkap' jika tidak diisi)
        $type = request('type', 'lengkap'); 
        
        // 3. Kirim data PO beserta jenis tipenya ke file blade template PDF
        $pdf = Pdf::loadView('pdf.purchase-order', [
            'po'   => $po,
            'type' => $type
        ]);

        // 4. Olah komponen nama file agar bersih dari spasi berlebih
        $namaToko = Str::slug($po->store->name ?? 'Toko'); // Mengubah "vape escape canggu" menjadi "vape-escape-canggu"
        $tanggal  = $po->created_at->format('d-m-Y');
        $status   = $type == 'gudang' ? 'Gudang' : 'Lengkap';

        // Format Akhir: PO - nama-toko - tanggal - status .pdf
        $namaFile = 'PO - ' . $namaToko . ' - ' . $tanggal . ' - ' . $status . '.pdf';

        return $pdf->download($namaFile);
    }
}