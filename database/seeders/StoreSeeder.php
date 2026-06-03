<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Store;

class StoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $stores = [
            ['name' => 'vape escape canggu'],
            ['name' => '69 gunung salak'],
            ['name' => '69 penatih'],
            ['name' => '69 Panjer'],
            ['name' => 'vaporsnesia monang maning'],
            ['name' => 'vaporsnesia darmasaba'],
        ];

        foreach ($stores as $store) {
            Store::create($store);
        }
    }
}
