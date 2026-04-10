@extends('adminlte::page')

@section('title', 'Esencia 2023')

@section('content_header')
    <h1>Nueva Cuota</h1>
@stop

@section('content')
    <form class="row g-3 needs-validation" novalidate action="/pago" method="post">
        @csrf
        <div class="col-md-2">
            <label for="fecha" class="form-label">Fecha</label>
            <input type="date" readonly class="form-control-plaintext" id="fecha" name="fecha"
                value="{{ $inscripcion->fecha }}">
        </div>
        <div class="col-md-2">
            <label for="nro_entrada" class="form-label">Nro Entrada</label>
            <input type="number" readonly class="form-control-plaintext" id="nro_entrada" name="nro_entrada"
                value="{{ $inscripcion->nro_entrada }}">
        </div>
        <div class="col-md-3">
            <label for="n_apellido" class="form-label">Nombre y Apellido</label>
            <input type="text" readonly class="form-control-plaintext" id="n_apellido" name="n_apellido"
                value="{{ $inscripcion->n_apellido }}">
        </div>
        <div class="col-md-2">
            <label for="celular" class="form-label">Contacto</label>
            <input type="number" readonly class="form-control-plaintext" id="celular" name="celular"
                value="{{ $inscripcion->celular }}">
        </div>
        <div class="col-md-2">
            <label for="membresia" class="form-label">Membresía</label>
            <input type="text" readonly class="form-control-plaintext" id="membresia" name="membresia"
                value="{{ $inscripcion->membresia }}">
        </div>
        <div class="col-md-3">
            <label for="lider" class="form-label">Lider</label>
            <input type="text" readonly class="form-control-plaintext" id="lider" name="lider"
                value="{{ $inscripcion->lider }}">
        </div>
        <div class="col-md-3 mb-3">
            <label for="inscribio" class="form-label">Incribió</label>
            <input type="text" readonly class="form-control-plaintext" id="inscribio" name="inscribio"
                value="{{ $inscripcion->inscribio }}">
        </div>

        {{-- seccion de pago --}}
        <div class="col-12 card-group">
            <div class="card">
                <div class="card-header">
                    Pago
                </div>
                <div class="card-body">
                    <div class="col-md-12 d-flex flex-wrap">
                        <div class="col-md-2">
                            <label for="fecha" class="form-label">Fecha</label>
                            <input type="date" class="form-control @error('fecha') is-invalid @enderror" id="fecha"
                                name="fecha">
                            @error('fecha')
                                <span class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-2">
                            <label for="importe" class="form-label">Importe</label>
                            <input type="number" class="form-control @error('importe') is-invalid @enderror" id="importe"
                                name="importe">
                            @error('importe')
                                <span class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-2">
                            <label for="formapago" class="form-label">Forma de Pago</label>
                            <select id="formapago" name="formapago" class="form-control">
                                <option value="efectivo">Efectivo</option>
                                <option value="mp">MPago / Transf.</option>
                            </select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="recibio" class="form-label">Recibió</label>
                            <input type="text" class="form-control @error('recibio') is-invalid @enderror" id="recibio"
                                name="recibio">
                            @error('recibio')
                                <span class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-4">
                            <label for="observacion" class="form-label">Observaciones</label>
                            <textarea class="form-control" id="observacion" name="observacion" rows="2"></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12">
            <input type="hidden" name="inscripcion_id" value="{{ $inscripcion->id }}">
            <a href="/inscripcion" class="btn btn-secondary">Cancelar</a>
            <button class="btn btn-primary" type="submit">Guardar</button>
        </div>
    </form>

@stop

@section('css')

@stop

@section('js')

@stop