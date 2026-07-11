@extends('layouts.app')

@section('content')

<div class="container">    
    <div class="d-flex justify-content-between align-items-center mb-3">

    <h2>Usuarios</h2>

    <a href="{{ route('users.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i>
        Nuevo Usuario
    </a>

    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Rol</th>
                <th>Activo</th>
                <th>Acciones</th>
            </tr>
        </thead>

        <tbody>

        @foreach($usuarios as $usuario)

            <tr>
                <td>{{ $usuario->id }}</td>
                <td>{{ $usuario->nombres }} {{ $usuario->apellidos }}</td>
                <td>{{ $usuario->email }}</td>
                <td>{{ $usuario->rol->nombre }}</td>
                <td>
                @if($usuario->activo)

                    <span class="badge bg-success">
                        Activo
                    </span>

                @else

                    <span class="badge bg-danger">
                        Inactivo
                    </span>

                @endif

                </td>
                <td>

                    <a href="{{ route('users.edit', $usuario) }}"
                        class="btn btn-warning btn-sm">

                        <i class="bi bi-pencil"></i>

                    </a>

                    <form action="{{ route('users.destroy', $usuario) }}"
                        method="POST"
                        class="d-inline">

                        @csrf
                        @method('DELETE')

                        <button
                            class="btn btn-danger btn-sm"
                            onclick="return confirm('¿Desea desactivar este usuario?')">

                            <i class="bi bi-person-x"></i>

                        </button>

                    </form>

                </td>
            </tr>

        @endforeach

        </tbody>
    </table>

</div>

@endsection