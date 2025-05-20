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
                    <form action="{{ route('productos.store') }}" method="POST" enctype="multipart/form-data" id="form-producto">
                        @csrf

                        <div class="row">
                            <!-- Nombre -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="nombre">Nombre <span class="text-danger">*</span></label>
                                    <input type="text" name="nombre" id="nombre"
                                           class="form-control @error('nombre') is-invalid @enderror"
                                           value="{{ old('nombre') }}"
                                           placeholder="Ingrese el nombre" required>
                                    @error('nombre')
                                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Estado -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="estado">Estado <span class="text-danger">*</span></label>
                                    <select name="estado" id="estado"
                                            class="form-control @error('estado') is-invalid @enderror" required>
                                        <option value="" disabled selected>Seleccione</option>
                                        <option value="ACTIVO" {{ old('estado')=='ACTIVO' ? 'selected' : '' }}>ACTIVO</option>
                                        <option value="INACTIVO" {{ old('estado')=='INACTIVO' ? 'selected' : '' }}>INACTIVO</option>
                                    </select>
                                    @error('estado')
                                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Categoría -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="categoria_id">Categoría <span class="text-danger">*</span></label>
                                    <select name="categoria_id" id="categoria_id"
                                            class="form-control @error('categoria_id') is-invalid @enderror" required>
                                        <option value="" disabled selected>Seleccione</option>
                                        @foreach ($categorias as $categoria)
                                            <option value="{{ $categoria->id }}"
                                                {{ old('categoria_id') == $categoria->id ? 'selected' : '' }}>
                                                {{ $categoria->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('categoria_id')
                                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Descripción -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="descripcion">Descripción</label>
                                    <textarea name="descripcion" id="descripcion" rows="3"
                                              class="form-control @error('descripcion') is-invalid @enderror"
                                              placeholder="Opcional">{{ old('descripcion') }}</textarea>
                                    @error('descripcion')
                                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Proveedor -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="proveedor_id">Proveedor</label>
                                    <select name="proveedor_id" id="proveedor_id"
                                            class="form-control @error('proveedor_id') is-invalid @enderror">
                                        <option value="" disabled selected>Seleccione</option>
                                        @foreach ($proveedores as $proveedor)
                                            <option value="{{ $proveedor->id }}"
                                                {{ old('proveedor_id') == $proveedor->id ? 'selected' : '' }}>
                                                {{ $proveedor->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('proveedor_id')
                                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Departamento -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="departamento_id">Departamento</label>
                                    <select name="departamento_id" id="departamento_id"
                                            class="form-control @error('departamento_id') is-invalid @enderror">
                                        <option value="" disabled selected>Seleccione</option>
                                        @foreach ($departamentos as $departamento)
                                            <option value="{{ $departamento->id }}"
                                                {{ old('departamento_id') == $departamento->id ? 'selected' : '' }}>
                                                {{ $departamento->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('departamento_id')
                                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Precio de Compra -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="precio_compra">Precio de Compra ($) <span class="text-danger">*</span></label>
                                    <input type="number" name="precio_compra" id="precio_compra"
                                           class="form-control @error('precio_compra') is-invalid @enderror"
                                           value="{{ old('precio_compra', 0) }}"
                                           min="0" step="0.01">
                                    @error('precio_compra')
                                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Imagen, Factura, Resguardo -->
                        <div class="row">
                            <!-- Imagen -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="imagen">Imagen</label>
                                    <input type="file" name="imagen" id="imagen"
                                           class="form-control-file @error('imagen') is-invalid @enderror"
                                           accept="image/*">
                                    @error('imagen')
                                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>
                            <!-- Factura (PDF) -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="factura">Factura (PDF)</label>
                                    <input type="file" name="factura" id="factura"
                                           class="form-control-file @error('factura') is-invalid @enderror"
                                           accept="application/pdf">
                                    @error('factura')
                                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>
                            <!-- Resguardo (Imagen) -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="resguardo">Resguardo del Bien</label>
                                    <input type="file" name="resguardo" id="resguardo"
                                           class="form-control-file @error('resguardo') is-invalid @enderror"
                                           accept="image/*">
                                    @error('resguardo')
                                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Área, UR, Partida, Inventarios -->
                        <div class="row mt-3">
                            <!-- Área -->
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="area">Área</label>
                                    <input type="text" name="area" id="area"
                                           class="form-control @error('area') is-invalid @enderror"
                                           value="{{ old('area') }}"
                                           placeholder="Opcional">
                                    @error('area')
                                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>
                            <!-- UR -->
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="ur">UR</label>
                                    <input type="text" name="ur" id="ur"
                                           class="form-control @error('ur') is-invalid @enderror"
                                           value="{{ old('ur') }}"
                                           placeholder="Opcional">
                                    @error('ur')
                                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>
                            <!-- Partida -->
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="partida">Partida</label>
                                    <input type="text" name="partida" id="partida"
                                           class="form-control @error('partida') is-invalid @enderror"
                                           value="{{ old('partida') }}"
                                           placeholder="Opcional">
                                    @error('partida')
                                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>
                            <!-- Nº Inventario Patrimonial -->
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="numero_inventario_patrimonial">Nº Inventario Patrimonial</label>
                                    <input type="text" name="numero_inventario_patrimonial"
                                           id="numero_inventario_patrimonial"
                                           class="form-control @error('numero_inventario_patrimonial') is-invalid @enderror"
                                           value="{{ old('numero_inventario_patrimonial') }}"
                                           placeholder="Opcional">
                                    @error('numero_inventario_patrimonial')
                                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Nº Inventario SAACG -->
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="numero_inventario_saacg">Nº Inventario SAACG</label>
                                    <input type="text" name="numero_inventario_saacg"
                                           id="numero_inventario_saacg"
                                           class="form-control @error('numero_inventario_saacg') is-invalid @enderror"
                                           value="{{ old('numero_inventario_saacg') }}"
                                           placeholder="Opcional">
                                    @error('numero_inventario_saacg')
                                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Vida útil y depreciación -->
                        <div class="row">
                            <!-- Vida útil -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="vida_util">Vida Útil (años)</label>
                                    <input type="number" name="vida_util" id="vida_util"
                                           class="form-control @error('vida_util') is-invalid @enderror"
                                           value="{{ old('vida_util') }}" min="1">
                                    @error('vida_util')
                                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>
                            <!-- Depreciación anual -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="depreciacion_anual">Depreciación Anual ($)</label>
                                    <input type="text" name="depreciacion_anual" id="depreciacion_anual"
                                           class="form-control" readonly
                                           value="{{ old('depreciacion_anual') }}">
                                </div>
                            </div>
                        </div>
                        <!-- Tres Columnas Nuevas -->
                        <div class="row">
                            <!-- Marca -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="marca">Marca</label>
                                    <input type="text" name="marca" id="marca"
                                           class="form-control @error('marca') is-invalid @enderror"
                                           value="{{ old('marca') }}"
                                           placeholder="Ingrese la marca">
                                    @error('marca')
                                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Modelo -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="modelo">Modelo</label>
                                    <input type="text" name="modelo" id="modelo"
                                           class="form-control @error('modelo') is-invalid @enderror"
                                           value="{{ old('modelo') }}"
                                           placeholder="Ingrese el modelo">
                                    @error('modelo')
                                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Serie -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="serie">Serie</label>
                                    <input type="text" name="serie" id="serie"
                                           class="form-control @error('serie') is-invalid @enderror"
                                           value="{{ old('serie') }}"
                                           placeholder="Ingrese el número de serie">
                                    @error('serie')
                                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Ubicación, Resguardante, Observaciones-->
                        <div class="row">
                            <!-- Ubicación -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="ubicacion">Ubicación</label>
                                    <input type="text" name="ubicacion" id="ubicacion"
                                           class="form-control @error('ubicacion') is-invalid @enderror"
                                           value="{{ old('ubicacion') }}"
                                           placeholder="Ej. Almacén B, Estante 3">
                                    @error('ubicacion')
                                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Resguardante -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="resguardante">Resguardante</label>
                                    <input type="text" name="resguardante" id="resguardante"
                                           class="form-control @error('resguardante') is-invalid @enderror"
                                           value="{{ old('resguardante') }}"
                                           placeholder="Nombre completo de quien lo resguarda">
                                    @error('resguardante')
                                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Observaciones -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="observaciones">Observaciones</label>
                                    <textarea name="observaciones" id="observaciones"
                                              class="form-control @error('observaciones') is-invalid @enderror"
                                              rows="3"
                                              placeholder="Observaciones importantes, programa al que pertenece, etc.">{{ old('observaciones') }}</textarea>
                                    @error('observaciones')
                                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>
                        </div>


                        <hr>

                        <div class="row">
                            <div class="col-md-12 text-right">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-check"></i> Registrar
                                </button>
                                <a href="{{ route('productos.index') }}" class="btn btn-secondary">
                                    <i class="fa fa-ban"></i> Cancelar
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('js')
    <script>
        // Calcular depreciación al cambiar precio o vida útil
        document.querySelectorAll('#precio_compra, #vida_util').forEach(function(el) {
            el.addEventListener('input', function() {
                const precio = parseFloat(document.getElementById('precio_compra').value) || 0;
                const vida   = parseInt(document.getElementById('vida_util').value) || 0;
                let dep = '';
                if (vida > 0) {
                    dep = (precio / vida).toFixed(2);
                }
                document.getElementById('depreciacion_anual').value = dep;
            });
        });
    </script>
    @endpush

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
