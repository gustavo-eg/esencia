@extends('adminlte::page')

@section('title', 'Esencia' . env('APP_ANIO', '2026'))

@section('content_header')
    <h1>Resumen de Pagos</h1>
@stop

@section('content')
    <div class="col-12 row">
        <div class="col-md-2">
            <label class="form-label">Fecha: </label>
            {{ $fecha_hoy }}

        </div>
        <div class="col-md-3">
            <label class="form-label">Total pagos: </label>
            $ {{ $pago_total }}
        </div>
        <div class="col-md-3">
            <label class="form-label">Pagos completados: </label>
            {{ $pagos_completados }}
        </div>

        <div class="col-md-2">
            <label class="form-label">Total Inscriptas: </label>
            {{ $inscriptas_total }}
        </div>

        {{-- <a href="/pdf" class="btn btn-primary">Pdf</a> --}}
    </div>

    <div class="col-12 card-group">
        <form novalidate action="/pdf" method="POST">
            @csrf
            @method('PUT')
           
            <div class="card">
                <div class="card-header">
                    Generar Reporte
                </div>
                <div class="card-body">
                    <div class="col-md-12 d-flex flex-wrap">
                        <div class="col-4">
                            <label for="promo" class="form-label">Pagos</label>
                            <select id="promo" name="promo" class="form-control">
                                <option value="todas">Todas</option>
                                <option value="sinpromo">$2000 Normal</option>
                                <option value="almuerzo">$8000 C/almuerzo</option>
                                <option value="cuotas">Cuotas</option>
                            </select>
                        </div>
                        <div class="col-4">
                            <label for="completado" class="form-label">Pago Completo</label>
                            <select id="completado" name="completado" class="form-control">
                                <option value="todas">Todas</option>
                                <option value="completo">Completado</option>
                                <option value="incompleto">Incompleto</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="membresia" class="form-label">Membresía</label>
                            <select id="membresia" name="membresia" class="form-control">
                                <option value="todas">Todas</option>
                                <option value="local">Local</option>
                                <option value="interior">Interior</option>
                                <option value="otra_iglesia">Otra Iglesia</option>
                            </select>
                        </div>

                    </div>
                    <input type="hidden" name="total_pagos" value="{{ $pago_total}}" />
                    <input type="hidden" name="pago_completo" value="{{ $pagos_completados}}" />
                    <input type="hidden" name="inscriptas_total" value="{{ $inscriptas_total}}" />
                    <button class="btn btn-primary" type="submit">Generar PDF</button>
                </div>
            </div>
        </form>
    </div>


@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    {{-- <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css"> --}}
@stop

@section('js')
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
@stop