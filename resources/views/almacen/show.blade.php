@extends('adminlte::page')

@section('title', 'Detalles del Artículo en Almacén')

@section('content_header')
    <h1>Detalles del Artículo en Almacén</h1>
@stop

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card card-outline card-info">
                <div class="card-header">
                    <h3 class="card-title">Información del Artículo</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        {{-- Tipo de Artículo --}}
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="tipo">Tipo de Artículo</label>
                                <p class="form-control-static">{{ ucfirst($almacen->tipo) }}</p>
                            </div>
                        </div>
                        {{-- Fecha de Compra --}}
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="fecha_compra">Fecha de Compra</label>
                                <p class="form-control-static">{{ $almacen->fecha_compra ?? 'No registrada' }}</p>
                            </div>
                        </div>
                        {{-- Proveedor --}}
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="proveedor">Proveedor</label>
                                <p class="form-control-static">{{ $almacen->nombre_proveedor ?? 'No especificado' }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        {{-- Fecha de Entrada --}}
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="fecha_entrada">Fecha de Entrada</label>
                                <p class="form-control-static">{{ $almacen->fecha_entrada ?? 'No registrada' }}</p>
                            </div>
                        </div>
                        {{-- Recibido Por --}}
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="recibido_por">Recibido Por</label>
                                <p class="form-control-static">{{ $almacen->recibido_por ?? 'No especificado' }}</p>
                            </div>
                        </div>
                        {{-- Fecha de Salida --}}
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="fecha_salida">Fecha de Salida</label>
                                <p class="form-control-static">{{ $almacen->fecha_salida ?? 'No registrada' }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        {{-- Stock --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="stock">Stock Disponible</label>
                                <p class="form-control-static">{{ $almacen->stock }}</p>
                            </div>
                        </div>
                        {{-- Departamento --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="departamento">Departamento</label>
                                <p class="form-control-static">{{ $almacen->departamento }}</p>
                            </div>
                        </div>
                    </div>

                    <hr>
                    <div class="row">
                        {{-- Botón de regreso --}}
                        <div class="col-md-12 text-center">
                            <div class="form-group">
                                <a href="{{ route('almacen.index') }}" class="btn btn-secondary">
                                    <i class="fa-solid fa-arrow-left"></i> Volver
                                </a>
                                <a href="{{ route('almacen.edit', $almacen->id) }}" class="btn btn-success">
                                    <i class="fa-solid fa-pencil"></i> Editar
                                </a>
                                <form action="{{ route('almacen.destroy', $almacen->id) }}" method="POST" style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-danger delete-btn">
                                        <i class="fa-regular fa-trash-can"></i> Eliminar
                                    </button>
                                </form>
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
    <script>
        $(document).on('click', '.delete-btn', function (e) {
            e.preventDefault();

            let form = $(this).closest('form');

            Swal.fire({
                title: '¿Estás seguro de eliminar este artículo?',
                text: "¡No podrás revertir esta acción!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });

        @if (session('success'))
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 1500
            });
        @endif
    </script>
@stop
