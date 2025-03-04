@extends('adminlte::page')

@section('title', 'Detalles del Producto')

@section('content_header')
    <h1>Detalles del Producto</h1>
@stop

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card card-outline card-info">
                <div class="card-header">
                    <h3 class="card-title">Datos del Producto</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        {{-- Código --}}
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="codigo">Código</label>
                                <p class="form-control-static">{{ $producto->codigo ?? 'Sin código' }}</p>
                            </div>
                        </div>
                        {{-- Nombre --}}
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="nombre">Nombre</label>
                                <p class="form-control-static">{{ $producto->nombre }}</p>
                            </div>
                        </div>
                        {{-- Categoría --}}
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="categoria">Categoría</label>
                                <p class="form-control-static">{{ $producto->categoria->nombre ?? 'No asignada' }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        {{-- Proveedor --}}
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="proveedor">Proveedor</label>
                                <p class="form-control-static">{{ $producto->proveedor->nombre ?? 'No asignado' }}</p>
                            </div>
                        </div>
                        {{-- Departamento --}}
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="departamento">Departamento</label>
                                <p class="form-control-static">{{ $producto->departamento->nombre ?? 'No especificado' }}</p>
                            </div>
                        </div>
                    </div>           

                    <div class="row">
                        {{-- Precio de Compra --}}
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="precio_compra">Precio de Compra</label>
                                <p class="form-control-static">$ {{ number_format($producto->precio_compra, 2) }}</p>
                            </div>
                        </div>
                        {{-- Ubicación --}}
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="ubicacion">Ubicación</label>
                                <p class="form-control-static">{{ $producto->ubicacion ?? 'No especificada' }}</p>
                            </div>
                        </div>
                        {{-- Estado --}}
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="estado">Estado</label>
                                <p class="form-control-static">{{ $producto->estado }}</p>
                            </div>
                        </div>
                    </div>

                    {{-- Fila para Área, UR y Partida --}}
                    <div class="row">
                        {{-- Área --}}
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="area">Área</label>
                                <p class="form-control-static">{{ $producto->area ?? 'No especificada' }}</p>
                            </div>
                        </div>
                        {{-- UR --}}
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="ur">UR</label>
                                <p class="form-control-static">{{ $producto->ur ?? 'No especificada' }}</p>
                            </div>
                        </div>
                        {{-- Partida --}}
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="partida">Partida</label>
                                <p class="form-control-static">{{ $producto->partida ?? 'No especificada' }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        {{-- Descripción  --}}
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="descripcion">Descripción</label>
                                <p class="form-control-static">{{ $producto->descripcion ?? 'No especificada' }}</p>
                            </div>
                        </div>
                        {{-- Imagen del Producto --}}
                        <div class="col-md-8">
                            <div class="form-group text-center">
                                <label for="imagen">Imagen del Producto</label>
                                @if ($producto->imagen_url)
                                    <div>
                                        <img src="{{ asset('storage/' . $producto->imagen_url) }}" alt="Imagen del Producto" style="max-width: 200px; max-height: 200px;" class="img-thumbnail">
                                    </div>
                                @else
                                    <p class="form-control-static">No tiene imagen.</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        {{-- Número de Inventario Patrimonial --}}
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="numero_inventario_patrimonial">Número de Inventario Patrimonial</label>
                                <p class="form-control-static">{{ $producto->numero_inventario_patrimonial ?? 'No asignado' }}</p>
                            </div>
                        </div>
                        {{-- Factura --}}
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="factura">Factura</label>
                                @if($producto->factura_url)
                                    <p class="form-control-static"><a href="{{ asset('storage/' . $producto->factura_url) }}" target="_blank">Ver Factura</a></p>
                                @else
                                    <p class="form-control-static">No se subió factura.</p>
                                @endif
                            </div>
                        </div>
                        {{-- Resguardo del Bien --}}
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="resguardo">Resguardo del Bien</label>
                                @if($producto->resguardo_url)
                                    <p class="form-control-static">
                                        <img src="{{ asset('storage/' . $producto->resguardo_url) }}" alt="Resguardo" style="max-width:150px; max-height:150px;" class="img-thumbnail">
                                    </p>
                                @else
                                    <p class="form-control-static">No se subió resguardo.</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        {{-- Vida Útil --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="vida_util">Vida Útil (años)</label>
                                <p class="form-control-static">{{ $producto->vida_util ?? 'No definida' }}</p>
                            </div>
                        </div>
                        {{-- Depreciación Anual --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="depreciacion_anual">Depreciación Anual ($)</label>
                                <p class="form-control-static">
                                    $ {{ $producto->depreciacion_anual ? number_format($producto->depreciacion_anual, 2) : 'No calculada' }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <hr>
                    <div class="row">
                        {{-- Botón de regreso --}}
                        <div class="col-md-12 text-center">
                            <div class="form-group">
                                <a href="{{ route('productos.index') }}" class="btn btn-secondary">
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
        .img-thumbnail {
            border: 2px solid #ddd;
            border-radius: 8px;
            padding: 4px;
        }
    </style>
@stop

@section('js')
    <script> console.log("Vista de detalles del producto cargada correctamente."); </script>
@stop
