<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaleRequest;
use App\Http\Resources\SaleResource;
use App\Models\Sale;
use App\Models\SaleDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    public function index()
    {
        return SaleResource::collection(Sale::with('details')->get());
    }

    public function store(SaleRequest $request)
    {
        DB::beginTransaction();

        try {
            $totalSale = collect($request->details)->sum('total');

            $sale = Sale::create([
                'code' => $request->code,
                'customer_id' => $request->customer_id,
                'seller_id' => $request->seller_id,
                'total' => $totalSale,
            ]);

            $detailsData = array_map(function ($detail) use ($sale) {
                return [
                    'sale_id' => $sale->id,
                    'product_id' => $detail['product_id'],
                    'quantity' => $detail['quantity'],
                    'unit_price' => $detail['unit_price'],
                    'total' => $detail['total'],
                ];
            }, $request->details);

            SaleDetail::insert($detailsData);

            DB::commit();

            return response()->json([
                'sale' => new SaleResource($sale->load('details')),
                'message' => 'Venta registrada exitosamente.'
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Ocurrió un error al registrar la venta.'], 500);
        }
    }

    public function show(Sale $sale)
    {
        return new SaleResource($sale->load('details'));
    }

    public function update(SaleRequest $request, Sale $sale)
    {
        DB::beginTransaction();

        try {
            $totalSale = collect($request->details)->sum('total');

            $sale->update([
                'code' => $request->code,
                'customer_id' => $request->customer_id,
                'seller_id' => $request->seller_id,
                'total' => $totalSale,
            ]);

            $sale->details()->delete();

            $detailsData = array_map(function ($detail) use ($sale) {
                return [
                    'sale_id' => $sale->id,
                    'product_id' => $detail['product_id'],
                    'quantity' => $detail['quantity'],
                    'unit_price' => $detail['unit_price'],
                    'total' => $detail['total'],
                ];
            }, $request->details);

            SaleDetail::insert($detailsData);

            DB::commit();

            return response()->json([
                'sale' => new SaleResource($sale->load('details')),
                'message' => 'Datos de la venta actualizados exitosamente.'
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Ocurrió un error al actualizar los datos de la venta.'], 500);
        }
    }

    public function destroy(Sale $sale)
    {
        DB::beginTransaction();

        try {
            $sale->details()->delete();
            $sale->delete();

            DB::commit();

            return response()->json(['message' => 'Venta eliminada exitosamente.'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Ocurrió un error al eliminar la venta.'], 500);
        }
    }
}
