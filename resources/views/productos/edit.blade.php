@extends('adminlte::page')

@section('title', 'Editar Producto')

@section('content_header')
    <h1>Editar Producto</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline card-success">
                <div class="card-header">
                    <h3 class="card-title">Actualizar Datos del Producto</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('productos.update', $producto->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT') <!-- Para actualizar usamos PUT -->

                        <div class="row">

                            <!-- Nombre -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="nombre">Nombre</label>
                                    <input type="text" name="nombre" id="nombre" class="form-control"
                                           value="{{ old('nombre', $producto->nombre) }}"
                                           placeholder="Ingrese el nombre del producto" required>
                                </div>
                            </div>

                            <!-- Categoría -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="categoria_id">Categoría</label>
                                    <select name="categoria_id" id="categoria_id" class="form-control" required>
                                        <option value="" disabled>Seleccione una categoría</option>
                                        @foreach ($categorias as $categoria)
                                            <option value="{{ $categoria->id }}" 
                                                {{ $producto->categoria_id == $categoria->id ? 'selected' : '' }}>
                                                {{ $categoria->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Proveedor -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="proveedor_id">Proveedor</label>
                                    <select name="proveedor_id" id="proveedor_id" class="form-control">
                                        <option value="" disabled>Seleccione un proveedor</option>
                                        @foreach ($proveedores as $proveedor)
                                            <option value="{{ $proveedor->id }}" 
                                                {{ $producto->proveedor_id == $proveedor->id ? 'selected' : '' }}>
                                                {{ $proveedor->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- Departamento -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="departamento_id">Departamento</label>
                                    <select name="departamento_id" id="departamento_id" class="form-control">
                                        <option value="" disabled>Seleccione un departamento</option>
                                        @foreach ($departamentos as $departamento)
                                            <option value="{{ $departamento->id }}" 
                                                {{ $producto->departamento_id == $departamento->id ? 'selected' : '' }}>
                                                {{ $departamento->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- Cantidad en Stock -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="cantidad_stock">Cantidad en Stock</label>
                                    <input type="number" name="cantidad_stock" id="cantidad_stock" class="form-control"
                                           value="{{ old('cantidad_stock', $producto->cantidad_stock) }}"
                                           placeholder="Ingrese la cantidad en stock" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Stock Mínimo -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="stock_minimo">Stock Mínimo</label>
                                    <input type="number" name="stock_minimo" id="stock_minimo" class="form-control"
                                           value="{{ old('stock_minimo', $producto->stock_minimo) }}"
                                           placeholder="Ingrese el stock mínimo">
                                </div>
                            </div>

                            <!-- Precio de Compra -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="precio_compra">Precio de Compra</label>
                                    <input type="number" step="0.01" name="precio_compra" id="precio_compra" class="form-control"
                                           value="{{ old('precio_compra', $producto->precio_compra) }}"
                                           placeholder="Ingrese el precio de compra" required>
                                </div>
                            </div>

                            <!-- Ubicación -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="ubicacion">Ubicación</label>
                                    <input type="text" name="ubicacion" id="ubicacion" class="form-control"
                                           value="{{ old('ubicacion', $producto->ubicacion) }}"
                                           placeholder="Ingrese la ubicación del producto">
                                </div>
                            </div>
                        </div>

                        <hr>
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa-solid fa-check"></i> Guardar Cambios
                                </button>
                                <a href="{{ route('productos.index') }}" class="btn btn-secondary">
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
