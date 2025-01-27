@extends('adminlte::page')

@section('title', 'Detalles del Proveedor')

@section('content_header')
    <h1>Detalles del Proveedor</h1>
@stop

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card card-outline card-info">
                <div class="card-header">
                    <h3 class="card-title">Datos Registrados</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Nombre -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nombre">Nombre</label>
                                <p class="form-control-static">{{ $proveedor->nombre }}</p>
                            </div>
                        </div>

                        <!-- Contacto -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="contacto">Contacto</label>
                                <p class="form-control-static">{{ $proveedor->contacto ?? 'No especificado' }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Teléfono -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="telefono">Teléfono</label>
                                <p class="form-control-static">{{ $proveedor->telefono ?? 'No especificado' }}</p>
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email">Correo Electrónico</label>
                                <p class="form-control-static">{{ $proveedor->email ?? 'No especificado' }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Dirección -->
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="direccion">Dirección</label>
                                <p class="form-control-static">{{ $proveedor->direccion ?? 'No especificada' }}</p>
                            </div>
                        </div>
                    </div>

                    <hr>
                    <div class="row">
                        <!-- Botón de regreso -->
                        <div class="col-md-12 text-center">
                            <div class="form-group">
                                <a href="{{ route('proveedores.index') }}" class="btn btn-secondary">
                                    <i class="fa-solid fa-arrow-left"></i> Volver
                                </a>
                            </div>
                        </div>
                    </div>
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
        .form-control-static {
            display: block;
            font-size: 1rem;
            margin-top: 0.5rem;
        }
    </style>
@stop

@section('js')
    <script> console.log("Vista de detalles del proveedor cargada correctamente."); </script>
@stop
