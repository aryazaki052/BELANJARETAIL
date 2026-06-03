<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            ['name' => 'Oxva Xlim Cartridge 0.4 ohm', 'price' => 35000],
            ['name' => 'Oxva Xlim Cartridge 0.6 ohm', 'price' => 35000],
            ['name' => 'Oxva Xlim Pro Kit Black Gold', 'price' => 280000],
            ['name' => 'Liquid Juta Juice Anggur 60ml', 'price' => 70000],
            ['name' => 'Liquid Oat Drips V1 60ml', 'price' => 110000],
            ['name' => 'Raza Cotton Premium', 'price' => 40000],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}