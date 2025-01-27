@extends('adminlte::page')

@section('title', 'Listado de Proveedores')

@section('content_header')
    <h1>Listado de Proveedores</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">Proveedores Registrados</h3>
                    <div class="card-tools">
                        <a href="{{ url('/proveedores/create') }}" class="btn btn-primary">
                            <i class="fa-solid fa-plus"></i> Crear Nuevo Proveedor
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <table id="proveedores" class="table table-striped table-bordered table-hover table-sm">
                        <thead>
                            <tr>
                                <th><center>Número</center></th>
                                <th><center>Nombre del Proveedor</center></th>
                                <th><center>Contacto</center></th>
                                <th><center>Teléfono</center></th>
                                <th><center>Email</center></th>
                                <th><center>Dirección</center></th>
                                <th><center>Fecha de Creación</center></th>
                                <th><center>Acciones</center></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($proveedores as $index => $proveedor)
                                <tr>
                                    <td style="text-align: center">{{ $index + 1 }}</td>
                                    <td>{{ $proveedor->nombre }}</td>
                                    <td>{{ $proveedor->contacto ?? 'Sin contacto' }}</td>
                                    <td>{{ $proveedor->telefono ?? 'Sin teléfono' }}</td>
                                    <td>{{ $proveedor->email ?? 'Sin email' }}</td>
                                    <td>{{ $proveedor->direccion ?? 'Sin dirección' }}</td>
                                    <td>{{ $proveedor->created_at ? $proveedor->created_at->format('d-m-Y') : 'Sin fecha' }}</td>
                                    <td style="text-align: center">
                                        <div class="btn-group" role="group">
                                            <a href="{{ url('/proveedores/' . $proveedor->id) }}" class="btn btn-info btn-sm">
                                                <i class="fa-regular fa-eye"></i>
                                            </a>
                                            <a href="{{ url('/proveedores/' . $proveedor->id . '/edit') }}" class="btn btn-success btn-sm">
                                                <i class="fa-regular fa-pen-to-square"></i>
                                            </a>
                                            {{-- Formulario de Eliminar --}}
                                            <form action="{{ url('/proveedores/' . $proveedor->id) }}" 
                                                  method="POST" style="display:inline-block;">
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
            $('#proveedores').DataTable({
                "pageLength": 5,
                "language": {
                    "emptyTable": "No hay información",
                    "info": "Mostrando _START_ a _END_ de _TOTAL_ Proveedores",
                    "infoEmpty": "Mostrando 0 a 0 de 0 Proveedores",
                    "infoFiltered": "(Filtrado de _MAX_ total Proveedores)",
                    "lengthMenu": "Mostrar _MENU_ Proveedores",
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
            }).buttons().container().appendTo('#proveedores_wrapper .col-md-6:eq(0)');
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
                title: '¿Estás seguro de eliminar este proveedor?',
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
