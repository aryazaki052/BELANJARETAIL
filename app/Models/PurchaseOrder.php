<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    use HasFactory;

    // PERBAIKAN: Menambahkan 'distributor_id' agar diizinkan masuk ke database oleh Laravel
    protected $fillable = ['store_id', 'distributor_id', 'total_amount'];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function items()
    {
        return $this->hasMany(PurchaseOrderItem::class);
    }

    public function distributor()
    {
        return $this->belongsTo(Distributor::class);
    }
}