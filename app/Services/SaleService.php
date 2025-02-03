<?php

namespace App\Services;

use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Exception;

class SaleService
{
    public function all()
    {
        return Sale::with('details')->get();
    }


    public function createSale(array $data)
    {
        DB::beginTransaction();

        try {
            $totalSale = collect($data['details'])->sum('total');

            $sale = Sale::create([
                'code' => $data['code'],
                'customer_id' => $data['customer_id'],
                'seller_id' => $data['seller_id'],
                'total' => $totalSale,
            ]);

            foreach ($data['details'] as $detail) {
                $product = Product::findOrFail($detail['product_id']);

                if ($product->status !== 'Activo') {
                    throw new Exception("El producto {$product->name} no está activo.");
                }

                if ($product->stock < $detail['quantity']) {
                    throw new Exception("Stock insuficiente para el producto {$product->name}.");
                }

                $product->decrement('stock', $detail['quantity']);

                SaleDetail::create([
                    'sale_id' => $sale->id,
                    'product_id' => $detail['product_id'],
                    'quantity' => $detail['quantity'],
                    'unit_price' => $detail['unit_price'],
                    'total' => $detail['total'],
                ]);
            }

            DB::commit();
            return $sale->load('details');
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception("Error al registrar la venta: " . $e->getMessage());
        }
    }

    public function find($id)
    {
        $sale = Sale::findOrFail($id);
        return $sale->load('details');
    }

    public function update(array $data, Sale $sale)
    {
        DB::beginTransaction();

        try {
            $totalSale = collect($data['details'])->sum('total');

            $sale->update([
                'code' => $data['code'],
                'customer_id' => $data['customer_id'],
                'seller_id' => $data['seller_id'],
                'total' => $totalSale,
            ]);

            $sale->details()->delete();

            foreach ($data['details'] as $detail) {
                $product = Product::findOrFail($detail['product_id']);

                if ($product->status !== 'Activo') {
                    throw new Exception("El producto {$product->name} no está activo.");
                }

                if ($product->stock < $detail['quantity']) {
                    throw new Exception("Stock insuficiente para el producto {$product->name}.");
                }

                $product->decrement('stock', $detail['quantity']);

                SaleDetail::create([
                    'sale_id' => $sale->id,
                    'product_id' => $detail['product_id'],
                    'quantity' => $detail['quantity'],
                    'unit_price' => $detail['unit_price'],
                    'total' => $detail['total'],
                ]);
            }

            DB::commit();
            return $sale->load('details');
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception("Error al actualizar la venta: " . $e->getMessage());
        }
    }

    public function delete(Sale $sale)
    {
        DB::beginTransaction();

        try {
            foreach ($sale->details as $detail) {
                $product = Product::findOrFail($detail->product_id);
                $product->increment('stock', $detail->quantity);
            }

            $sale->details()->delete();
            $sale->delete();

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception("Error al eliminar la venta: " . $e->getMessage());
        }
    }
}
