<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'ciudad_id' => ['required', 'exists:ciudades,id'],
            'cedula' => ['required', 'unique:users,cedula'],
            'nombres' => ['required', 'max:100'],
            'apellidos' => ['required', 'max:100'],
            'email' => ['required', 'email', 'unique:users,email'],
            'telefono' => ['nullable', 'max:20'],
            'direccion' => ['nullable', 'max:255'],
            'password' => ['required', 'confirmed', 'min:8'],
        ];
    }

    public function messages(): array
    {
        return [
            'cedula.unique' => 'La cédula ya está registrada.',
            'email.unique' => 'El correo electrónico ya existe.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
        ];
    }
}
