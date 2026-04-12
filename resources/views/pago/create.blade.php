@extends('adminlte::page')

@section('title', 'Esencia' . env('APP_ANIO', '2026'))

@section('content_header')
    <h1>Nueva Cuota - {{ $inscripcion->n_apellido}}</h1>
@stop

@section('content')
    
        <div class="col-12 row">
        <div class="col-md-2">
            <label for="fecha" class="form-label">Fecha Inscripción</label>
            <p><?php setlocale(LC_TIME, 'es_ES.UTF-8', 'spanish');?>
            {{strftime("%d de %B de %Y", strtotime($inscripcion->fecha)) }}</p>
        </div>
        <div class="col-md-1">
            <label for="tipo" class="form-label">Tipo</label>
            <p>{{ ucwords($inscripcion->tipo) }}</p>
        </div>
        <div class="col-md-2">
            <label for="celular" class="form-label">Contacto</label>
            <p>{{ $inscripcion->celular }}</p>
        </div>
        <div class="col-md-2">
            <label for="membresia" class="form-label">Membresía</label>
            <p>{{ ucwords($inscripcion->membresia) }}</p>
        </div>
        <div class="col-md-2">
            <label for="valorTotal" class="form-label">Valor Total</label>
            <p>{{ $inscripcion->valorTotal }}</p>
        </div>
        <div class="col-md-3 mb-3">
            <label for="inscribio" class="form-label">Incribió</label>
            <p>{{ $recepcionista->nombre }} {{ $recepcionista->apellido }}</p>
        </div>
        <div class="col-md-3 mb-3">
            <label for="deuda" class="form-label">Adeudado</label>
            <p>$ {{ $inscripcion->valorTotal - $total_pagos }} </p>
        </div>
    </div>
    <form class="row g-3 needs-validation" novalidate action="/pago" method="post">
        @csrf
        <input type="hidden" name="adeudado" value="{{($inscripcion->valorTotal-$total_pagos)}}">

        {{-- seccion de pago --}}
        <div class="col-12 card-group">
            <div class="card card-primary">
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
                                 <option value="transferencia">Transferencia</option>
                                <option value="efectivo">Efectivo</option>
                                <option value="tarjeta">Tarjeta</option>
                            </select>
                        </div>
                         <div class="col-md-3 mb-3">
                            <label for="recibio" class="form-label">Recibió</label>
                            <select id="recibio" name="recibio" class="form-control @error('recibio') is-invalid @enderror">
                            @foreach ($recepcionistas as $la_recepcionista)
                                <option value="{{$la_recepcionista->id}}">{{$la_recepcionista->nombre}} {{$la_recepcionista->apellido}}</option>
                            @endforeach
                            <option value="nn">No se sabe</option>
                            </select>
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