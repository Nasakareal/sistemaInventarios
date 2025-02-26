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

                        <!-- Nuevos campos para Área, UR y Partida -->
                        <div class="row">
                            <!-- Área -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="area">Área</label>
                                    <input type="text" name="area" id="area" class="form-control"
                                           value="{{ old('area', $producto->area) }}"
                                           placeholder="Ingrese el área">
                                </div>
                            </div>

                            <!-- UR -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="ur">UR</label>
                                    <input type="text" name="ur" id="ur" class="form-control"
                                           value="{{ old('ur', $producto->ur) }}"
                                           placeholder="Ingrese la UR">
                                </div>
                            </div>

                            <!-- Partida -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="partida">Partida</label>
                                    <input type="text" name="partida" id="partida" class="form-control"
                                           value="{{ old('partida', $producto->partida) }}"
                                           placeholder="Ingrese la partida">
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <!-- Número de Inventario Patrimonial -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="numero_inventario_patrimonial">Número de Inventario Patrimonial</label>
                                    <input type="text" name="numero_inventario_patrimonial" id="numero_inventario_patrimonial"
                                           class="form-control @error('numero_inventario_patrimonial') is-invalid @enderror"
                                           value="{{ old('numero_inventario_patrimonial', $producto->numero_inventario_patrimonial ?? '') }}"
                                           placeholder="Ingrese el número de inventario patrimonial">
                                    @error('numero_inventario_patrimonial')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Factura (PDF) -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="factura">Factura (PDF)</label>
                                    <input type="file" name="factura" id="factura" accept="application/pdf"
                                           class="form-control @error('factura') is-invalid @enderror">
                                    @error('factura')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    @if(isset($producto) && $producto->factura_url)
                                        <a href="{{ asset('storage/' . $producto->factura_url) }}" target="_blank">Ver factura</a>
                                    @endif
                                </div>
                            </div>

                            <!-- Resguardo del Bien (Imagen) -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="resguardo">Resguardo del Bien (Imagen)</label>
                                    <input type="file" name="resguardo" id="resguardo" accept="image/*"
                                           class="form-control @error('resguardo') is-invalid @enderror">
                                    @error('resguardo')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    @if(isset($producto) && $producto->resguardo_url)
                                        <img src="{{ asset('storage/' . $producto->resguardo_url) }}" class="img-fluid mt-2" width="150">
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Campo para Imagen del Producto -->
                        <div class="row mt-3">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="imagen">Imagen del Producto</label>
                                    <input type="file" name="imagen" id="imagen" accept="image/*"
                                           class="form-control @error('imagen') is-invalid @enderror">
                                    @error('imagen')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    @if(isset($producto) && $producto->imagen_url)
                                        <img src="{{ asset('storage/' . $producto->imagen_url) }}" class="img-fluid mt-2" width="150">
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Campos para Vida Útil y Depreciación Anual -->
                        <div class="row mt-3">
                            <!-- Vida Útil -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="vida_util">Vida Útil (años)</label>
                                    <input type="number" name="vida_util" id="vida_util" class="form-control" 
                                           value="{{ old('vida_util', $producto->vida_util) }}" min="1">
                                </div>
                            </div>
                            
                            <!-- Depreciación Anual -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="depreciacion_anual">Depreciación Anual ($)</label>
                                    <input type="text" name="depreciacion_anual" id="depreciacion_anual" class="form-control" 
                                           value="{{ old('depreciacion_anual', $producto->depreciacion_anual) }}" readonly>
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
        document.getElementById('vida_util').addEventListener('input', function() {
            let vidaUtil = parseInt(this.value);
            let precioCompra = parseFloat("{{ old('precio_compra', $producto->precio_compra) }}");
            if (!isNaN(vidaUtil) && vidaUtil > 0) {
                let depreciacion = (precioCompra / vidaUtil).toFixed(2);
                document.getElementById('depreciacion_anual').value = depreciacion;
            } else {
                document.getElementById('depreciacion_anual').value = '';
            }
        });
    </script>
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
