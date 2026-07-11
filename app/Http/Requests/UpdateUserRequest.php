<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $user = $this->route('user');

        return [
            'rol_id' => ['required', 'exists:roles,id'],
            'ciudad_id' => ['required', 'exists:ciudades,id'],

            'cedula' => [
                'required',
                Rule::unique('users', 'cedula')->ignore($user->id),
            ],

            'nombres' => ['required', 'max:100'],
            'apellidos' => ['required', 'max:100'],

            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($user->id),
            ],

            'telefono' => ['nullable', 'max:20'],
            'direccion' => ['nullable', 'max:255'],

            // Solo valida la contraseña si se escribió una nueva
            'password' => ['nullable', 'confirmed', 'min:8'],
        ];
    }

    public function messages(): array
    {
        return [
            'rol_id.required' => 'Debe seleccionar un rol.',
            'cedula.unique' => 'La cédula ya está registrada.',
            'email.unique' => 'El correo electrónico ya existe.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
        ];
    }
}