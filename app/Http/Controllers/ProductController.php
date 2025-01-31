<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        return ProductResource::collection(Product::all());
    }

    public function store(ProductRequest $request)
    {
        try {
            $product = Product::create($request->all());

            return response()->json([
                'data' => new ProductResource($product),
                'message' => 'Producto creado exitosamente.'
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al crear el producto.'
            ], 500);
        }
    }

    public function show(Product $product)
    {
        return new ProductResource($product);
    }

    public function update(ProductRequest $request, Product $product)
    {
        try {
            $product->sku = $request->sku;
            $product->name = $request->name;
            $product->description = $request->description;
            $product->unit_price = $request->unit_price;
            $product->stock = $request->stock;
            $product->status = $request->status;
            $product->save();

            return response()->json([
                'data' => new ProductResource($product),
                'message' => 'Datos del producto actualizados exitosamente.'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al actualizar los datos del producto.'
            ], 500);
        }
    }

    public function destroy(Product $product)
    {
        try {
            $product->delete();

            return response()->json([
                'message' => 'Producto eliminado exitosamente.'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al eliminar el producto.'
            ], 500);
        }
    }
}
