<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'rol_id' => ['required', 'exists:roles,id'],

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

            'rol_id.required' => 'Debe seleccionar un rol.',

            'rol_id.exists' => 'El rol seleccionado no existe.',

            'cedula.unique' => 'La cédula ya está registrada.',

            'email.unique' => 'El correo electrónico ya existe.',

            'password.confirmed' => 'Las contraseñas no coinciden.',

        ];
    }
}