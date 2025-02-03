<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerRequest;
use App\Http\Resources\CustomerResource;
use App\Models\Customer;
use App\Services\CustomerService;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    protected $customerService;

    public function __construct(CustomerService $customerService)
    {
        $this->customerService = $customerService;
    }

    public function index()
    {
        return CustomerResource::collection($this->customerService->all());
    }

    public function store(CustomerRequest $request)
    {
        try {
            $customer = $this->customerService->create($request->all());

            return response()->json([
                'data' => new CustomerResource($customer),
                'message' => 'Cliente registrado exitosamente.'
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al registrar el cliente.' . $e->getMessage()
            ], 500);
        }
    }

    public function show(Customer $customer)
    {
        return new CustomerResource($this->customerService->find($customer->id));
    }

    public function update(CustomerRequest $request, Customer $customer)
    {
        try {
            $customer = $this->customerService->update($request->all(), $customer);

            return response()->json([
                'data' => new CustomerResource($customer),
                'message' => 'Datos del cliente actualizados exitosamente.'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al actualizar los datos del cliente.'
            ], 500);
        }
    }

    public function destroy(Customer $customer)
    {
        try {
            $this->customerService->delete($customer);

            return response()->json([
                'message' => 'Cliente eliminado exitosamente.'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al eliminar el cliente.'
            ], 500);
        }
    }
}
