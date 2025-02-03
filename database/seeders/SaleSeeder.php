<?php

namespace Database\Seeders;

use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Exception;

class SaleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customers = [1, 2, 3];
        $sellerId = 2;
        $products = Product::where('status', 'Activo')->get();
        $startDate = Carbon::create(2024, 12, 1, 0, 0, 0);
        $endDate = Carbon::create(2025, 2, 2, 23, 59, 59);

        for ($i = 0; $i < 50; $i++) {
            DB::beginTransaction();
            try {
                $saleDate = Carbon::createFromTimestamp(rand($startDate->timestamp, $endDate->timestamp));

                $customerId = $customers[array_rand($customers)];

                $details = [];
                $totalSale = 0;
                $selectedProducts = $products->random(rand(1, 3));

                foreach ($selectedProducts as $product) {
                    $quantity = rand(1, 5);
                    if ($product->stock < $quantity) {
                        continue;
                    }

                    $unitPrice = $product->unit_price;
                    $subtotal = $quantity * $unitPrice;

                    $details[] = [
                        'product_id' => $product->id,
                        'quantity' => $quantity,
                        'unit_price' => $unitPrice,
                        'total' => $subtotal,
                    ];

                    $totalSale += $subtotal;
                }

                if (empty($details)) {
                    DB::rollBack();
                    continue;
                }

                $sale = Sale::create([
                    'code' => 'V' . str_pad($i + 1, 3, '0', STR_PAD_LEFT),
                    'customer_id' => $customerId,
                    'seller_id' => $sellerId,
                    'total' => $totalSale,
                    'created_at' => $saleDate,
                    'updated_at' => $saleDate,
                ]);

                foreach ($details as $detail) {
                    SaleDetail::create([
                        'sale_id' => $sale->id,
                        'product_id' => $detail['product_id'],
                        'quantity' => $detail['quantity'],
                        'unit_price' => $detail['unit_price'],
                        'total' => $detail['total'],
                        'created_at' => $saleDate,
                        'updated_at' => $saleDate,
                    ]);

                    Product::where('id', $detail['product_id'])->decrement('stock', $detail['quantity']);
                }

                DB::commit();
            } catch (Exception $e) {
                DB::rollBack();
                Log::error('Error creando venta: ' . $e->getMessage());
            }
        }
    }
}
