<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
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
            'sku' => [
                'required',
                'string',
                'max:255',
                Rule::unique('products', 'sku')->ignore(optional($this->product)->id),
            ],
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'unit_price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'status' => ['required', Rule::in(['Activo', 'Inactivo'])],
        ];
    }


    public function messages(): array
    {
        return [
            'sku.required' => 'El campo SKU es requerido.',
            'sku.string' => 'El campo SKU debe ser una cadena de texto.',
            'sku.max' => 'El campo SKU debe tener un máximo de 255 caracteres.',
            'sku.unique' => 'El campo SKU ya ha sido registrado.',

            'name.required' => 'El campo Nombre es requerido.',
            'name.string' => 'El campo Nombre debe ser una cadena de texto.',
            'name.max' => 'El campo Nombre debe tener un máximo de 255 caracteres.',

            'description.required' => 'El campo Descripción es requerido.',
            'description.string' => 'El campo Descripción debe ser una cadena de texto.',

            'unit_price.required' => 'El campo Precio Unitario es requerido.',
            'unit_price.numeric' => 'El campo Precio Unitario debe ser un número.',
            'unit_price.min' => 'El campo Precio Unitario debe ser mayor o igual a 0.',

            'stock.required' => 'El campo Stock es requerido.',
            'stock.integer' => 'El campo Stock debe ser un número entero.',
            'stock.min' => 'El campo Stock debe ser mayor o igual a 0.',

            'status.required' => 'El campo Estado es requerido.',
            'status.in' => 'El campo Estado debe ser Activo o Inactivo.',
        ];
    }
}
