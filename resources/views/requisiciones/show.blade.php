@extends('adminlte::page')

@section('title', 'Detalles de la Requisición')

@section('content_header')
    <h1>Detalles de la Requisición</h1>
@stop

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card card-outline card-info">
                <div class="card-header">
                    <h3 class="card-title">Datos Registrados</h3>
                </div>
                <div class="card-body">

                    {{-- Fila 1 --}}
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Número de Requisición</label>
                                <p class="form-control-static">{{ $requisicion->numero_requisicion }}</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Fecha de Requisición</label>
                                <p class="form-control-static">{{ optional($requisicion->fecha_requisicion)->format('d/m/Y') ?? 'No especificada' }}</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Unidad Responsable (UR)</label>
                                <p class="form-control-static">{{ $requisicion->ur ?? 'No especificada' }}</p>
                            </div>
                        </div>
                    </div>

                    {{-- Fila 2 --}}
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Departamento</label>
                                <p class="form-control-static">{{ $requisicion->departamento ?? 'No especificado' }}</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Partida</label>
                                <p class="form-control-static">{{ $requisicion->partida ?? 'No especificada' }}</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Producto o Material</label>
                                <p class="form-control-static">{{ $requisicion->producto_material ?? 'No especificado' }}</p>
                            </div>
                        </div>
                    </div>

                    {{-- Fila 3 --}}
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Justificación</label>
                                <p class="form-control-static">{{ $requisicion->justificacion ?? 'No especificada' }}</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Proveedor</label>
                                <p class="form-control-static">{{ $requisicion->proveedor ?? 'No especificado' }}</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Monto</label>
                                <p class="form-control-static">${{ number_format($requisicion->monto, 2) }}</p>
                            </div>
                        </div>
                    </div>

                    {{-- Fila 4 --}}
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Estado</label>
                                <p class="form-control-static">{{ $requisicion->status_requisicion ?? 'No especificado' }}</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Oficio de Pago</label>
                                <p class="form-control-static">{{ $requisicion->oficio_pago ?? 'No especificado' }}</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Número de Factura</label>
                                <p class="form-control-static">{{ $requisicion->numero_factura ?? 'No especificado' }}</p>
                            </div>
                        </div>
                    </div>

                    {{-- Fila 5 --}}
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Fecha de Entrega a Recursos Financieros</label>
                                <p class="form-control-static">{{ optional($requisicion->fecha_entrega_rf)->format('d/m/Y') ?? 'No especificada' }}</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Fecha de Pago</label>
                                <p class="form-control-static">{{ optional($requisicion->fecha_pago)->format('d/m/Y') ?? 'No especificada' }}</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Banco</label>
                                <p class="form-control-static">{{ $requisicion->banco ?? 'No especificado' }}</p>
                            </div>
                        </div>
                    </div>

                    {{-- Fila 6 --}}
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Referencia</label>
                                <p class="form-control-static">{{ $requisicion->referencia ?? 'No especificada' }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Observaciones</label>
                                <p class="form-control-static">{{ $requisicion->observaciones ?? 'Sin observaciones' }}</p>
                            </div>
                        </div>
                    </div>

                    <hr>

                    {{-- Botón de regreso --}}
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <a href="{{ route('requisiciones.index') }}" class="btn btn-secondary">
                                <i class="fa-solid fa-arrow-left"></i> Volver al listado
                            </a>
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
