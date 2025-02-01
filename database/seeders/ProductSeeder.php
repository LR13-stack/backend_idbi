<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'sku' => 'P001',
                'name' => 'Laptop Gamer',
                'description' => 'Laptop Gamer 15.6" Intel Core i7 16GB RAM 1TB SSD',
                'unit_price' => 3000.00,
                'stock' => 10,
                'status' => 'Activo',
            ],
            [
                'sku' => 'P002',
                'name' => 'Tablet',
                'description' => 'Tablet 10.1" Android 10 4GB RAM 64GB ROM',
                'unit_price' => 990.00,
                'stock' => 20,
                'status' => 'Activo',
            ],
            [
                'sku' => 'P003',
                'name' => 'Audífonos',
                'description' => 'Audífonos Bluetooth con cancelación de ruido',
                'unit_price' => 300.00,
                'stock' => 30,
                'status' => 'Activo',
            ],
            [
                'sku' => 'P004',
                'name' => 'Reloj inteligente',
                'description' => 'Reloj inteligente con monitor de ritmo cardíaco',
                'unit_price' => 250.00,
                'stock' => 20,
                'status' => 'Activo',
            ],
            [
                'sku' => 'P005',
                'name' => 'Celular',
                'description' => 'Celular 6.5" Android 11 8GB RAM 128GB ROM',
                'unit_price' => 500.00,
                'stock' => 50,
                'status' => 'Activo',
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
