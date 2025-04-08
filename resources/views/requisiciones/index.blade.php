@extends('adminlte::page')

@section('title', 'Listado de Requisiciones')

@section('content_header')
    <h1>Listado de Requisiciones</h1>
@stop

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">Requisiciones</h3>
            <div class="card-tools">
                <a href="{{ route('requisiciones.create') }}" class="btn btn-primary">
                    <i class="fa-solid fa-plus"></i> Crear Requisición
                </a>
            </div>
        </div>
        <div class="card-body">
            <!-- Filtro por Cuenta Bancaria -->
            <form method="GET" action="{{ route('requisiciones.index') }}" class="mb-3">
                <div class="row g-2 align-items-center">
                    <div class="col-auto">
                        <label for="cuenta_bancaria_id" class="col-form-label fw-bold">
                            Filtrar por cuenta bancaria:
                        </label>
                    </div>
                    <div class="col-auto">
                        <select name="cuenta_bancaria_id" id="cuenta_bancaria_id" class="form-select">
                            <option value="">Todas las cuentas</option>
                            @foreach($cuentas as $cuenta)
                                <option value="{{ $cuenta->id }}" 
                                    {{ request('cuenta_bancaria_id') == $cuenta->id ? 'selected' : '' }}>
                                    {{ $cuenta->nombre }} ({{ $cuenta->numero }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="btn btn-primary">Filtrar</button>
                    </div>
                </div>
            </form>

            <!-- Mostrar total de requisiciones -->
            <div class="alert alert-info">
                <strong>Total de requisiciones:</strong> {{ $totalRequisiciones }}
            </div>

            <!-- Tabla de Requisiciones -->
            <table id="requisiciones_table" class="table table-striped table-bordered table-hover table-sm">
                <thead>
                    <tr>
                        <!-- Columnas a exportar (se pueden ocultar las que no se quieren ver en pantalla) -->
                        <th class="d-none">ID</th>
                        <th>Fecha Requisición</th>
                        <th>Número de Requisición</th>
                        <th class="d-none">UR</th>
                        <th class="d-none">Departamento</th>
                        <th class="d-none">Partida</th>
                        <th class="d-none">Producto/Material</th>
                        <th class="d-none">Justificación</th>
                        <th class="d-none">Oficio Pago</th>
                        <th class="d-none">Número Factura</th>
                        <th class="d-none">Proveedor</th>
                        <th>Monto</th>
                        <th>Status Requisición</th>
                        <th>Turnado A</th>
                        <th class="d-none">Fecha Entrega RF</th>
                        <th class="d-none">Fecha Pago</th>
                        <th>Banco</th>
                        <th>Pago</th>
                        <th>Status Pago</th>
                        <th>Observaciones</th>
                        <th>Referencia</th>
                        <th>Mes</th>
                        <th>Cuenta Bancaria ID</th>
                        <th class="d-none">Created At</th>
                        <th class="d-none">Updated At</th>
                        <!-- Columna de Acciones: no se exporta -->
                        <th class="noExport">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($requisiciones as $req)
                        <tr>
                            <td class="d-none">{{ $req->id }}</td>
                            <td>{{ $req->fecha_requisicion ? \Carbon\Carbon::parse($req->fecha_requisicion)->format('d-m-Y') : '' }}</td>
                            <td>{{ $req->numero_requisicion }}</td>
                            <td class="d-none">{{ $req->ur }}</td>
                            <td class="d-none">{{ $req->departamento }}</td>
                            <td class="d-none">{{ $req->partida }}</td>
                            <td class="d-none">{{ $req->producto_material }}</td>
                            <td class="d-none">{{ $req->justificacion }}</td>
                            <td class="d-none">{{ $req->oficio_pago }}</td>
                            <td class="d-none">{{ $req->numero_factura }}</td>
                            <td class="d-none">{{ $req->proveedor }}</td>
                            <td>${{ number_format($req->monto, 2) }}</td>
                            <td>{{ $req->status_requisicion }}</td>
                            <td>{{ $req->turnado_a }}</td>
                            <td class="d-none">{{ $req->fecha_entrega_rf ? \Carbon\Carbon::parse($req->fecha_entrega_rf)->format('d-m-Y') : '' }}</td>
                            <td class="d-none">{{ $req->fecha_pago ? \Carbon\Carbon::parse($req->fecha_pago)->format('d-m-Y') : '' }}</td>
                            <td>{{ $req->banco }}</td>
                            <td>{{ $req->pago }}</td>
                            <td>{{ $req->status_pago }}</td>
                            <td>{{ $req->observaciones }}</td>
                            <td>{{ $req->referencia }}</td>
                            <td>{{ $req->mes }}</td>
                            <td>{{ $req->cuenta_bancaria_id }}</td>
                            <td class="d-none">{{ $req->created_at }}</td>
                            <td class="d-none">{{ $req->updated_at }}</td>
                            <td class="noExport">
                                <div class="btn-group" role="group">
                                    <a href="{{ route('requisiciones.show', $req->id) }}" class="btn btn-info btn-sm">
                                        <i class="fa-regular fa-eye"></i>
                                    </a>
                                    <a href="{{ route('requisiciones.edit', $req->id) }}" class="btn btn-success btn-sm">
                                        <i class="fa-regular fa-pen-to-square"></i>
                                    </a>
                                    <form action="{{ route('requisiciones.destroy', $req->id) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-danger btn-sm delete-btn">
                                            <i class="fa-regular fa-trash-can"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop

@section('css')
    <style>
        /* Esto oculta las columnas que tienen la clase d-none en la vista */
        .d-none { display: none !important; }
    </style>
@stop

@section('js')
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.colVis.min.js"></script>

    <script>
        $(document).ready(function () {
            $('#requisiciones_table').DataTable({
                "dom": '<"row"<"col-sm-6"l><"col-sm-6"Bf>>rtip',
                "pageLength": 10,
                "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Todos"]],
                "language": {
                    "emptyTable": "No hay información disponible",
                    "info": "Mostrando _START_ a _END_ de _TOTAL_ Requisiciones",
                    "infoEmpty": "Mostrando 0 a 0 de 0 Requisiciones",
                    "infoFiltered": "(filtrado de _MAX_ Requisiciones en total)",
                    "lengthMenu": "Mostrar _MENU_ Requisiciones",
                    "loadingRecords": "Cargando...",
                    "processing": "Procesando...",
                    "search": "Buscar:",
                    "zeroRecords": "No se encontraron resultados",
                    "paginate": {
                        "first": "Primero",
                        "last": "Último",
                        "next": "Siguiente",
                        "previous": "Anterior"
                    }
                },
                "responsive": true,
                "lengthChange": true,
                "autoWidth": false,
                "buttons": [
                    {
                        extend: 'collection',
                        text: 'Opciones',
                        buttons: [
                            {
                                extend: 'copy',
                                text: 'Copiar',
                                exportOptions: {
                                    columns: ':not(.noExport)'
                                }
                            },
                            {
                                extend: 'pdf',
                                text: 'PDF',
                                exportOptions: {
                                    columns: ':not(.noExport)'
                                }
                            },
                            {
                                extend: 'csv',
                                text: 'CSV',
                                exportOptions: {
                                    columns: ':not(.noExport)'
                                }
                            },
                            {
                                extend: 'excel',
                                text: 'Excel',
                                exportOptions: {
                                    columns: ':not(.noExport)'
                                }
                            },
                            {
                                extend: 'print',
                                text: 'Imprimir',
                                exportOptions: {
                                    columns: ':not(.noExport)'
                                }
                            }
                        ]
                    },
                    {
                        extend: 'colvis',
                        text: 'Visor de columnas'
                    }
                ]
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

        $(document).on('click', '.delete-btn', function (e) {
            e.preventDefault();
            var form = $(this).closest('form');
            Swal.fire({
                title: '¿Estás seguro de eliminar esta partida?',
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
    </script>
@stop
