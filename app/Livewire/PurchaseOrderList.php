<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\PurchaseOrder;

class PurchaseOrderList extends Component
{
    public $purchaseOrders;

    public function mount()
    {
        $this->purchaseOrders = PurchaseOrder::with('store')->latest()->get();
    }

    public function delete($id)
    {
        $po = PurchaseOrder::find($id);
        if ($po) {
            $po->delete();
        }
        $this->mount(); // Refresh the list
    }

    public function render()
    {
        return view('livewire.purchase-order-list');
    }
}
