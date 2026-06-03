<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PurchaseOrder;
use Barryvdh\DomPDF\Facade\Pdf;

class PdfController extends Controller
{
    public function download($id)
    {
        $po = PurchaseOrder::with(['store', 'items'])->findOrFail($id);
        
        $pdf = Pdf::loadView('pdf.purchase-order', ['po' => $po]);

        return $pdf->download('purchase-order-'.$po->id.'.pdf');
    }
}
