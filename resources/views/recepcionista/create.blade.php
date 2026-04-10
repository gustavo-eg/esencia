@extends('adminlte::page')

@section('title', 'Esencia 2026')

@section('content_header')
    <h1>Nueva Recepcionista</h1>
@stop

@section('content')

    <form class="row g-3 needs-validation" novalidate action="/recepcionista" method="post">
        @csrf
        <div class="col-md-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" class="form-control @error('nombre') is-invalid @enderror" id="nombre"
                name="nombre" value="{{ old('nombre') }}">
            @error('nombre')
                <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="col-md-3">
            <label for="apellido" class="form-label">Apellido</label>
            <input type="text" class="form-control @error('apellido') is-invalid @enderror" id="apellido"
                name="apellido" value="{{ old('apellido') }}">
            @error('apellido')
                <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        
        <div class="col-12">
            <a href="/recepcionista" class="btn btn-secondary">Cancelar</a>
            <button class="btn btn-primary" type="submit">Guardar</button>
        </div>
    </form>

@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script type="text/javascript">
        
    </script>
@stop