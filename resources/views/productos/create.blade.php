@extends('adminlte::page')

@section('title', 'Crear Producto')

@section('content_header')
    <h1>Creación de un Nuevo Producto</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">Llene los Datos del Producto</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('productos.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <!-- Nombre -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="nombre">Nombre</label>
                                    <input type="text" name="nombre" id="nombre" 
                                           class="form-control @error('nombre') is-invalid @enderror" 
                                           value="{{ old('nombre') }}" placeholder="Ingrese el nombre" required>
                                    @error('nombre')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Categoría -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="categoria_id">Categoría</label>
                                    <select name="categoria_id" id="categoria_id" 
                                            class="form-control @error('categoria_id') is-invalid @enderror" required>
                                        <option value="" disabled selected>Seleccione una categoría</option>
                                        @foreach ($categorias as $categoria)
                                            <option value="{{ $categoria->id }}" {{ old('categoria_id') == $categoria->id ? 'selected' : '' }}>
                                                {{ $categoria->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('categoria_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Proveedor -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="proveedor_id">Proveedor</label>
                                    <select name="proveedor_id" id="proveedor_id" 
                                            class="form-control @error('proveedor_id') is-invalid @enderror">
                                        <option value="" disabled selected>Seleccione un proveedor</option>
                                        @foreach ($proveedores as $proveedor)
                                            <option value="{{ $proveedor->id }}" {{ old('proveedor_id') == $proveedor->id ? 'selected' : '' }}>
                                                {{ $proveedor->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('proveedor_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            
                            <!-- Departamento -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="departamento_id">Departamento</label>
                                    <select name="departamento_id" id="departamento_id" 
                                            class="form-control @error('departamento_id') is-invalid @enderror">
                                        <option value="" disabled selected>Seleccione un departamento</option>
                                        @foreach ($departamentos as $departamento)
                                            <option value="{{ $departamento->id }}" {{ old('departamento_id') == $departamento->id ? 'selected' : '' }}>
                                                {{ $departamento->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('departamento_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Cantidad en Stock -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="cantidad_stock">Cantidad en Stock</label>
                                    <input type="number" name="cantidad_stock" id="cantidad_stock" 
                                           class="form-control @error('cantidad_stock') is-invalid @enderror" 
                                           value="{{ old('cantidad_stock', 0) }}" min="0" required>
                                    @error('cantidad_stock')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                             <!-- Precio de Compra -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="precio_compra">Precio de Compra</label>
                                    <input type="number" name="precio_compra" id="precio_compra" 
                                           class="form-control @error('precio_compra') is-invalid @enderror" 
                                           value="{{ old('precio_compra', 0) }}" min="0" step="0.01" required>
                                    @error('precio_compra')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Imagen -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="imagen">Imagen</label>
                                    <input type="file" name="imagen" id="imagen" 
                                           class="form-control-file @error('imagen') is-invalid @enderror" accept="image/*">
                                    @error('imagen')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa-solid fa-check"></i> Registrar
                                    </button>
                                    <a href="{{ route('productos.index') }}" class="btn btn-secondary">
                                        <i class="fa-solid fa-ban"></i> Cancelar
                                    </a>
                                </div>
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
