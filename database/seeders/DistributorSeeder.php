<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Distributor;

class DistributorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $distributors = [
            ['name' => 'Power Distribution'],
            ['name' => 'Radja Vape Distribution'],
            ['name' => 'Jesmar Vape'],
            ['name' => 'Vape Brand Distribution'],
        ];

        foreach ($distributors as $distri) {
            Distributor::updateOrCreate(['name' => $distri['name']], $distri);
        }
    }
}