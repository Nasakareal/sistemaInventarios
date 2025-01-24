@extends('adminlte::page')

@section('title')

@section('content_header')
    <center><h1>Sistema de Inventarios</h1></center>
@stop

@section('content')
    <div class="row">

        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
                <span class="info-box-icon bg-lightblue"><i class="fa-regular fa-rectangle-list"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text"><b>Listado de Requisiciones</b></span>
                    <a href="{{ url('requisiciones') }}" class="btn btn-primary btn-sm">Acceder</a>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
                <span class="info-box-icon bg-teal"><i class="fa-solid fa-clipboard-list"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text"><b>Listado de Inventarios</b></span>
                    <a href="{{ url('#') }}" class="btn btn-primary btn-sm">Acceder</a>
                </div>
            </div>
        </div>

         <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
                <span class="info-box-icon bg-navy"><i class="fa-regular fa-flag"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text"><b>Roles</b></span>
                    <a href="{{ url('#') }}" class="btn btn-primary btn-sm">Acceder</a>
                </div>
            </div>
        </div>

    </div>
@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    <script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
@stop
