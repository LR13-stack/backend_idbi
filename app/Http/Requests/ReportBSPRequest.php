<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReportBSPRequest extends FormRequest
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
            'start_date' => 'date|required',
            'end_date' => 'date|required|after_or_equal:start_date',
            'product_name' => 'string|nullable|exists:products,name',
            'customer_name' => 'string|nullable|exists:customers,name',
            'seller_name' => 'string|nullable|exists:users,name',
            'format' => 'string|required|in:json,xlsx',
        ];
    }

    public function messages(): array
    {
        return [
            'product_name.string' => 'El campo nombre del producto debe ser una cadena de texto.',
            'product_name.exists' => 'El campo nombre del producto no existe en la base de datos.',

            'customer_name.string' => 'El campo nombre del cliente debe ser una cadena de texto.',
            'customer_name.exists' => 'El campo nombre del cliente no existe en la base de datos.',

            'seller_name.string' => 'El campo nombre del bendedor debe ser una cadena de texto.',
            'seller_name.exists' => 'El campo nombre del bendedor no existe en la base de datos.',

            'format.required' => 'El campo formato es obligatorio.',
            'format.string' => 'El campo formato debe ser una cadena de texto.',
            'format.in' => 'El campo formato debe ser json o xlsx.',
        ];
    }
}
