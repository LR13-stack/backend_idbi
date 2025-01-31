<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'El campo nombre es requerido',
            'name.string' => 'El campo nombre debe ser un texto',
            'name.max' => 'El campo nombre debe tener máximo 255 caracteres',

            'last_name.required' => 'El campo apellido es requerido',
            'last_name.string' => 'El campo apellido debe ser un texto',
            'last_name.max' => 'El campo apellido debe tener máximo 255 caracteres',

            'email.required' => 'El campo email es requerido',
            'email.string' => 'El campo email debe ser un texto',
            'email.email' => 'El campo email debe ser un email válido',
            'email.max' => 'El campo email debe tener máximo 255 caracteres',
            'email.unique' => 'El email ya se encuentra registrado',
            
            'password.required' => 'El campo contraseña es requerido',
            'password.string' => 'El campo contraseña debe ser un texto',
            'password.min' => 'El campo contraseña debe tener mínimo 8 caracteres',
        ];
    }
}
