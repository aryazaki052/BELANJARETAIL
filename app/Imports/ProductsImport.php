<?php

namespace App\Imports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductsImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // Melewati baris jika nama produk kosong
        if (empty($row['nama_produk'])) {
            return null;
        }

        return new Product([
            'name'  => $row['nama_produk'], // Menyesuaikan dengan heading Excel Anda
            'price' => (int) $row['harga'], // Memastikan format harga menjadi angka/integer
        ]);
    }
}

