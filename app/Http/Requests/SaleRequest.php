<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'code' => 'required|string|max:255',
            'customer_id' => 'required|integer|exists:customers,id',
            'seller_id' => 'required|integer|exists:users,id',
            // 'total' => 'required|numeric|min:0',

            'details' => 'required|array|min:1',
            'details.*.product_id' => 'required|exists:products,id',
            'details.*.quantity' => 'required|integer|min:1',
            'details.*.unit_price' => 'required|numeric|min:0',
            'details.*.total' => 'required|numeric|min:0',
        ];
    }

    public function messages(): array
    {
        return [
            'code.required' => 'El código es requerido',
            'code.string' => 'El código debe ser una cadena de texto',
            'code.max' => 'El código no debe ser mayor a 255 caracteres',

            'customer_id.required' => 'El cliente es requerido',
            'customer_id.integer' => 'El cliente debe ser un número entero',
            'customer_id.exists' => 'El cliente seleccionado no existe',

            'seller_id.required' => 'El vendedor es requerido',
            'seller_id.integer' => 'El vendedor debe ser un número entero',
            'seller_id.exists' => 'El vendedor seleccionado no existe',

            // 'total.required' => 'El total es requerido',
            // 'total.numeric' => 'El total debe ser un número',
            // 'total.min' => 'El total no debe ser menor a 0',

            'details.required' => 'Debe incluir al menos un detalle de venta.',
            'details.array' => 'Los detalles deben ser un array válido.',

            'details.*.product_id.required' => 'El producto es obligatorio.',
            'details.*.product_id.exists' => 'El producto seleccionado no existe.',

            'details.*.quantity.required' => 'La cantidad es obligatoria.',
            'details.*.quantity.integer' => 'La cantidad debe ser un número entero.',
            'details.*.quantity.min' => 'La cantidad mínima es 1.',

            'details.*.unit_price.required' => 'El precio unitario es obligatorio.',
            'details.*.unit_price.numeric' => 'El precio unitario debe ser un número.',
            'details.*.unit_price.min' => 'El precio unitario debe ser al menos 0.',

            'details.*.total.required' => 'El total es obligatorio.',
            'details.*.total.numeric' => 'El total debe ser un número.',
            'details.*.total.min' => 'El total debe ser al menos 0.',
        ];
    }
}
