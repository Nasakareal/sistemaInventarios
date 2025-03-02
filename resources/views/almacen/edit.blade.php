@extends('adminlte::page')

@section('title', 'Editar Artículo en Almacén')

@section('content_header')
    <h1>Editar Artículo en Almacén</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline card-success">
                <div class="card-header">
                    <h3 class="card-title">Actualizar Datos del Artículo</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('almacen.update', $almacen->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <!-- Tipo de Artículo -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tipo">Tipo de Artículo</label>
                                    <select name="tipo" id="tipo" class="form-control @error('tipo') is-invalid @enderror" required>
                                        <option value="inmueble" {{ $almacen->tipo == 'inmueble' ? 'selected' : '' }}>Inmueble</option>
                                        <option value="consumible" {{ $almacen->tipo == 'consumible' ? 'selected' : '' }}>Consumible</option>
                                    </select>
                                    @error('tipo')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Fecha de Compra -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="fecha_compra">Fecha de Compra</label>
                                    <input type="date" name="fecha_compra" id="fecha_compra" 
                                           class="form-control @error('fecha_compra') is-invalid @enderror" 
                                           value="{{ old('fecha_compra', $almacen->fecha_compra) }}">
                                    @error('fecha_compra')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Proveedor -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="proveedor_id">Proveedor</label>
                                    <div class="input-group">
                                        <select name="proveedor_id" id="proveedor_id" class="form-control @error('proveedor_id') is-invalid @enderror">
                                            <option value="" disabled selected>Seleccione un proveedor</option>
                                            @foreach ($proveedores as $proveedor)
                                                <option value="{{ $proveedor->id }}">
                                                    {{ $proveedor->nombre }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div class="input-group-append">
                                            <a href="{{ route('proveedores.create') }}" class="btn btn-success">
                                                <i class="fa-solid fa-plus"></i> Nuevo
                                            </a>
                                        </div>
                                    </div>
                                    @error('proveedor_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>


                            <!-- Fecha de Entrada -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="fecha_entrada">Fecha de Entrada</label>
                                    <input type="date" name="fecha_entrada" id="fecha_entrada" 
                                           class="form-control @error('fecha_entrada') is-invalid @enderror" 
                                           value="{{ old('fecha_entrada', $almacen->fecha_entrada) }}">
                                    @error('fecha_entrada')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Recibido por -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="recibido_por">Recibido Por</label>
                                    <input type="text" name="recibido_por" id="recibido_por" 
                                           class="form-control @error('recibido_por') is-invalid @enderror" 
                                           value="{{ old('recibido_por', $almacen->recibido_por) }}">
                                    @error('recibido_por')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Fecha de Salida -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="fecha_salida">Fecha de Salida (Opcional)</label>
                                    <input type="date" name="fecha_salida" id="fecha_salida" 
                                           class="form-control @error('fecha_salida') is-invalid @enderror" 
                                           value="{{ old('fecha_salida', $almacen->fecha_salida) }}">
                                    @error('fecha_salida')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Stock -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="stock">Stock Disponible</label>
                                    <input type="number" name="stock" id="stock"
                                           class="form-control @error('stock') is-invalid @enderror"
                                           value="{{ old('stock', $almacen->stock) }}" min="0" required>
                                    @error('stock')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Departamento -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="departamento">Departamento</label>
                                    <input type="text" name="departamento" id="departamento" 
                                           class="form-control @error('departamento') is-invalid @enderror" 
                                           value="{{ old('departamento', $almacen->departamento) }}" required>
                                    @error('departamento')
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
                                <a href="{{ route('almacen.index') }}" class="btn btn-secondary">
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
                title: 'Errores en el formulario',
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
