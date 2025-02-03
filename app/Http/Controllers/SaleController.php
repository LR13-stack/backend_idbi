<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaleRequest;
use App\Http\Resources\SaleResource;
use App\Models\Sale;
use App\Models\SaleDetail;
use App\Services\SaleService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    protected $saleService;

    public function __construct(SaleService $saleService)
    {
        $this->saleService = $saleService;
    }

    public function index()
    {
        return SaleResource::collection($this->saleService->all());
    }

    public function store(SaleRequest $request)
    {
        try {
            $sale = $this->saleService->createSale($request->validated());

            return response()->json([
                'sale' => new SaleResource($sale),
                'message' => 'Venta registrada exitosamente.'
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function show(Sale $sale)
    {
        return new SaleResource($this->saleService->find($sale->id));
    }

    public function update(SaleRequest $request, Sale $sale)
    {
        try {
            $sale = $this->saleService->update($request->validated(), $sale);

            return response()->json([
                'sale' => new SaleResource($sale),
                'message' => 'Venta actualizada exitosamente.'
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error al actualizar la venta.'], 500);
        }
    }

    public function destroy(Sale $sale)
    {
        try {
            $this->saleService->delete($sale);

            return response()->json(['message' => 'Venta eliminada exitosamente.'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error al eliminar la venta.'], 500);
        }
    }
}
