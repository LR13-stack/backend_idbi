<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReportSalesRequest extends FormRequest
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
            'customer_id' => 'integer|nullable|exists:customers,id',
            'seller_id' => 'integer|nullable|exists:users,id',
            'format' => 'string|required|in:json,xlsx',
        ];
    }

    public function messages(): array
    {
        return [
            'start_date.date' => 'El campo fecha de inicio debe ser una fecha.',
            'start_date.required' => 'El campo fecha de inicio es obligatorio.',

            'end_date.date' => 'El campo fecha de fin debe ser una fecha.',
            'end_date.required' => 'El campo fecha de fin es obligatorio.',
            'end_date.after_or_equal' => 'El campo fecha de fin debe ser una fecha posterior o igual a la fecha de inicio.',

            'customer_id.integer' => 'El campo ID del cliente debe ser un número entero.',
            'customer_id.exists' => 'El campo ID del cliente no existe en la base de datos.',

            'seller_id.integer' => 'El campo ID del vendedor debe ser un número entero.',
            'seller_id.exists' => 'El campo ID del vendedor no existe en la base de datos.',

            'format.required' => 'El campo formato es obligatorio.',
            'format.string' => 'El campo formato debe ser una cadena de texto.',
            'format.in' => 'El campo formato debe ser json o xlsx.',
        ];
    }
}
