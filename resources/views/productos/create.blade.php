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

                        <!-- Nuevos campos para Área, UR, Partida, Número de Inventario, Factura, Resguardo -->
                        <div class="row mt-3">
                            <!-- Área -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="area">Área</label>
                                    <input type="text" name="area" id="area" 
                                           class="form-control @error('area') is-invalid @enderror" 
                                           value="{{ old('area') }}" placeholder="Ingrese el área">
                                    @error('area')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- UR -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="ur">UR</label>
                                    <input type="text" name="ur" id="ur" 
                                           class="form-control @error('ur') is-invalid @enderror" 
                                           value="{{ old('ur') }}" placeholder="Ingrese la UR">
                                    @error('ur')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Partida -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="partida">Partida</label>
                                    <input type="text" name="partida" id="partida" 
                                           class="form-control @error('partida') is-invalid @enderror" 
                                           value="{{ old('partida') }}" placeholder="Ingrese la partida">
                                    @error('partida')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Número de Inventario Patrimonial -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="numero_inventario_patrimonial">Número de Inventario Patrimonial</label>
                                    <input type="text" name="numero_inventario_patrimonial" id="numero_inventario_patrimonial"
                                           class="form-control @error('numero_inventario_patrimonial') is-invalid @enderror"
                                           value="{{ old('numero_inventario_patrimonial') }}"
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
                                </div>
                            </div>

                            <!-- Vida Útil y Depreciación Anual -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="vida_util">Vida Útil (años)</label>
                                    <input type="number" name="vida_util" id="vida_util" class="form-control" 
                                           value="{{ old('vida_util') }}" min="1">
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="depreciacion_anual">Depreciación Anual ($)</label>
                                    <input type="text" name="depreciacion_anual" id="depreciacion_anual" class="form-control" 
                                           value="{{ old('depreciacion_anual') }}" readonly>
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
        document.getElementById('vida_util').addEventListener('input', function() {
            let vidaUtil = parseInt(this.value);
            let precioCompra = parseFloat("{{ old('precio_compra', 0) }}");
            if (!isNaN(vidaUtil) && vidaUtil > 0) {
                let depreciacion = (precioCompra / vidaUtil).toFixed(2);
                document.getElementById('depreciacion_anual').value = depreciacion;
            } else {
                document.getElementById('depreciacion_anual').value = '';
            }
        });
    </script>
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
