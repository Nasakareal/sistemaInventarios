@extends('adminlte::page')

@section('title', 'Crear Requisición')

@section('content_header')
    <h1>Creación de una Nueva Requisición</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">Llene los Datos</h3>
                </div>
                <div class="card-body">
                    <!-- Formulario Principal -->
                    <form action="{{ route('requisiciones.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="cuenta_bancaria_id" value="{{ $cuentaBancariaId }}">

                        <!-- Primer Row -->
                        <div class="row">
                            <!-- Número de Requisición -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="numero_requisicion">Número de Requisición</label>
                                    <input type="text" name="numero_requisicion" id="numero_requisicion"
                                           class="form-control @error('numero_requisicion') is-invalid @enderror"
                                           value="{{ old('numero_requisicion') }}" placeholder="Ingrese el número de requisición" required>
                                    @error('numero_requisicion')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Fecha de Requisición -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="fecha_requisicion">Fecha de Requisición</label>
                                    <input type="date" name="fecha_requisicion" id="fecha_requisicion"
                                           class="form-control @error('fecha_requisicion') is-invalid @enderror"
                                           value="{{ old('fecha_requisicion') }}" required>
                                    @error('fecha_requisicion')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Unidad Responsable (UR) -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="ur">Unidad Responsable (UR)</label>
                                    <input type="text" name="ur" id="ur"
                                           class="form-control @error('ur') is-invalid @enderror"
                                           value="{{ old('ur') }}" placeholder="Ingrese la UR" required>
                                    @error('ur')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Segundo Row -->
                        <div class="row">
                            <!-- Departamento -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="departamento">Departamento</label>
                                    <input type="text" name="departamento" id="departamento"
                                           class="form-control @error('departamento') is-invalid @enderror"
                                           value="{{ old('departamento') }}" placeholder="Ingrese el departamento" required>
                                    @error('departamento')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Partida -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="partida">Partida</label>
                                    <input type="text" name="partida" id="partida"
                                           class="form-control @error('partida') is-invalid @enderror"
                                           value="{{ old('partida') }}" placeholder="Ingrese la partida" required>
                                    @error('partida')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Producto o Material -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="producto_material">Producto o Material</label>
                                    <input type="text" name="producto_material" id="producto_material"
                                           class="form-control @error('producto_material') is-invalid @enderror"
                                           value="{{ old('producto_material') }}" placeholder="Ingrese el producto o material" required>
                                    @error('producto_material')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Cuarto Row -->
                        <div class="row">
                            <!-- Monto -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="monto">Monto</label>
                                    <input type="number" name="monto" id="monto"
                                           class="form-control @error('monto') is-invalid @enderror"
                                           value="{{ old('monto') }}" placeholder="Ingrese el monto" step="0.01" required>
                                    @error('monto')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Estado de la Requisición -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="status_requisicion">Estado de la Requisición</label>
                                    <select name="status_requisicion" id="status_requisicion"
                                            class="form-control @error('status_requisicion') is-invalid @enderror" required>
                                        <option value="" disabled selected>Seleccione un estado</option>
                                        <option value="Pedido" {{ old('status_requisicion') == 'Pedido' ? 'selected' : '' }}>Pedido</option>
                                        <option value="Entregado" {{ old('status_requisicion') == 'Entregado' ? 'selected' : '' }}>Entregado</option>
                                    </select>
                                    @error('status_requisicion')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                             <!-- Proveedor -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="proveedor">Proveedor</label>
                                    <div class="input-group">
                                        <select name="proveedor" id="proveedor" class="form-control @error('proveedor') is-invalid @enderror" required>
                                            <option value="" disabled selected>Seleccione un proveedor</option>
                                            @foreach ($proveedores as $proveedor)
                                                <option value="{{ $proveedor->nombre }}" {{ old('proveedor') == $proveedor->nombre ? 'selected' : '' }}>
                                                    {{ $proveedor->nombre }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div class="input-group-append">
                                            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#addProveedorModal">
                                                <i class="fa-solid fa-plus"></i> Nuevo
                                            </button>
                                        </div>
                                    </div>
                                    @error('proveedor')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Justificación -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="justificacion">Justificación</label>
                                    <textarea name="justificacion" id="justificacion"
                                              class="form-control @error('justificacion') is-invalid @enderror"
                                              rows="4" placeholder="Ingrese la justificación">{{ old('justificacion') }}</textarea>
                                    @error('justificacion')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Botones del Formulario Principal -->
                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group text-center">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa-solid fa-check"></i> Registrar
                                    </button>
                                    <a href="{{ route('requisiciones.index') }}" class="btn btn-secondary">
                                        <i class="fa-solid fa-ban"></i> Cancelar
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                    <!-- Fin del Formulario Principal -->
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
