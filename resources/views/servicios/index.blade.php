@extends('adminlte::page')

@section('title', 'Listado de Servicios de Mantenimiento')

@section('content_header')
    <h1>Listado de Servicios de Mantenimiento</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">Servicios Registrados</h3>
                    <div class="card-tools">
                        <a href="{{ route('servicios.create') }}" class="btn btn-primary">
                            <i class="fa-solid fa-plus"></i> Registrar Servicio
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <!-- Filtros -->
                    <form method="GET" action="{{ route('servicios.index') }}">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="nombre">Buscar Servicio:</label>
                                <input type="text" class="form-control" name="nombre" placeholder="Ingrese nombre del servicio" value="{{ request('nombre') }}">
                            </div>
                            <div class="col-md-6">
                                <label for="proxima_realizacion">Próxima Ejecución:</label>
                                <input type="date" class="form-control" name="proxima_realizacion" value="{{ request('proxima_realizacion') }}">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Filtrar</button>
                        <a href="{{ route('servicios.index') }}" class="btn btn-secondary">Limpiar</a>
                    </form>

                    <table id="servicios" class="table table-striped table-bordered table-hover table-sm">
                        <thead>
                            <tr>
                                <th><center>#</center></th>
                                <th><center>Servicio</center></th>
                                <th><center>Descripción</center></th>
                                <th><center>Frecuencia (Semanas)</center></th>
                                <th><center>Última Realización</center></th>
                                <th><center>Próxima Realización</center></th>
                                <th><center>Acciones</center></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($servicios as $index => $servicio)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $servicio->nombre }}</td>
                                    <td>{{ $servicio->descripcion ?? 'No especificada' }}</td>
                                    <td>{{ $servicio->frecuencia_semanas }}</td>
                                    <td>{{ $servicio->ultima_realizacion_formatted }}</td>
                                    <td>
                                        @if (strtotime($servicio->proxima_realizacion) < strtotime(now()))
                                            <span class="badge badge-danger">{{ $servicio->proxima_realizacion_formatted }} (VENCIDO)</span>
                                        @elseif (strtotime($servicio->proxima_realizacion) <= strtotime('+7 days'))
                                            <span class="badge badge-warning">{{ $servicio->proxima_realizacion_formatted }} (PRONTO)</span>
                                        @else
                                            <span class="badge badge-success">{{ $servicio->proxima_realizacion_formatted }}</span>
                                        @endif
                                    </td>
                                    <td style="text-align: center">
                                        <a href="{{ route('servicios.show', $servicio->id) }}" class="btn btn-info btn-sm">
                                            <i class="fa-regular fa-eye"></i> Ver
                                        </a>
                                        <a href="{{ route('servicios.edit', $servicio->id) }}" class="btn btn-success btn-sm">
                                            <i class="fa-solid fa-pencil"></i> Editar
                                        </a>
                                        <form action="{{ route('servicios.destroy', $servicio->id) }}" method="POST" style="display: inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-danger btn-sm delete-btn">
                                                <i class="fa-regular fa-trash-can"></i> Eliminar
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
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
            $('#servicios').DataTable({
                "pageLength": 5,
                "language": {
                    "emptyTable": "No hay información disponible",
                    "info": "Mostrando _START_ a _END_ de _TOTAL_ servicios",
                    "infoEmpty": "Mostrando 0 a 0 de 0 servicios",
                    "infoFiltered": "(filtrado de _MAX_ servicios en total)",
                    "lengthMenu": "Mostrar _MENU_ servicios",
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
                            { extend: 'copy', text: 'Copiar' },
                            { extend: 'pdf', text: 'PDF' },
                            { extend: 'csv', text: 'CSV' },
                            { extend: 'excel', text: 'Excel' },
                            { extend: 'print', text: 'Imprimir' }
                        ]
                    },
                    { extend: 'colvis', text: 'Visor de columnas' }
                ],
            }).buttons().container().appendTo('#servicios_wrapper .col-md-6:eq(0)');
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
    </script>
@stop
