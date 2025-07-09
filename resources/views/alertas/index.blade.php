@extends('adminlte::page')

@section('title', 'Listado de Alertas')

@section('content_header')
    <h1>Listado de Alertas</h1>
@stop

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card card-outline card-warning">
                <div class="card-header">
                    <h3 class="card-title">Alertas Recibidas</h3>
                </div>
                <div class="card-body">
                    @if($alertas->isEmpty())
                        <div class="alert alert-info">No hay alertas registradas.</div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover table-sm">
                                <thead class="thead-dark">
                                    <tr class="text-center">
                                        <th>ID</th>
                                        <th>Tipo</th>
                                        <th>Mensaje</th>
                                        <th>Origen</th>
                                        <th>Requisición</th> <!-- NUEVA COLUMNA -->
                                        <th>Leído</th>
                                        <th>Fecha</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($alertas as $alerta)
                                        <tr class="text-center {{ $alerta->leido ? '' : 'table-warning' }}">
                                            <td>{{ $alerta->id }}</td>
                                            <td>{{ $alerta->tipo }}</td>
                                            <td class="text-start">{{ Str::limit($alerta->mensaje, 50) }}</td>
                                            <td>{{ $alerta->origen ?? 'Desconocido' }}</td>
                                            
                                            {{-- NUEVA COLUMNA DE REQUISICIÓN --}}
                                            <td>
                                                @if($alerta->requisicion_id)
                                                    <a href="{{ route('requisiciones.show', $alerta->requisicion_id) }}" class="btn btn-sm btn-info">
                                                        #{{ $alerta->requisicion_id }}
                                                    </a>
                                                @else
                                                    <span class="text-muted">N/A</span>
                                                @endif
                                            </td>

                                            <td>
                                                @if($alerta->leido)
                                                    <span class="badge bg-success">Sí</span>
                                                @else
                                                    <span class="badge bg-danger">No</span>
                                                @endif
                                            </td>
                                            <td>{{ \Carbon\Carbon::parse($alerta->created_at)->format('d/m/Y H:i') }}</td>
                                            <td>
                                                <a href="{{ route('alerta.show', $alerta->id) }}" class="btn btn-sm btn-primary">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                @if(!$alerta->leido)
                                                    <form action="{{ route('alerta.update', $alerta->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="submit" class="btn btn-sm btn-success">
                                                            <i class="fas fa-check"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <style>
        .table th, .table td {
            vertical-align: middle !important;
        }
    </style>
@stop
