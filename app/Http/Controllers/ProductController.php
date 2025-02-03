<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index()
    {
        return ProductResource::collection($this->productService->all());
    }

    public function store(ProductRequest $request)
    {
        try {
            $product = $this->productService->create($request->all());

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
        return new ProductResource($this->productService->find($product->id));
    }

    public function update(ProductRequest $request, Product $product)
    {
        try {
            $product = $this->productService->update($request->all(), $product);

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
            $this->productService->delete($product);

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
