@extends('adminlte::page')

@section('title', 'Editar Baja de Bien')

@section('content_header')
    <h1>Editar Baja de Bien</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline card-success">
                <div class="card-header">
                    <h3 class="card-title">Actualizar Datos de la Baja</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('bajas.update', $baja->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <!-- Bien Dado de Baja -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="bien_id">Bien Dado de Baja</label>
                                    <select name="bien_id" id="bien_id" class="form-control" required>
                                        <option value="" disabled>Seleccione un bien</option>
                                        @foreach ($bienes as $bien)
                                            <option value="{{ $bien->id }}" 
                                                {{ $baja->bien_id == $bien->id ? 'selected' : '' }}>
                                                {{ $bien->nombre }} ({{ $bien->codigo }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- Fecha de Baja -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="fecha_baja">Fecha de Baja</label>
                                    <input type="date" name="fecha_baja" id="fecha_baja" 
                                           class="form-control @error('fecha_baja') is-invalid @enderror"
                                           value="{{ old('fecha_baja', $baja->fecha_baja) }}" required>
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
                                        <option value="OBSOLETO" {{ $baja->motivo == 'OBSOLETO' ? 'selected' : '' }}>Obsolescencia</option>
                                        <option value="DAÑO IRREPARABLE" {{ $baja->motivo == 'DAÑO IRREPARABLE' ? 'selected' : '' }}>Daño Irreparable</option>
                                        <option value="DONACIÓN" {{ $baja->motivo == 'DONACIÓN' ? 'selected' : '' }}>Donación</option>
                                        <option value="TRASPASO" {{ $baja->motivo == 'TRASPASO' ? 'selected' : '' }}>Traspaso</option>
                                        <option value="OTRO" {{ $baja->motivo == 'OTRO' ? 'selected' : '' }}>Otro</option>
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
                                           value="{{ old('responsable', $baja->responsable) }}" required>
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
                                              rows="3">{{ old('observaciones', $baja->observaciones) }}</textarea>
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
                                    @if($baja->documento_url)
                                        <a href="{{ asset('storage/' . $baja->documento_url) }}" target="_blank">
                                            <i class="fa-solid fa-file-pdf"></i> Ver Documento Actual
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <hr>
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa-solid fa-check"></i> Guardar Cambios
                                </button>
                                <a href="{{ route('bajas.index') }}" class="btn btn-secondary">
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
