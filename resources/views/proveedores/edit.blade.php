@extends('adminlte::page')

@section('title', 'Editar Proveedor')

@section('content_header')
    <h1>Editar Proveedor</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline card-success">
                <div class="card-header">
                    <h3 class="card-title">Actualizar Datos del Proveedor</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('proveedores.update', $proveedor->id) }}" method="POST">
                        @csrf
                        @method('PUT') <!-- Para actualizar usamos PUT -->

                        <div class="row">
                            <!-- Nombre -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="nombre">Nombre del Proveedor</label>
                                    <input type="text" name="nombre" id="nombre" class="form-control @error('nombre') is-invalid @enderror"
                                           value="{{ old('nombre', $proveedor->nombre) }}"
                                           placeholder="Ingrese el nombre del proveedor" required>
                                    @error('nombre')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Contacto -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="contacto">Contacto</label>
                                    <input type="text" name="contacto" id="contacto" class="form-control @error('contacto') is-invalid @enderror"
                                           value="{{ old('contacto', $proveedor->contacto) }}"
                                           placeholder="Ingrese el contacto del proveedor">
                                    @error('contacto')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Teléfono -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="telefono">Teléfono</label>
                                    <input type="text" name="telefono" id="telefono" class="form-control @error('telefono') is-invalid @enderror"
                                           value="{{ old('telefono', $proveedor->telefono) }}"
                                           placeholder="Ingrese el teléfono del proveedor">
                                    @error('telefono')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Email -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror"
                                           value="{{ old('email', $proveedor->email) }}"
                                           placeholder="Ingrese el correo electrónico">
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Dirección -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="direccion">Dirección</label>
                                    <textarea name="direccion" id="direccion" rows="3" class="form-control @error('direccion') is-invalid @enderror"
                                              placeholder="Ingrese la dirección del proveedor">{{ old('direccion', $proveedor->direccion) }}</textarea>
                                    @error('direccion')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <hr>
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa-solid fa-check"></i> Guardar Cambios
                                </button>
                                <a href="{{ route('proveedores.index') }}" class="btn btn-secondary">
                                    <i class="fa-solid fa-ban"></i> Cancelar
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <style>
        .form-group label {
            font-weight: bold;
        }
    </style>
@stop

@section('js')
    <script>
        @if (session('success'))
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 1500
            });
        @endif

        @if ($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'Error en el formulario',
                html: `
                    <ul style="text-align: left;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                `,
                confirmButtonText: 'Aceptar'
            });
        @endif
    </script>
@stop
