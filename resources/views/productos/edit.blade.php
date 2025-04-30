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
                    <form action="{{ route('productos.update', $producto->id) }}"
                          method="POST"
                          enctype="multipart/form-data"
                          id="form-producto-edit">
                        @csrf
                        @method('PUT')

                        {{-- Nombre, Estado, Categoría --}}
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="nombre">Nombre <span class="text-danger">*</span></label>
                                    <input type="text" name="nombre" id="nombre"
                                           class="form-control @error('nombre') is-invalid @enderror"
                                           value="{{ old('nombre', $producto->nombre) }}"
                                           placeholder="Ingrese nombre" required>
                                    @error('nombre')
                                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="estado">Estado <span class="text-danger">*</span></label>
                                    <select name="estado" id="estado"
                                            class="form-control @error('estado') is-invalid @enderror"
                                            required>
                                        <option value="" disabled>Seleccione</option>
                                        <option value="ACTIVO"   {{ old('estado', $producto->estado)=='ACTIVO'   ? 'selected':'' }}>ACTIVO</option>
                                        <option value="INACTIVO" {{ old('estado', $producto->estado)=='INACTIVO' ? 'selected':'' }}>INACTIVO</option>
                                    </select>
                                    @error('estado')
                                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="categoria_id">Categoría <span class="text-danger">*</span></label>
                                    <select name="categoria_id" id="categoria_id"
                                            class="form-control @error('categoria_id') is-invalid @enderror"
                                            required>
                                        <option value="" disabled>Seleccione</option>
                                        @foreach($categorias as $cat)
                                            <option value="{{ $cat->id }}"
                                                {{ old('categoria_id', $producto->categoria_id)==$cat->id ? 'selected':'' }}>
                                                {{ $cat->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('categoria_id')
                                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Descripción --}}
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="descripcion">Descripción</label>
                                    <textarea name="descripcion" id="descripcion" rows="3"
                                              class="form-control @error('descripcion') is-invalid @enderror"
                                              placeholder="Opcional">{{ old('descripcion', $producto->descripcion) }}</textarea>
                                    @error('descripcion')
                                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Proveedor, Departamento, Precio de compra --}}
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="proveedor_id">Proveedor</label>
                                    <select name="proveedor_id" id="proveedor_id"
                                            class="form-control @error('proveedor_id') is-invalid @enderror">
                                        <option value="" disabled>Seleccione</option>
                                        @foreach($proveedores as $prov)
                                            <option value="{{ $prov->id }}"
                                                {{ old('proveedor_id', $producto->proveedor_id)==$prov->id ? 'selected':'' }}>
                                                {{ $prov->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('proveedor_id')
                                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="departamento_id">Departamento</label>
                                    <select name="departamento_id" id="departamento_id"
                                            class="form-control @error('departamento_id') is-invalid @enderror">
                                        <option value="" disabled>Seleccione</option>
                                        @foreach($departamentos as $dep)
                                            <option value="{{ $dep->id }}"
                                                {{ old('departamento_id', $producto->departamento_id)==$dep->id ? 'selected':'' }}>
                                                {{ $dep->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('departamento_id')
                                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="precio_compra">Precio de Compra ($) <span class="text-danger">*</span></label>
                                    <input type="number" name="precio_compra" id="precio_compra"
                                           class="form-control @error('precio_compra') is-invalid @enderror"
                                           value="{{ old('precio_compra', $producto->precio_compra) }}"
                                           min="0" step="0.01" required>
                                    @error('precio_compra')
                                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Imagen, Factura, Resguardo --}}
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="imagen">Imagen del Producto</label>
                                    <input type="file" name="imagen" id="imagen"
                                           class="form-control-file @error('imagen') is-invalid @enderror"
                                           accept="image/*">
                                    @error('imagen')
                                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                    @enderror
                                    @if($producto->imagen_url)
                                        <img src="{{ asset('storage/'.$producto->imagen_url) }}"
                                             class="img-thumbnail mt-2" width="120">
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="factura">Factura (PDF)</label>
                                    <input type="file" name="factura" id="factura"
                                           class="form-control-file @error('factura') is-invalid @enderror"
                                           accept="application/pdf">
                                    @error('factura')
                                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                    @enderror
                                    @if($producto->factura_url)
                                        <a href="{{ asset('storage/'.$producto->factura_url) }}"
                                           target="_blank">Ver factura actual</a>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="resguardo">Resguardo del Bien</label>
                                    <input type="file" name="resguardo" id="resguardo"
                                           class="form-control-file @error('resguardo') is-invalid @enderror"
                                           accept="image/*">
                                    @error('resguardo')
                                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                    @enderror
                                    @if($producto->resguardo_url)
                                        <img src="{{ asset('storage/'.$producto->resguardo_url) }}"
                                             class="img-thumbnail mt-2" width="120">
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- Área, UR, Partida, Inventarios --}}
                        <div class="row mt-3">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="area">Área</label>
                                    <input type="text" name="area" id="area"
                                           class="form-control @error('area') is-invalid @enderror"
                                           value="{{ old('area', $producto->area) }}"
                                           placeholder="Opcional">
                                    @error('area')
                                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="ur">UR</label>
                                    <input type="text" name="ur" id="ur"
                                           class="form-control @error('ur') is-invalid @enderror"
                                           value="{{ old('ur', $producto->ur) }}"
                                           placeholder="Opcional">
                                    @error('ur')
                                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="partida">Partida</label>
                                    <input type="text" name="partida" id="partida"
                                           class="form-control @error('partida') is-invalid @enderror"
                                           value="{{ old('partida', $producto->partida) }}"
                                           placeholder="Opcional">
                                    @error('partida')
                                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="numero_inventario_patrimonial">Nº Inventario Patrimonial</label>
                                    <input type="text" name="numero_inventario_patrimonial"
                                           id="numero_inventario_patrimonial"
                                           class="form-control @error('numero_inventario_patrimonial') is-invalid @enderror"
                                           value="{{ old('numero_inventario_patrimonial', $producto->numero_inventario_patrimonial) }}"
                                           placeholder="Opcional">
                                    @error('numero_inventario_patrimonial')
                                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Nº Inventario SAACG --}}
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="numero_inventario_saacg">Nº Inventario SAACG</label>
                                    <input type="text" name="numero_inventario_saacg"
                                           id="numero_inventario_saacg"
                                           class="form-control @error('numero_inventario_saacg') is-invalid @enderror"
                                           value="{{ old('numero_inventario_saacg', $producto->numero_inventario_saacg) }}"
                                           placeholder="Opcional">
                                    @error('numero_inventario_saacg')
                                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Vida útil & depreciación --}}
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="vida_util">Vida Útil (años)</label>
                                    <input type="number" name="vida_util" id="vida_util"
                                           class="form-control @error('vida_util') is-invalid @enderror"
                                           value="{{ old('vida_util', $producto->vida_util) }}"
                                           min="1">
                                    @error('vida_util')
                                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="depreciacion_anual">Depreciación Anual ($)</label>
                                    <input type="text" name="depreciacion_anual" id="depreciacion_anual"
                                           class="form-control" readonly
                                           value="{{ old('depreciacion_anual', $producto->depreciacion_anual) }}">
                                </div>
                            </div>
                        </div>

                        <hr>

                        <div class="row">
                            <div class="col-md-12 text-right">
                                <button type="submit" class="btn btn-success">
                                    <i class="fa fa-check"></i> Guardar Cambios
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
@stop

@push('js')
<script>
    // recalcula depreciación cuando cambian precio o vida útil
    ['precio_compra','vida_util'].forEach(id => {
        document.getElementById(id).addEventListener('input', () => {
            const precio = parseFloat(document.getElementById('precio_compra').value) || 0;
            const vida   = parseInt(document.getElementById('vida_util').value) || 0;
            document.getElementById('depreciacion_anual').value =
                (vida > 0 ? (precio/vida).toFixed(2) : '');
        });
    });
</script>
@endpush


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
