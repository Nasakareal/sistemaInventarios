@extends('adminlte::page')

@section('title', 'Registrar Servicio de Mantenimiento')

@section('content_header')
    <h1>Registrar Servicio de Mantenimiento</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">Llene los Datos del Servicio</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('servicios.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <!-- Nombre del Servicio -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nombre">Nombre del Servicio</label>
                                    <input type="text" name="nombre" id="nombre"
                                           class="form-control @error('nombre') is-invalid @enderror" 
                                           value="{{ old('nombre') }}" 
                                           placeholder="Ej: Corte de pasto, Limpieza de cisternas" required>
                                    @error('nombre')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Frecuencia en semanas -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="frecuencia_semanas">Frecuencia (en semanas)</label>
                                    <input type="number" name="frecuencia_semanas" id="frecuencia_semanas"
                                           class="form-control @error('frecuencia_semanas') is-invalid @enderror"
                                           value="{{ old('frecuencia_semanas') }}" min="1" required>
                                    @error('frecuencia_semanas')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Fecha de Última Realización -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="ultima_realizacion">Última Realización</label>
                                    <input type="date" name="ultima_realizacion" id="ultima_realizacion"
                                           class="form-control @error('ultima_realizacion') is-invalid @enderror"
                                           value="{{ old('ultima_realizacion') }}" required>
                                    @error('ultima_realizacion')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Próxima Realización (Calculada automáticamente) -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="proxima_realizacion">Próxima Realización (Automática)</label>
                                    <input type="text" id="proxima_realizacion"
                                           class="form-control" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Descripción del Servicio -->
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="descripcion">Descripción del Servicio</label>
                                    <textarea name="descripcion" id="descripcion"
                                              class="form-control @error('descripcion') is-invalid @enderror"
                                              rows="3" placeholder="Detalles adicionales">{{ old('descripcion') }}</textarea>
                                    @error('descripcion')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <hr>
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa-solid fa-check"></i> Registrar Servicio
                                </button>
                                <a href="{{ route('servicios.index') }}" class="btn btn-secondary">
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
        document.addEventListener("DOMContentLoaded", function () {
            const frecuenciaInput = document.getElementById('frecuencia_semanas');
            const ultimaRealizacionInput = document.getElementById('ultima_realizacion');
            const proximaRealizacionInput = document.getElementById('proxima_realizacion');

            function calcularProximaRealizacion() {
                let ultimaRealizacion = new Date(ultimaRealizacionInput.value);
                let frecuencia = parseInt(frecuenciaInput.value);

                if (!isNaN(ultimaRealizacion.getTime()) && !isNaN(frecuencia) && frecuencia > 0) {
                    let proximaFecha = new Date(ultimaRealizacion);
                    proximaFecha.setDate(proximaFecha.getDate() + (frecuencia * 7));
                    proximaRealizacionInput.value = proximaFecha.toISOString().split('T')[0];
                } else {
                    proximaRealizacionInput.value = "";
                }
            }

            frecuenciaInput.addEventListener('input', calcularProximaRealizacion);
            ultimaRealizacionInput.addEventListener('input', calcularProximaRealizacion);
        });

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
