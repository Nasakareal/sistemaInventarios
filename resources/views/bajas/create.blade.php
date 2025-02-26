@extends('adminlte::page')

@section('title', 'Registrar Baja de Bien')

@section('content_header')
    <h1>Registrar Baja de un Bien</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">Llene los Datos de la Baja</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('bajas.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <!-- Selección del Bien -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="bien_id">Bien a Dar de Baja</label>
                                    <select name="bien_id" id="bien_id" 
                                            class="form-control @error('bien_id') is-invalid @enderror" required>
                                        <option value="" disabled selected>Seleccione un bien</option>
                                        @foreach ($bienes as $bien)
                                            <option value="{{ $bien->id }}" {{ old('bien_id') == $bien->id ? 'selected' : '' }}>
                                                {{ $bien->nombre }} ({{ $bien->codigo }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('bien_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Fecha de Baja -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="fecha_baja">Fecha de Baja</label>
                                    <input type="date" name="fecha_baja" id="fecha_baja"
                                           class="form-control @error('fecha_baja') is-invalid @enderror"
                                           value="{{ old('fecha_baja') }}" required>
                                    @error('fecha_baja')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Motivo de Baja -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="motivo">Motivo de Baja</label>
                                    <select name="motivo" id="motivo" 
                                            class="form-control @error('motivo') is-invalid @enderror" required>
                                        <option value="" disabled selected>Seleccione un motivo</option>
                                        <option value="OBSOLETO" {{ old('motivo') == 'OBSOLETO' ? 'selected' : '' }}>Obsolescencia</option>
                                        <option value="DAÑO IRREPARABLE" {{ old('motivo') == 'DAÑO IRREPARABLE' ? 'selected' : '' }}>Daño Irreparable</option>
                                        <option value="DONACIÓN" {{ old('motivo') == 'DONACIÓN' ? 'selected' : '' }}>Donación</option>
                                        <option value="TRASPASO" {{ old('motivo') == 'TRASPASO' ? 'selected' : '' }}>Traspaso</option>
                                        <option value="OTRO" {{ old('motivo') == 'OTRO' ? 'selected' : '' }}>Otro</option>
                                    </select>
                                    @error('motivo')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Responsable -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="responsable">Responsable</label>
                                    <input type="text" name="responsable" id="responsable" 
                                           class="form-control @error('responsable') is-invalid @enderror" 
                                           value="{{ old('responsable') }}" placeholder="Nombre del responsable" required>
                                    @error('responsable')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Observaciones -->
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="observaciones">Observaciones</label>
                                    <textarea name="observaciones" id="observaciones"
                                              class="form-control @error('observaciones') is-invalid @enderror"
                                              rows="3" placeholder="Ingrese detalles adicionales">{{ old('observaciones') }}</textarea>
                                    @error('observaciones')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Documento de Baja (Opcional) -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="documento">Documento de Baja (PDF)</label>
                                    <input type="file" name="documento" id="documento" accept="application/pdf"
                                           class="form-control @error('documento') is-invalid @enderror">
                                    @error('documento')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa-solid fa-check"></i> Registrar Baja
                                    </button>
                                    <a href="{{ route('bajas.index') }}" class="btn btn-secondary">
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
