@extends('adminlte::page')

@section('title', 'Esencia 2026')

@section('content_header')
    <h1>Editar Recepcionista</h1>
@stop

@section('content')

    <form class="row g-3 needs-validation" action="/recepcionista/{{ $recepcionista->id }}" method="post">
        @csrf
        @method('PUT') {{-- para que tome el api rest --}}
        
        <div class="col-md-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="nombre" name="nombre"
                @if (old('nombre') === null) value="{{ $recepcionista->nombre }}" @else value="{{ old('nombre') }}" @endif
                required>
            @error('nombre')
                <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="col-md-3">
            <label for="apellido" class="form-label">Apellido</label>
            <input type="text" class="form-control" id="apellido" name="apellido"
                @if (old('apellido') === null) value="{{ $recepcionista->apellido }}" @else value="{{ old('apellido') }}" @endif
                required>
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

@stop