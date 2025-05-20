@extends('adminlte::page')

@section('title', 'Listado de Productos')

@section('content_header')
    <h1>Listado de Productos</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">Productos</h3>
                    <div class="card-tools">
                        <a href="{{ url('productos/create') }}" class="btn btn-primary">
                            <i class="fa-solid fa-plus"></i> Añadir Inventario
                        </a>

                        <!-- BOTÓN DE IMPORTACIÓN -->
                        <a href="{{ route('productos.import.form') }}" class="btn btn-success">
                            <i class="fa-solid fa-file-import"></i> Importar CSV
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <!-- Filtros -->
                    <form method="GET" action="{{ route('productos.index') }}">
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="area">Área:</label>
                                <select class="form-control" name="area">
                                    <option value="">Todos</option>
                                    @foreach($areas as $area)
                                        <option value="{{ $area }}" {{ request('area') == $area ? 'selected' : '' }}>{{ $area }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="resguardante">resguardante</label>
                                <select class="form-control" name="resguardante">
                                    <option value="">Todos</option>
                                    @foreach($unidades as $resguardante)
                                        <option value="{{ $resguardante }}" {{ request('resguardante') == $resguardante ? 'selected' : '' }}>{{ $resguardante }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="partida">Partida:</label>
                                <select class="form-control" name="partida">
                                    <option value="">Todos</option>
                                    @foreach($partidas as $partida)
                                        <option value="{{ $partida }}" {{ request('partida') == $partida ? 'selected' : '' }}>{{ $partida }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="fecha_registro">Fecha de Registro:</label>
                                <input type="date" name="fecha_registro" id="fecha_registro" class="form-control"
                                       value="{{ request('fecha_registro') }}">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Filtrar</button>
                        <a href="{{ route('productos.index') }}" class="btn btn-secondary">Limpiar</a>
                    </form>

                    <table id="productos" class="table table-striped table-bordered table-hover table-sm">
                        <thead>
                            <tr>
                                <th><center>Número</center></th>
                                <th><center>Nombre del Producto</center></th>
                                <th><center>Categoría</center></th>
                                <th><center>Área</center></th>
                                <th><center>Resguardante</center></th>
                                <th><center>Observaciones</center></th>
                                <th><center>Precio</center></th>
                                <th><center>Acciones</center></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($productos as $index => $producto)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $producto->nombre }}</td>
                                    <td>{{ $producto->categoria->nombre ?? 'Sin categoría' }}</td>
                                    <td>{{ $producto->area ?? 'No especificado' }}</td>
                                    <td>{{ $producto->resguardante ?? 'No especificado' }}</td>
                                    <td>{{ $producto->obersvaciones ?? 'No especificado' }}</td>
                                    <td>${{ number_format($producto->precio_compra, 2) }}</td>
                                    <td style="text-align: center">
                                        <a href="{{ route('productos.show', $producto->id) }}" class="btn btn-info btn-sm">
                                            <i class="fa-regular fa-eye"></i> Ver
                                        </a>
                                        <a href="{{ route('productos.edit', $producto->id) }}" class="btn btn-success btn-sm">
                                            <i class="fa-solid fa-pencil"></i> Editar
                                        </a>
                                        <a href="{{ route('productos.qr', $producto->id) }}" class="btn btn-warning btn-sm">
                                            <i class="fa-solid fa-qrcode"></i> QR
                                        </a>
                                        <form action="{{ route('productos.destroy', $producto->id) }}" method="POST" style="display: inline-block;">
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
            $('#productos').DataTable({
                "dom": '<"row"<"col-sm-6"l><"col-sm-6"Bf>>rtip',
                "pageLength": 10,
                "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Todos"]],
                "language": {
                    "emptyTable": "No hay información disponible",
                    "info": "Mostrando _START_ a _END_ de _TOTAL_ productos",
                    "infoEmpty": "Mostrando 0 a 0 de 0 productos",
                    "infoFiltered": "(filtrado de _MAX_ productos en total)",
                    "lengthMenu": "Mostrar _MENU_ productos",
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
