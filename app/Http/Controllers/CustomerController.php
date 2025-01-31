<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerRequest;
use App\Http\Resources\CustomerResource;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        return CustomerResource::collection(Customer::all());
    }

    public function store(CustomerRequest $request)
    {
        try {
            $customer = Customer::create($request->all());

            return response()->json([
                'data' => new CustomerResource($customer),
                'message' => 'Cliente registrado exitosamente.'
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al registrar el cliente.'
            ], 500);
        }
    }

    public function show(Customer $customer)
    {
        return new CustomerResource($customer);
    }

    public function update(CustomerRequest $request, Customer $customer)
    {
        try {
            $customer->name = $request->name;
            $customer->document_id = $request->document_id;
            $customer->number_id = $request->number_id;
            $customer->email = $request->email;
            $customer->phone = $request->phone;
            $customer->save();

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
            $customer->delete();

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
