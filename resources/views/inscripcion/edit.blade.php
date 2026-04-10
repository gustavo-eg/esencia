@extends('adminlte::page')

@section('title', 'Esencia 2023')

@section('content_header')
    <h1>Editar Inscripción</h1>
@stop

@section('content')

    <form class="row g-3 needs-validation" action="/inscripcion/{{ $inscripcion->id }}" method="post">
        @csrf
        @method('PUT') {{-- para que tome el api rest --}}
        <div class="col-md-2">
            <label for="fecha" class="form-label">Fecha</label>
            <input type="date" class="form-control @error('fecha') is-invalid @enderror" id="fecha" name="fecha"
                @if (old('fecha') === null) value="{{ $inscripcion->fecha }}" @else value="{{ old('fecha') }}" @endif
                required>
            @error('fecha')
                <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="col-md-2">
            <label for="nro_entrada" class="form-label">Nro Entrada</label>
            <input type="number" class="form-control" id="nro_entrada" name="nro_entrada"
                value="{{ $inscripcion->nro_entrada }}">
            <div class="invalid-feedback">
                Debe ingresar un número
            </div>
        </div>
        <div class="col-md-3">
            <label for="n_apellido" class="form-label">Nombre y Apellido</label>
            <input type="text" class="form-control" id="n_apellido" name="n_apellido"
                @if (old('n_apellido') === null) value="{{ $inscripcion->n_apellido }}" @else value="{{ old('n_apellido') }}" @endif
                required>
            @error('n_apellido')
                <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="col-md-2">
            <label for="celular" class="form-label">Contacto</label>
            <input type="number" class="form-control" id="celular" name="celular"
                @if (old('celular') === null) value="{{ $inscripcion->celular }}" @else value="{{ old('celular') }}" @endif
                required>
            @error('celular')
                <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="col-md-2">
            <label for="membresia" class="form-label">Membresía</label>
            <select id="membresia" name="membresia" class="form-control">
                <option value="local" @if ($inscripcion->membresia == 'local') selected="selected" @endif>Local</option>
                <option value="interior" @if ($inscripcion->membresia == 'interior') selected="selected" @endif>Interior</option>
                <option value="otra_iglesia" @if ($inscripcion->membresia == 'otra_iglesia') selected="selected" @endif>Otra Iglesia
                </option>
            </select>
        </div>
        <div class="col-md-3 mb-3">
            <label for="inscribio" class="form-label">Incribió</label>
            <input type="text" class="form-control" id="inscribio" name="inscribio"
                @if (old('inscribio') === null) value="{{ $inscripcion->inscribio }}" @else value="{{ old('inscribio') }}" @endif
                required>
            @error('inscribio')
                <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="col-12">
            <a href="/inscripcion" class="btn btn-secondary">Cancelar</a>
            <button class="btn btn-primary" type="submit">Guardar</button>
        </div>
    </form>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')

@stop