@extends('adminlte::page')

@section('title', 'Editar Categoría')

@section('content_header')
    <h1>Editar Categoría</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline card-success">
                <div class="card-header">
                    <h3 class="card-title">Actualizar Datos de la Categoría</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('categorias.update', $categoria->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <!-- Nombre de la Categoría -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nombre">Nombre de la Categoría</label>
                                    <input type="text" name="nombre" id="nombre" class="form-control @error('nombre') is-invalid @enderror"
                                           value="{{ old('nombre', $categoria->nombre) }}" placeholder="Ingrese el nombre de la categoría" required>
                                    @error('nombre')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Descripción de la Categoría -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="descripcion">Descripción</label>
                                    <textarea name="descripcion" id="descripcion" rows="3"
                                              class="form-control @error('descripcion') is-invalid @enderror"
                                              placeholder="Ingrese una descripción">{{ old('descripcion', $categoria->descripcion) }}</textarea>
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
                                    <i class="fa-solid fa-check"></i> Guardar Cambios
                                </button>
                                <a href="{{ route('categorias.index') }}" class="btn btn-secondary">
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
