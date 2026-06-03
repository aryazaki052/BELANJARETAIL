<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\PurchaseOrder;

class PurchaseOrderDetail extends Component
{
    public PurchaseOrder $po;

    public function mount($id)
    {
        $this->po = PurchaseOrder::with(['store', 'items'])->findOrFail($id);
    }

    public function render()
    {
        return view('livewire.purchase-order-detail');
    }
}
