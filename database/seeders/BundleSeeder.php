<?php

namespace Database\Seeders;

use App\Models\Bundle;
use Illuminate\Database\Seeder;

class BundleSeeder extends Seeder
{
    public function run(): void
    {
        $bundles = [
            [
                'name' => 'Paket Nongkrong Sendiri',
                'description' => 'Indomie Smoky Spesial + Telur Kornet + Es Teh Manis Jumbo',
                'price' => 22000,
                'original_price' => 26000,
                'badge' => 'Paket Solo',
                'is_active' => true,
                'is_popular' => false,
            ],
            [
                'name' => 'Paket Buat Mabar / Date',
                'description' => '2x Indomie Double Smoky + French Fries + 2x Es Nutrisari',
                'price' => 42000,
                'original_price' => 51000,
                'badge' => 'Paket Berdua',
                'is_active' => true,
                'is_popular' => true,
            ],
            [
                'name' => 'Paket Skuad Ambis',
                'description' => '4x Indomie Smoky + Dimsum Mix (6pcs) + 1 Pitcher Es Teh',
                'price' => 75000,
                'original_price' => 92000,
                'badge' => 'Paket Rombongan',
                'is_active' => true,
                'is_popular' => false,
            ],
        ];

        foreach ($bundles as $bundle) {
            Bundle::updateOrCreate(['name' => $bundle['name']], $bundle);
        }
    }
}
