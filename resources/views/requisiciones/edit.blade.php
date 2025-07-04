@extends('adminlte::page')

@section('title', 'Editar Requisición: ' . $requisicion->numero_requisicion)

@section('content_header')
    <h1>Edición de Requisición #{{ $requisicion->numero_requisicion }}</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline card-success">
                <div class="card-header">
                    <h3 class="card-title">Actualice los Datos</h3>
                </div>

                <div class="card-body">
                    <form action="{{ route('requisiciones.update', $requisicion->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        {{-- Cuenta bancaria (editable) --}}
                        <div class="form-group">
                            <label>Cuenta Bancaria</label>
                            <select name="cuenta_bancaria_id"
                                    class="form-control @error('cuenta_bancaria_id') is-invalid @enderror"
                                    required>
                                <option value="" disabled>Seleccione la cuenta</option>
                                @foreach ($cuentas as $c)
                                    <option value="{{ $c->id }}"
                                        {{ old('cuenta_bancaria_id', $requisicion->cuenta_bancaria_id) == $c->id ? 'selected' : '' }}>
                                        {{ $c->nombre }} ({{ $c->numero }})
                                    </option>
                                @endforeach
                            </select>
                            @error('cuenta_bancaria_id')
                                <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                            @enderror

                            @php
                                $cuentaSeleccionada = $cuentas->firstWhere('id', old('cuenta_bancaria_id', $requisicion->cuenta_bancaria_id));
                            @endphp

                            @if($cuentaSeleccionada)
                                <div class="alert alert-info mt-2">
                                    Saldo actual en <strong>{{ $cuentaSeleccionada->nombre }}</strong>: 
                                    <strong>${{ number_format($cuentaSeleccionada->saldo, 2) }}</strong>
                                </div>
                            @endif

                        </div>

                        <!-- Número Req. / UR / Depto / Capítulo -->
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="numero_requisicion">Número de Requisición</label>
                                    <input type="text" name="numero_requisicion" id="numero_requisicion"
                                           class="form-control @error('numero_requisicion') is-invalid @enderror"
                                           value="{{ old('numero_requisicion', $requisicion->numero_requisicion) }}" required>
                                    @error('numero_requisicion')
                                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="ur">Unidad Responsable (UR)</label>
                                    <input type="text" name="ur" id="ur"
                                           class="form-control @error('ur') is-invalid @enderror"
                                           value="{{ old('ur', $requisicion->ur) }}" required>
                                    @error('ur')
                                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="departamento">Departamento</label>
                                    <input type="text" name="departamento" id="departamento"
                                           class="form-control @error('departamento') is-invalid @enderror"
                                           value="{{ old('departamento', $requisicion->departamento) }}" required>
                                    @error('departamento')
                                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="capitulo">Capítulo</label>
                                    <select id="capitulo" class="form-control">
                                        <option value="">Seleccione un capítulo</option>
                                        @foreach([10000,20000,30000,40000,50000,60000,70000,80000,90000] as $cap)
                                            <option value="{{ $cap }}"
                                                {{ substr($requisicion->partida,0,1).'0000' == $cap ? 'selected' : '' }}>
                                                {{ $cap }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Partida / Partida2 / Oficio Pago -->
                        <div class="row">
                            <!-- Partida -->
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="partida">Partida</label>
                                    <select name="partida" id="partida"
                                            class="form-control @error('partida') is-invalid @enderror" required>
                                        <option value="{{ $requisicion->partida }}" selected>
                                            {{ $requisicion->partida }}
                                        </option>
                                    </select>
                                    @error('partida')
                                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Partida2 -->
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="partida2">Segunda Partida (opcional)</label>
                                    <select name="partida2" id="partida2"
                                            class="form-control @error('partida2') is-invalid @enderror">
                                        @if ($requisicion->partida2)
                                            <option value="{{ $requisicion->partida2 }}" selected>
                                                {{ $requisicion->partida2 }}
                                            </option>
                                        @else
                                            <option value="">Seleccione una segunda partida</option>
                                        @endif
                                    </select>
                                    @error('partida2')
                                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Oficio Pago -->
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="oficio_pago">Oficio Pago</label>
                                    <input type="text" name="oficio_pago" id="oficio_pago"
                                           class="form-control @error('oficio_pago') is-invalid @enderror"
                                           value="{{ old('oficio_pago', $requisicion->oficio_pago) }}" required>
                                    @error('oficio_pago')
                                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>
                        </div>


                            <!-- Fecha oficio Pago -->
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="fecha_oficio_pago">Fecha de Oficio de Pago</label>
                                    <input type="date" name="fecha_oficio_pago" id="fecha_oficio_pago"
                                           class="form-control @error('fecha_oficio_pago') is-invalid @enderror"
                                           value="{{ old('fecha_oficio_pago', $requisicion->fecha_oficio_pago ? \Carbon\Carbon::parse($requisicion->fecha_oficio_pago)->format('Y-m-d') : '') }}">
                                    @error('fecha_oficio_pago')
                                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>

                        </div>

                        <!-- Fechas / Mes -->
                        <div class="row">
                            @php
                                $f = fn($campo) => old($campo, optional($requisicion->$campo)->format('Y-m-d'));
                            @endphp
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="fecha_entrega_rf">Fecha de Entrega a RF</label>
                                    <input type="date" name="fecha_entrega_rf" id="fecha_entrega_rf"
                                           class="form-control @error('fecha_entrega_rf') is-invalid @enderror"
                                           value="{{ $f('fecha_entrega_rf') }}">
                                    @error('fecha_entrega_rf')
                                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="fecha_pago">Fecha de Pago</label>
                                    <input type="date" name="fecha_pago" id="fecha_pago"
                                           class="form-control @error('fecha_pago') is-invalid @enderror"
                                           value="{{ $f('fecha_pago') }}">
                                    @error('fecha_pago')
                                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="fecha_requisicion">Fecha de Requisición</label>
                                    <input type="date" name="fecha_requisicion" id="fecha_requisicion"
                                           class="form-control @error('fecha_requisicion') is-invalid @enderror"
                                           value="{{ $f('fecha_requisicion') }}" required>
                                    @error('fecha_requisicion')
                                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="mes">Mes</label>
                                    <select name="mes" id="mes"
                                            class="form-control @error('mes') is-invalid @enderror">
                                        <option value="" disabled>Seleccione el mes</option>
                                        @foreach (['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'] as $m)
                                            <option value="{{ $m }}"
                                                {{ old('mes', $requisicion->mes) == $m ? 'selected' : '' }}>
                                                {{ $m }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('mes')
                                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Producto / Monto / Estado / Factura -->
                        <div class="row">
                            <div class="col-md-3">
                                <label for="producto_material">Producto o Material</label>
                                <input type="text" name="producto_material" id="producto_material"
                                       class="form-control @error('producto_material') is-invalid @enderror"
                                       value="{{ old('producto_material', $requisicion->producto_material) }}" required>
                                @error('producto_material')
                                    <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            <div class="col-md-3">
                                <label for="monto">Monto</label>
                                <input type="number" step="0.01" name="monto" id="monto"
                                       class="form-control @error('monto') is-invalid @enderror"
                                       value="{{ old('monto', $requisicion->monto) }}" required>
                                @error('monto')
                                    <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            <div class="col-md-3">
                                <label for="status_requisicion">Estado de la Requisición</label>
                                <select name="status_requisicion" id="status_requisicion"
                                        class="form-control @error('status_requisicion') is-invalid @enderror" required>
                                    <option value="Pedido" {{ old('status_requisicion', $requisicion->status_requisicion) == 'Pedido' ? 'selected' : '' }}>Pedido</option>
                                    <option value="Entregado" {{ old('status_requisicion', $requisicion->status_requisicion) == 'Entregado' ? 'selected' : '' }}>Entregado</option>
                                </select>
                                @error('status_requisicion')
                                    <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            <div class="col-md-3">
                                <label for="numero_factura">Número de Factura</label>
                                <input type="text" name="numero_factura" id="numero_factura"
                                       class="form-control @error('numero_factura') is-invalid @enderror"
                                       value="{{ old('numero_factura', $requisicion->numero_factura) }}">
                                @error('numero_factura')
                                    <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        </div>

                        <!-- Proveedor / Turnado / Pago / Status pago -->
                        <div class="row">
                            <div class="col-md-3">
                                <label for="proveedor">Proveedor</label>
                                <select name="proveedor" id="proveedor"
                                        class="form-control @error('proveedor') is-invalid @enderror" required>
                                    <option value="" disabled>Seleccione un proveedor</option>
                                    @foreach ($proveedores as $p)
                                        <option value="{{ $p->nombre }}"
                                            {{ old('proveedor', $requisicion->proveedor) == $p->nombre ? 'selected' : '' }}>
                                            {{ $p->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('proveedor')
                                    <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            <div class="col-md-3">
                                <label for="turnado_a">Turnado a</label>
                                <input type="text" name="turnado_a" id="turnado_a"
                                       class="form-control @error('turnado_a') is-invalid @enderror"
                                       value="{{ old('turnado_a', $requisicion->turnado_a) }}">
                                @error('turnado_a')
                                    <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            <div class="col-md-3">
                                <label for="pago">Pago</label>
                                <input type="text" name="pago" id="pago"
                                       class="form-control @error('pago') is-invalid @enderror"
                                       value="{{ old('pago', $requisicion->pago) }}">
                                @error('pago')
                                    <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            <div class="col-md-3">
                                <label for="status_pago">Estado de Pago</label>
                                <select name="status_pago" id="status_pago"
                                        class="form-control @error('status_pago') is-invalid @enderror" required>
                                    <option value="Pendiente" {{ old('status_pago', $requisicion->status_pago) == 'Pendiente' ? 'selected' : '' }}>Pendiente</option>
                                    <option value="Pagado" {{ old('status_pago', $requisicion->status_pago) == 'Pagado' ? 'selected' : '' }}>Pagado</option>
                                </select>
                                @error('status_pago')
                                    <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        </div>

                        <!-- Justificación / Observaciones / Referencia -->
                        <div class="row">
                            <div class="col-md-4">
                                <label for="justificacion">Justificación</label>
                                <textarea name="justificacion" id="justificacion" rows="4"
                                          class="form-control @error('justificacion') is-invalid @enderror">{{ old('justificacion', $requisicion->justificacion) }}</textarea>
                                @error('justificacion')
                                    <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="observaciones">Observaciones</label>
                                <textarea name="observaciones" id="observaciones" rows="4"
                                          class="form-control @error('observaciones') is-invalid @enderror">{{ old('observaciones', $requisicion->observaciones) }}</textarea>
                                @error('observaciones')
                                    <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="referencia">Referencia</label>
                                <textarea name="referencia" id="referencia" rows="2"
                                          class="form-control @error('referencia') is-invalid @enderror">{{ old('referencia', $requisicion->referencia) }}</textarea>
                                @error('referencia')
                                    <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        </div>

                        <hr>
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <button type="submit" class="btn btn-success">
                                    <i class="fa-solid fa-save"></i> Actualizar
                                </button>
                                <a href="{{ route('requisiciones.index') }}" class="btn btn-secondary">
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

<script>
document.addEventListener('DOMContentLoaded', function () {
    const cuentaSelect = document.querySelector('select[name="cuenta_bancaria_id"]');

    cuentaSelect.addEventListener('change', function () {
        const cuentaId = this.value;

        fetch(`{{ url('cuentas') }}/${cuentaId}/saldo`, {
            credentials: 'same-origin'
        })
        .then(response => {
            if (!response.ok) throw new Error('No se pudo cargar la cuenta');
            return response.json();
        })
        .then(data => {
            const existingAlert = document.getElementById('alert-saldo');
            if (existingAlert) existingAlert.remove();

            const newAlert = document.createElement('div');
            newAlert.className = 'alert alert-info mt-2';
            newAlert.id = 'alert-saldo';
            newAlert.innerHTML = `
                Saldo actual en <strong>${data.nombre}</strong>: 
                <strong>$${parseFloat(data.saldo).toFixed(2)}</strong>
            `;
            cuentaSelect.parentElement.appendChild(newAlert);
        })
        .catch(err => {
            console.error('Error al obtener saldo:', err);
            alert('Error al cargar el saldo de la cuenta bancaria.');
        });
    });
});
</script>





    <script>
document.addEventListener('DOMContentLoaded', function () {
    const capituloSelect = document.getElementById('capitulo');
    const partidaSelect = document.getElementById('partida');
    const partida2Select = document.getElementById('partida2');

    // Obtenemos los valores actuales desde el servidor (si existen)
    const partidaActual = '{{ $requisicion->partida }}';
    const partida2Actual = '{{ $requisicion->partida2 }}';

    capituloSelect.addEventListener('change', function () {
        const capitulo = this.value;
        if (!capitulo) {
            partidaSelect.innerHTML = '<option value="">Seleccione una partida</option>';
            partida2Select.innerHTML = '<option value="">Seleccione una segunda partida</option>';
            return;
        }

        const url = `{{ url('/requisiciones/partidas-por-capitulo') }}/${capitulo}`;
        fetch(url)
            .then(response => {
                if (!response.ok) {
                    throw new Error('No se pudo cargar partidas');
                }
                return response.json();
            })
            .then(data => {
                partidaSelect.innerHTML = '<option value="">Seleccione una partida</option>';
                partida2Select.innerHTML = '<option value="">Seleccione una segunda partida</option>';

                data.forEach(partida => {
                    const clave = partida.clave;
                    const texto = `${partida.clave} - ${partida.descripcion}`;

                    const option1 = document.createElement('option');
                    option1.value = clave;
                    option1.textContent = texto;
                    if (clave === partidaActual) option1.selected = true;
                    partidaSelect.appendChild(option1);

                    const option2 = document.createElement('option');
                    option2.value = clave;
                    option2.textContent = texto;
                    if (clave === partida2Actual) option2.selected = true;
                    partida2Select.appendChild(option2);
                });
            })
            .catch(error => {
                console.error('Error al cargar partidas:', error);
                alert('Error al cargar partidas. Revisa la consola.');
            });
    });

    if (capituloSelect.value) {
        capituloSelect.dispatchEvent(new Event('change'));
    }
});
</script>


@stop
