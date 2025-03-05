@extends('adminlte::page')

@section('title', 'Listado de Artículos en Almacén')

@section('content_header')
    <h1>Listado de Artículos en Almacén</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">Artículos Registrados</h3>
                    <div class="card-tools">
                        <a href="{{ route('almacen.create') }}" class="btn btn-primary">
                            <i class="fa-solid fa-plus"></i> Agregar Artículo
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <table id="almacen" class="table table-striped table-bordered table-hover table-sm">
                        <thead>
                            <tr>
                                <th><center>Número</center></th>
                                <th><center>Tipo</center></th>
                                <th><center>Fecha de Compra</center></th>
                                <th><center>Proveedor</center></th>
                                <th><center>Fecha de Entrada</center></th>
                                <th><center>Recibido Por</center></th>
                                <th><center>Stock</center></th>
                                <th><center>Departamento</center></th>
                                <th><center>Acciones</center></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($almacenes as $index => $almacen)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ ucfirst($almacen->tipo) }}</td>
                                    <td>{{ $almacen->fecha_compra ?? 'No registrada' }}</td>
                                    <td>{{ $almacen->nombre_proveedor ?? 'No especificado' }}</td>
                                    <td>{{ $almacen->fecha_entrada ?? 'No registrada' }}</td>
                                    <td>{{ $almacen->recibido_por ?? 'No especificado' }}</td>
                                    <td>{{ $almacen->stock }}</td>
                                    <td>{{ $almacen->departamento }}</td>
                                    <td style="text-align: center">
                                        <a href="{{ route('almacen.show', $almacen->id) }}" class="btn btn-info btn-sm">
                                            <i class="fa-regular fa-eye"></i> Ver
                                        </a>
                                        <a href="{{ route('almacen.edit', $almacen->id) }}" class="btn btn-success btn-sm">
                                            <i class="fa-solid fa-pencil"></i> Editar
                                        </a>
                                        <form action="{{ route('almacen.destroy', $almacen->id) }}" method="POST" style="display: inline-block;">
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
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
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
            $('#almacen').DataTable({ // Cambiar el selector '#almacen' al id de la tabla.
                "dom": '<"row"<"col-sm-6"l><"col-sm-6"Bf>>rtip',
                "pageLength": 10,
                "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Todos"]],
                "language": {
                    "emptyTable": "No hay información disponible",
                    "info": "Mostrando _START_ a _END_ de _TOTAL_ almacen",  // Mensaje de información.
                    "infoEmpty": "Mostrando 0 a 0 de 0 almacen",
                    "infoFiltered": "(filtrado de _MAX_ almacen en total)",  // Mensaje de información.
                    "lengthMenu": "Mostrar _MENU_ almacen",  // Mensaje de información.
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
    </script>
@stop
