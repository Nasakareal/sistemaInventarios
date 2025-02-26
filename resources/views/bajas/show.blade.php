@extends('adminlte::page')

@section('title', 'Detalles de la Baja')

@section('content_header')
    <h1>Detalles de la Baja de Bien</h1>
@stop

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card card-outline card-info">
                <div class="card-header">
                    <h3 class="card-title">Información de la Baja</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        {{-- Nombre del Bien --}}
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="bien">Bien Dado de Baja</label>
                                <p class="form-control-static">{{ $baja->bien->nombre ?? 'No especificado' }}</p>
                            </div>
                        </div>
                        {{-- Código del Bien --}}
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="codigo">Código</label>
                                <p class="form-control-static">{{ $baja->bien->codigo ?? 'Sin código' }}</p>
                            </div>
                        </div>
                        {{-- Categoría del Bien --}}
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="categoria">Categoría</label>
                                <p class="form-control-static">{{ $baja->bien->categoria->nombre ?? 'No asignada' }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        {{-- Fecha de Baja --}}
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="fecha_baja">Fecha de Baja</label>
                                <p class="form-control-static">{{ $baja->fecha_baja }}</p>
                            </div>
                        </div>
                        {{-- Motivo --}}
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="motivo">Motivo</label>
                                <p class="form-control-static">{{ ucfirst(strtolower($baja->motivo)) }}</p>
                            </div>
                        </div>
                        {{-- Responsable --}}
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="responsable">Responsable</label>
                                <p class="form-control-static">{{ $baja->responsable }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        {{-- Observaciones --}}
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="observaciones">Observaciones</label>
                                <p class="form-control-static">{{ $baja->observaciones ?? 'No especificadas' }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        {{-- Documento de Baja --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="documento">Documento de Baja</label>
                                @if($baja->documento_url)
                                    <p class="form-control-static">
                                        <a href="{{ asset('storage/' . $baja->documento_url) }}" target="_blank" class="btn btn-info btn-sm">
                                            <i class="fa-solid fa-file-pdf"></i> Ver Documento
                                        </a>
                                    </p>
                                @else
                                    <p class="form-control-static">No se adjuntó documento.</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <hr>
                    <div class="row">
                        {{-- Botón de regreso --}}
                        <div class="col-md-12 text-center">
                            <div class="form-group">
                                <a href="{{ route('bajas.index') }}" class="btn btn-secondary">
                                    <i class="fa-solid fa-arrow-left"></i> Volver
                                </a>
                                <a href="{{ route('bajas.edit', $baja->id) }}" class="btn btn-success">
                                    <i class="fa-solid fa-pencil"></i> Editar
                                </a>
                                <form action="{{ route('bajas.destroy', $baja->id) }}" method="POST" style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-danger delete-btn">
                                        <i class="fa-regular fa-trash-can"></i> Eliminar
                                    </button>
                                </form>
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
    </style>
@stop

@section('js')
    <script>
        $(document).on('click', '.delete-btn', function (e) {
            e.preventDefault();

            let form = $(this).closest('form');

            Swal.fire({
                title: '¿Estás seguro de eliminar esta baja?',
                text: "¡No podrás revertir esta acción!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });

        @if (session('success'))
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 1500
            });
        @endif
    </script>
@stop
