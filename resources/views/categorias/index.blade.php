@extends('adminlte::page')

@section('title', 'Listado de Categorías')

@section('content_header')
    <h1>Listado de Categorías</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">Categorías Registradas</h3>
                    <div class="card-tools">
                        <a href="{{ route('categorias.create') }}" class="btn btn-primary">
                            <i class="fa-solid fa-plus"></i> Crear Nueva Categoría
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <table id="categorias_table" class="table table-striped table-bordered table-hover table-sm">
                        <thead>
                            <tr>
                                <th><center>Número</center></th>
                                <th><center>Nombre</center></th>
                                <th><center>Descripción</center></th>
                                <th><center>Fecha de Creación</center></th>
                                <th><center>Acciones</center></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($categorias as $index => $categoria)
                                <tr>
                                    <td style="text-align: center">{{ $index + 1 }}</td>
                                    <td>{{ $categoria->nombre }}</td>
                                    <td>{{ $categoria->descripcion ?? 'Sin descripción' }}</td>
                                    <td>{{ $categoria->created_at ? $categoria->created_at->format('d-m-Y') : 'Sin fecha' }}</td>
                                    <td style="text-align: center">
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('categorias.show', $categoria->id) }}" class="btn btn-info btn-sm">
                                                <i class="fa-regular fa-eye"></i> Ver
                                            </a>
                                            <a href="{{ route('categorias.edit', $categoria->id) }}" class="btn btn-success btn-sm">
                                                <i class="fa-regular fa-pen-to-square"></i> Editar
                                            </a>
                                            {{-- Formulario de Eliminar --}}
                                            <form action="{{ route('categorias.destroy', $categoria->id) }}" 
                                                  method="POST" style="display:inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-danger btn-sm delete-btn">
                                                    <i class="fa-regular fa-trash-can"></i> Eliminar
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
            $('#categorias_table').DataTable({
                "pageLength": 5,
                "language": {
                    "emptyTable": "No hay información",
                    "info": "Mostrando _START_ a _END_ de _TOTAL_ Categorías",
                    "infoEmpty": "Mostrando 0 a 0 de 0 Categorías",
                    "infoFiltered": "(Filtrado de _MAX_ total Categorías)",
                    "lengthMenu": "Mostrar _MENU_ Categorías",
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
            }).buttons().container().appendTo('#categorias_table_wrapper .col-md-6:eq(0)');
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
                title: '¿Estás seguro de eliminar esta categoría?',
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
