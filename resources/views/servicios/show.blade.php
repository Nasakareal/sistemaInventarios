@extends('adminlte::page')

@section('title', 'Detalles del Servicio de Mantenimiento')

@section('content_header')
    <h1>Detalles del Servicio de Mantenimiento</h1>
@stop

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card card-outline card-info">
                <div class="card-header">
                    <h3 class="card-title">Información del Servicio</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        {{-- Nombre del Servicio --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nombre">Servicio</label>
                                <p class="form-control-static">{{ $servicio->nombre }}</p>
                            </div>
                        </div>

                        {{-- Frecuencia --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="frecuencia_semanas">Frecuencia (Semanas)</label>
                                <p class="form-control-static">{{ $servicio->frecuencia_semanas }} semanas</p>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        {{-- Última Realización --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="ultima_realizacion">Última Realización</label>
                                <p class="form-control-static">{{ $servicio->ultima_realizacion_formatted }}</p>
                            </div>
                        </div>

                        {{-- Próxima Realización --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="proxima_realizacion">Próxima Realización</label>
                                <p class="form-control-static">
                                    @if (strtotime($servicio->proxima_realizacion) < strtotime(now()))
                                        <span class="badge badge-danger">{{ $servicio->proxima_realizacion_formatted }} (VENCIDO)</span>
                                    @elseif (strtotime($servicio->proxima_realizacion) <= strtotime('+7 days'))
                                        <span class="badge badge-warning">{{ $servicio->proxima_realizacion_formatted }} (PRONTO)</span>
                                    @else
                                        <span class="badge badge-success">{{ $servicio->proxima_realizacion_formatted }}</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        {{-- Descripción --}}
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="descripcion">Descripción</label>
                                <p class="form-control-static">{{ $servicio->descripcion ?? 'No especificada' }}</p>
                            </div>
                        </div>
                    </div>

                    <hr>
                    <div class="row">
                        {{-- Botones de Acción --}}
                        <div class="col-md-12 text-center">
                            <div class="form-group">
                                <a href="{{ route('servicios.index') }}" class="btn btn-secondary">
                                    <i class="fa-solid fa-arrow-left"></i> Volver
                                </a>
                                <a href="{{ route('servicios.edit', $servicio->id) }}" class="btn btn-success">
                                    <i class="fa-solid fa-pencil"></i> Editar
                                </a>
                                <form action="{{ route('servicios.destroy', $servicio->id) }}" method="POST" style="display: inline-block;">
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
                title: '¿Estás seguro de eliminar este servicio?',
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
