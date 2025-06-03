@extends('adminlte::page')

@section('title', 'Detalle de Alerta')

@section('content_header')
    <h1>Detalle de Alerta</h1>
@stop

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card card-outline card-warning">
                <div class="card-header">
                    <h3 class="card-title">Información de la Alerta</h3>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>Tipo:</strong>
                            <p class="form-control-static">{{ $alerta->tipo }}</p>
                        </div>
                        <div class="col-md-6">
                            <strong>Origen:</strong>
                            <p class="form-control-static">{{ $alerta->origen ?? 'Desconocido' }}</p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-12">
                            <strong>Mensaje:</strong>
                            <p class="form-control-static">{{ $alerta->mensaje }}</p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>Estado:</strong>
                            <p class="form-control-static">
                                @if($alerta->leido)
                                    <span class="badge bg-success">Leído</span>
                                @else
                                    <span class="badge bg-danger">No leído</span>
                                @endif
                            </p>
                        </div>
                        <div class="col-md-6">
                            <strong>Fecha:</strong>
                            <p class="form-control-static">{{ \Carbon\Carbon::parse($alerta->created_at)->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>

                    <hr>
                    <div class="text-center">
                        <a href="{{ route('alerta.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Volver a la lista
                        </a>
                        @if(!$alerta->leido)
                            <form action="{{ route('alerta.update', $alerta->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PUT')
                                <button class="btn btn-success">
                                    <i class="fas fa-check-circle"></i> Marcar como leída
                                </button>
                            </form>

                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <style>
        .form-control-static {
            font-size: 1rem;
            margin-top: 0.25rem;
        }
    </style>
@stop
