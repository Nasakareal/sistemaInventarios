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
                        <th><center>#</center></th>
                        <th><center>Número de Requisición</center></th>
                        <th><center>Monto</center></th>
                        <th><center>Cuenta Bancaria</center></th>
                        <th><center>Fecha</center></th>
                        <th><center>Acciones</center></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($requisiciones as $index => $req)
                        <tr>
                            <td style="text-align: center;">{{ $index + 1 }}</td>
                            <td>{{ $req->numero_requisicion }}</td>
                            <td>${{ number_format($req->monto, 2) }}</td>
                            <td>{{ optional($req->cuentaBancaria)->nombre ?? 'N/A' }}</td>
                            <td>
                                {{ $req->created_at ? $req->created_at->format('d-m-Y') : 'Sin fecha' }}
                            </td>
                            <td style="text-align: center;">
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
        .table th, .table td {
            text-align: center;
            vertical-align: middle;
        }
    </style>
@stop

@section('js')
    <script>
        $(function () {
            $('#requisiciones_table').DataTable({
                "pageLength": 10,
                "language": {
                    "emptyTable": "No hay información",
                    "info": "Mostrando _START_ a _END_ de _TOTAL_ requisiciones",
                    "infoEmpty": "Mostrando 0 a 0 de 0 requisiciones",
                    "infoFiltered": "(Filtrado de _MAX_ total requisiciones)",
                    "lengthMenu": "Mostrar _MENU_ requisiciones",
                    "loadingRecords": "Cargando...",
                    "processing": "Procesando...",
                    "search": "Buscador:",
                    "zeroRecords": "Sin resultados encontrados",
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
                            { extend: 'copy', text: 'Copiar' },
                            { extend: 'pdf', text: 'PDF' },
                            { extend: 'csv', text: 'CSV' },
                            { extend: 'excel', text: 'Excel' },
                            { extend: 'print', text: 'Imprimir' }
                        ]
                    },
                    { extend: 'colvis', text: 'Visor de columnas' }
                ],
            }).buttons().container().appendTo('#requisiciones_table_wrapper .col-md-6:eq(0)');
        });

        @if (session('success'))
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 15000
            });
        @endif

        $(document).on('click', '.delete-btn', function (e) {
            e.preventDefault();
            let form = $(this).closest('form');
            Swal.fire({
                title: '¿Estás seguro de eliminar esta requisición?',
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
