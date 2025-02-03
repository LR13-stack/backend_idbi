<?php

namespace App\Services;

use App\Models\Product;

class ProductService
{
    public function all()
    {
        return Product::where('status', 'Activo')->get();
    }

    public function create($data)
    {
        return Product::create($data);
    }

    public function find($id)
    {
        return Product::findOrFail($id);
    }

    public function update($data, $product)
    {
        $product->name = $data['name'];
        $product->description = $data['description'];
        $product->unit_price = $data['unit_price'];
        $product->stock = $data['stock'];
        $product->status = $data['status'];
        $product->save();

        return $product;
    }

    public function delete($product)
    {
        $product->update(['status' => 'Inactivo']);
    }
}
