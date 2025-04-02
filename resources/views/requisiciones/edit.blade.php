@extends('adminlte::page')

@section('title')
    @if($requisicion->cuentaBancaria)
        Editar Requisición: {{ $requisicion->cuentaBancaria->nombre }}
    @else
        Editar Requisición
    @endif
@stop

@section('content_header')
    @if($requisicion->cuentaBancaria)
        <h1>Edición de la Requisición: {{ $requisicion->cuentaBancaria->nombre }}</h1>
    @else
        <h1>Edición de la Requisición</h1>
    @endif
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">Actualice los Datos</h3>
                </div>
                <div class="card-body">
                    <!-- Formulario Principal de Edición -->
                    <form action="{{ route('requisiciones.update', $requisicion->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        {{-- 
                            Si ya existe una cuenta bancaria asociada, la mantenemos con campos ocultos.
                            Si no existe, permitimos seleccionar una cuenta.
                        --}}
                        @if($requisicion->cuentaBancaria)
                            <input type="hidden" name="cuenta_bancaria_id" value="{{ $requisicion->cuentaBancaria->id }}">
                            <input type="hidden" name="banco" value="{{ $requisicion->cuentaBancaria->nombre }}">
                        @else
                            <div class="form-group">
                                <label>Cuenta Bancaria</label>
                                <select name="cuenta_bancaria_id"
                                        class="form-control @error('cuenta_bancaria_id') is-invalid @enderror"
                                        required>
                                    <option value="" disabled selected>Seleccione la cuenta</option>
                                    @foreach($cuentas as $c)
                                        <option value="{{ $c->id }}"
                                            {{ old('cuenta_bancaria_id', $requisicion->cuenta_bancaria_id) == $c->id ? 'selected' : '' }}>
                                            {{ $c->nombre }} ({{ $c->numero }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('cuenta_bancaria_id')
                                    <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        @endif

                        <!-- Número de Requisición, UR, Departamento, Partida -->
                        <div class="row">
                            <!-- Número de Requisición -->
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="numero_requisicion">Número de Requisición</label>
                                    <input type="text"
                                           name="numero_requisicion"
                                           id="numero_requisicion"
                                           class="form-control @error('numero_requisicion') is-invalid @enderror"
                                           value="{{ old('numero_requisicion', $requisicion->numero_requisicion) }}"
                                           placeholder="Ingrese el número de requisición"
                                           required>
                                    @error('numero_requisicion')
                                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Unidad Responsable (UR) -->
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="ur">Unidad Responsable (UR)</label>
                                    <input type="text"
                                           name="ur"
                                           id="ur"
                                           class="form-control @error('ur') is-invalid @enderror"
                                           value="{{ old('ur', $requisicion->ur) }}"
                                           placeholder="Ingrese la UR"
                                           required>
                                    @error('ur')
                                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Departamento -->
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="departamento">Departamento</label>
                                    <input type="text"
                                           name="departamento"
                                           id="departamento"
                                           class="form-control @error('departamento') is-invalid @enderror"
                                           value="{{ old('departamento', $requisicion->departamento) }}"
                                           placeholder="Ingrese el departamento"
                                           required>
                                    @error('departamento')
                                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Partida -->
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="partida">Partida</label>
                                    <input type="text"
                                           name="partida"
                                           id="partida"
                                           class="form-control @error('partida') is-invalid @enderror"
                                           value="{{ old('partida', $requisicion->partida) }}"
                                           placeholder="Ingrese la partida"
                                           required>
                                    @error('partida')
                                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Fecha Entrega RF, Fecha Pago, Fecha Requisición, Mes -->
                        <div class="row">
                            <!-- Fecha de Entrega a Recursos Financieros -->
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="fecha_entrega_rf">Fecha de Entrega a RF</label>
                                    <input type="date"
                                           name="fecha_entrega_rf"
                                           id="fecha_entrega_rf"
                                           class="form-control @error('fecha_entrega_rf') is-invalid @enderror"
                                           value="{{ old('fecha_entrega_rf', optional($requisicion->fecha_entrega_rf)->format('Y-m-d')) }}">
                                    @error('fecha_entrega_rf')
                                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Fecha de Pago -->
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="fecha_pago">Fecha de Pago</label>
                                    <input type="date"
                                           name="fecha_pago"
                                           id="fecha_pago"
                                           class="form-control @error('fecha_pago') is-invalid @enderror"
                                           value="{{ old('fecha_pago', optional($requisicion->fecha_pago)->format('Y-m-d')) }}">
                                    @error('fecha_pago')
                                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Fecha de Requisición -->
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="fecha_requisicion">Fecha de Requisición</label>
                                    <input type="date"
                                           name="fecha_requisicion"
                                           id="fecha_requisicion"
                                           class="form-control @error('fecha_requisicion') is-invalid @enderror"
                                           value="{{ old('fecha_requisicion', optional($requisicion->fecha_requisicion)->format('Y-m-d')) }}"
                                           required>
                                    @error('fecha_requisicion')
                                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Mes -->
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="mes">Mes</label>
                                    <select name="mes"
                                            id="mes"
                                            class="form-control @error('mes') is-invalid @enderror">
                                        <option value="" disabled>Seleccione el mes</option>
                                        @foreach(['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'] as $opMes)
                                            <option value="{{ $opMes }}"
                                                {{ old('mes', $requisicion->mes) == $opMes ? 'selected' : '' }}>
                                                {{ $opMes }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('mes')
                                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Producto o Material, Monto, Status Requisición, Número Factura -->
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="producto_material">Producto o Material</label>
                                    <input type="text"
                                           name="producto_material"
                                           id="producto_material"
                                           class="form-control @error('producto_material') is-invalid @enderror"
                                           value="{{ old('producto_material', $requisicion->producto_material) }}"
                                           placeholder="Ingrese el producto o material"
                                           required>
                                    @error('producto_material')
                                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="monto">Monto</label>
                                    <input type="number"
                                           name="monto"
                                           id="monto"
                                           class="form-control @error('monto') is-invalid @enderror"
                                           value="{{ old('monto', $requisicion->monto) }}"
                                           placeholder="Ingrese el monto"
                                           step="0.01"
                                           required>
                                    @error('monto')
                                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="status_requisicion">Estado de la Requisición</label>
                                    <select name="status_requisicion"
                                            id="status_requisicion"
                                            class="form-control @error('status_requisicion') is-invalid @enderror"
                                            required>
                                        <option value="" disabled>Seleccione un estado</option>
                                        <option value="Pedido"
                                            {{ old('status_requisicion', $requisicion->status_requisicion) == 'Pedido' ? 'selected' : '' }}>
                                            Pedido
                                        </option>
                                        <option value="Entregado"
                                            {{ old('status_requisicion', $requisicion->status_requisicion) == 'Entregado' ? 'selected' : '' }}>
                                            Entregado
                                        </option>
                                    </select>
                                    @error('status_requisicion')
                                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="numero_factura">Número de Factura</label>
                                    <input type="text"
                                           name="numero_factura"
                                           id="numero_factura"
                                           class="form-control @error('numero_factura') is-invalid @enderror"
                                           value="{{ old('numero_factura', $requisicion->numero_factura) }}"
                                           placeholder="Ingrese el número de factura">
                                    @error('numero_factura')
                                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Proveedor, Turnado a, Pago, Estado Pago -->
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="proveedor">Proveedor</label>
                                    <div class="input-group">
                                        <select name="proveedor"
                                                id="proveedor"
                                                class="form-control @error('proveedor') is-invalid @enderror"
                                                required>
                                            <option value="" disabled>Seleccione un proveedor</option>
                                            @foreach ($proveedores as $p)
                                                <option value="{{ $p->nombre }}"
                                                    {{ old('proveedor', $requisicion->proveedor) == $p->nombre ? 'selected' : '' }}>
                                                    {{ $p->nombre }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div class="input-group-append">
                                            <a href="{{ route('proveedores.create') }}" class="btn btn-success">
                                                <i class="fa-solid fa-plus"></i> Nuevo
                                            </a>
                                        </div>
                                    </div>
                                    @error('proveedor')
                                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="turnado_a">Turnado a</label>
                                    <input type="text"
                                           name="turnado_a"
                                           id="turnado_a"
                                           class="form-control @error('turnado_a') is-invalid @enderror"
                                           value="{{ old('turnado_a', $requisicion->turnado_a) }}"
                                           placeholder="¿A quién se turna?">
                                    @error('turnado_a')
                                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="pago">Pago</label>
                                    <input type="text"
                                           name="pago"
                                           id="pago"
                                           class="form-control @error('pago') is-invalid @enderror"
                                           value="{{ old('pago', $requisicion->pago) }}"
                                           placeholder="Ingrese el pago">
                                    @error('pago')
                                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="status_pago">Estado de Pago</label>
                                    <select name="status_pago"
                                            id="status_pago"
                                            class="form-control @error('status_pago') is-invalid @enderror"
                                            required>
                                        <option value="Pendiente"
                                            {{ old('status_pago', $requisicion->status_pago) == 'Pendiente' ? 'selected' : '' }}>
                                            Pendiente
                                        </option>
                                        <option value="Pagado"
                                            {{ old('status_pago', $requisicion->status_pago) == 'Pagado' ? 'selected' : '' }}>
                                            Pagado
                                        </option>
                                    </select>
                                    @error('status_pago')
                                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Justificación, Observaciones, Referencia -->
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="justificacion">Justificación</label>
                                    <textarea name="justificacion"
                                              id="justificacion"
                                              class="form-control @error('justificacion') is-invalid @enderror"
                                              rows="4"
                                              placeholder="Ingrese la justificación">{{ old('justificacion', $requisicion->justificacion) }}</textarea>
                                    @error('justificacion')
                                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="observaciones">Observaciones</label>
                                    <textarea name="observaciones"
                                              id="observaciones"
                                              class="form-control @error('observaciones') is-invalid @enderror"
                                              rows="4"
                                              placeholder="Ingrese observaciones">{{ old('observaciones', $requisicion->observaciones) }}</textarea>
                                    @error('observaciones')
                                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="referencia">Referencia</label>
                                    <textarea name="referencia"
                                              id="referencia"
                                              class="form-control @error('referencia') is-invalid @enderror"
                                              rows="2"
                                              placeholder="Ingrese la referencia">{{ old('referencia', $requisicion->referencia) }}</textarea>
                                    @error('referencia')
                                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Botones de acción -->
                        <hr>
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa-solid fa-check"></i> Actualizar
                                </button>
                                <a href="{{ route('requisiciones.index') }}" class="btn btn-secondary">
                                    <i class="fa-solid fa-ban"></i> Cancelar
                                </a>
                            </div>
                        </div>
                    </form>
                    <!-- Fin del Formulario de Edición -->
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
