<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // TODO: ganti 'image' dengan foto asli tiap menu milik warung.
        // Saat ini pakai foto kategori lokal + placeholder agar tidak menyesatkan.
        // File tersedia di public/assets/menu/: mie.jpg, nasi.jpg, minuman.jpg, kopi.jpg, placeholder.svg
        $products = [
            ['name' => 'Mie Dok-Dok Kuah Smoky', 'harga' => 18000, 'category' => 'mie', 'description' => 'Kuah kental gurih beraroma smoky khas wajan panas.', 'image' => 'assets/menu/mie.jpg', 'stock' => 20, 'is_available' => true, 'rating' => 5.0, 'spice_level' => 2, 'is_best_seller' => true],
            ['name' => 'Mie Dok-Dok Goreng Nyemek', 'harga' => 18000, 'category' => 'mie', 'description' => 'Nyemek gurih dengan telur dan sayuran segar.', 'image' => 'assets/menu/mie.jpg', 'stock' => 20, 'is_available' => true, 'rating' => 4.9, 'spice_level' => 1, 'is_best_seller' => false],
            ['name' => 'Indomie Double Smoky Cheese', 'harga' => 22000, 'category' => 'indomie', 'description' => 'Porsi double dengan lelehan keju dan kornet.', 'image' => 'assets/menu/mie.jpg', 'stock' => 15, 'is_available' => true, 'rating' => 4.8, 'spice_level' => 2, 'is_best_seller' => true],
            ['name' => 'Rice Bowl Smoky Chicken', 'harga' => 25000, 'category' => 'rice', 'description' => 'Nasi hangat + ayam fillet saus BBQ smoky.', 'image' => 'assets/menu/nasi.jpg', 'stock' => 15, 'is_available' => true, 'rating' => 4.9, 'spice_level' => 1, 'is_best_seller' => false],
            ['name' => 'Rice Bowl Kulit Ayam Smoky', 'harga' => 20000, 'category' => 'rice', 'description' => 'Kulit ayam crispy berbumbu smoky di atas nasi.', 'image' => 'assets/menu/nasi.jpg', 'stock' => 0, 'is_available' => true, 'rating' => 4.7, 'spice_level' => 2, 'is_best_seller' => false],
            // TODO: foto asli dimsum & french fries belum ada — pakai placeholder.
            ['name' => 'Dimsum Smoky', 'harga' => 15000, 'category' => 'snack', 'description' => 'Dimsum ayam hangat dengan chili oil smoky.', 'image' => null, 'stock' => 20, 'is_available' => true, 'rating' => 4.8, 'spice_level' => 1, 'is_best_seller' => false],
            ['name' => 'French Fries Smoky Chili Cheese', 'harga' => 15000, 'category' => 'snack', 'description' => 'Kentang renyah tabur bumbu chili cheese.', 'image' => null, 'stock' => 20, 'is_available' => true, 'rating' => 4.7, 'spice_level' => 2, 'is_best_seller' => false],
            ['name' => 'Es Nutrisari Cold Breeze', 'harga' => 8000, 'category' => 'drink', 'description' => 'Nutrisari dingin segar pelepas dahaga.', 'image' => 'assets/menu/minuman.jpg', 'stock' => 30, 'is_available' => true, 'rating' => 4.9, 'spice_level' => 0, 'is_best_seller' => false],
            ['name' => 'Es Red Velvet Creamy', 'harga' => 12000, 'category' => 'drink', 'description' => 'Red velvet creamy dingin kekinian.', 'image' => 'assets/menu/minuman.jpg', 'stock' => 25, 'is_available' => true, 'rating' => 4.8, 'spice_level' => 0, 'is_best_seller' => false],
        ];

        foreach ($products as $product) {
            Product::updateOrCreate(['name' => $product['name']], $product);
        }
    }
}
