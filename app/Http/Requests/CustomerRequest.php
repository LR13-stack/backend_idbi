<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'document_id' => 'required|in:DNI,RUC',
            'number_id' => 'required|string|max:255|unique:customers,number_id,' . $this->customer->id,
            'email' => 'required|string|email|max:255|unique:customers,email,' . $this->customer->id,
            'phone' => 'required|string|max:15',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'El campo nombre es requerido',
            'name.string' => 'El campo nombre debe ser un texto',
            'name.max' => 'El campo nombre debe tener máximo 255 caracteres',

            'document_id.required' => 'El campo tipo de documento es requerido',
            'document_id.in' => 'El campo tipo de documento debe ser DNI o RUC',

            'number_id.required' => 'El campo número de documento es requerido',
            'number_id.string' => 'El campo número de documento debe ser un texto',
            'number_id.max' => 'El campo número de documento debe tener máximo 255 caracteres',
            'number_id.unique' => 'El número de documento ya se encuentra registrado',

            'email.required' => 'El campo email es requerido',
            'email.string' => 'El campo email debe ser un texto',
            'email.email' => 'El campo email debe ser un email válido',
            'email.max' => 'El campo email debe tener máximo 255 caracteres',
            'email.unique' => 'El email ya se encuentra registrado',

            'phone.required' => 'El campo teléfono es requerido',
            'phone.string' => 'El campo teléfono debe ser un texto',
            'phone.max' => 'El campo teléfono debe tener máximo 15 caracteres',
        ];
    }
}
