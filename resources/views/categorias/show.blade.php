@extends('adminlte::page')

@section('title', 'Detalles de la Categoría')

@section('content_header')
    <h1>Detalles de la Categoría</h1>
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
                        <!-- Nombre de la Categoría -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nombre">Nombre de la Categoría</label>
                                <p class="form-control-static">{{ $categoria->nombre }}</p>
                            </div>
                        </div>

                        <!-- Descripción de la Categoría -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="descripcion">Descripción</label>
                                <p class="form-control-static">{{ $categoria->descripcion ?? 'No especificada' }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Fecha de Creación -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="fecha_creacion">Fecha de Creación</label>
                                <p class="form-control-static">
                                    {{ $categoria->created_at ? $categoria->created_at->format('d-m-Y') : 'No disponible' }}
                                </p>
                            </div>
                        </div>

                        <!-- Última Modificación -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="ultima_modificacion">Última Modificación</label>
                                <p class="form-control-static">
                                    {{ $categoria->updated_at ? $categoria->updated_at->format('d-m-Y') : 'No disponible' }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <hr>
                    <div class="row">
                        <!-- Botón de regreso -->
                        <div class="col-md-12 text-center">
                            <div class="form-group">
                                <a href="{{ route('categorias.index') }}" class="btn btn-secondary">
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
    <script> console.log("Vista de detalles de la categoría cargada correctamente."); </script>
@stop
