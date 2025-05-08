@extends('adminlte::page')

@section('title', 'Importar Productos')

@section('content_header')
    <h1>Importar Productos desde CSV</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('productos.import') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="file">Selecciona archivo CSV:</label>
                <input type="file" name="file" id="file" class="form-control" accept=".csv" required>
            </div>
            <button type="submit" class="btn btn-primary mt-3">
                <i class="fa-solid fa-upload"></i> Importar
            </button>
        </form>
    </div>
</div>
@stop
