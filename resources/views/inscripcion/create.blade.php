@extends('adminlte::page')

@section('title', 'Esencia' . env('APP_ANIO', '2026'))

@section('content_header')
    <h1>Nueva Inscripción</h1>
@stop

@section('content')

    <form class="row g-3 needs-validation" novalidate action="/inscripcion" method="post">
        @csrf
        <div class="col-md-2">
            <label for="fecha" class="form-label">Fecha</label>
            <input type="date" class="form-control @error('fecha') is-invalid @enderror" id="fecha" name="fecha"
                value="{{ old('fecha') }}">
            @error('fecha')
                <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        {{-- <div class="col-md-2">
            <label for="nro_entrada" class="form-label">Nro Entrada</label>
            <input type="number" class="form-control" id="nro_entrada" name="nro_entrada">
        </div> --}}
        <div class="col-md-3">
            <label for="n_apellido" class="form-label">Nombre y Apellido</label>
            <input type="text" class="form-control @error('n_apellido') is-invalid @enderror" id="n_apellido"
                name="n_apellido" value="{{ old('n_apellido') }}">
            @error('n_apellido')
                <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="col-md-2">
            <label for="celular" class="form-label">Contacto</label>
            <input type="number" class="form-control @error('celular') is-invalid @enderror" id="celular" name="celular"
                value="{{ old('celular') }}">
            @error('celular')
                <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="col-md-2">
            <label for="membresia" class="form-label">Membresía</label>
            <select id="membresia" name="membresia" class="form-control">
                <option value="local">Local</option>
                <option value="interior">Interior</option>
                <option value="otra_iglesia">Otra Iglesia</option>
            </select>
        </div>
         <div class="col-md-2">
            <label for="tipo" class="form-label">Tipo</label>
            <select id="tipo" name="tipo" class="form-control">
                <option value="general" {{ old('tipo') === 'general' ? 'selected' : '' }}>General</option>
                <option value="adolescente" {{ old('tipo') === 'adolescente' ? 'selected' : '' }}>Adolescente</option>
                <option value="pastora" {{ old('tipo') === 'pastora' ? 'selected' : '' }}>Pastora</option>
                <option value="especial" {{ old('tipo') === 'especial' ? 'selected' : '' }}>Especial</option>
            </select>
        </div>
        <div class="col-md-3 mb-3">
            <label for="inscribio" class="form-label">Incribió</label>
            <select id="inscribio" name="inscribio" class="form-control">
               @foreach ($recepcionistas as $recepcionista)
                <option value="{{$recepcionista->id}}">{{$recepcionista->nombre}} {{$recepcionista->apellido}}</option>
               @endforeach
               <option value="nn">No se sabe</option>
            </select>
          
        </div>
 
        {{-- seccion de pago --}}
        <div class="col-12 card-group">
            <div class="card">
                <div class="card-header">
                    Pago
                </div>
                <div class="card-body">
                    <div class="col-md-12 d-flex flex-wrap">
                        <div class="col-5">
                            <label class="form-label">Financiación</label>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" id="radio1" name="financiacion" value="completo" checked>
                                <label class="form-check-label" for="radio1">Completo</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" id="radio2" name="financiacion" value="cuotas">
                                <label class="form-check-label" for="radio2">Cuotas</label>
                            </div>
                            

                        </div>
                 
                        <div class="col-md-2">
                            <label for="valorTotal" class="form-label">Valor Total</label>
                            <select id="valorTotal" name="valorTotal" class="form-control">
                                <option value="0" {{ old('valorTotal') === '0' ? 'selected' : '' }}>No paga</option>
                                <option value="40000" {{ old('valorTotal') === '40000' ? 'selected' : '' }}>40000</option>
                                <option value="50000" {{ old('valorTotal') === '50000' ? 'selected' : '' }}>50000</option>
                                <option value="80000" {{ old('valorTotal') === '80000' ? 'selected' : '' }}>80000</option>
                                <option value="100000" {{ old('valorTotal') === '100000' ? 'selected' : '' }}>100000</option>
                            </select>
                        </div>

                        <div class="col-4">
                            <label for="importe" class="form-label">Importe</label>
                            <input type="number" class="form-control @error('importe') is-invalid @enderror" id="importe"
                                name="importe" value="{{ old('importe') }}"    >
                            @error('importe')
                                <span class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-5">
                            <label for="formapago" class="form-label">Forma de Pago</label>
                            <select id="formapago" name="formapago" class="form-control">
                                <option value="transferencia">Transferencia</option>
                                <option value="efectivo">Efectivo</option>
                                <option value="tarjeta">Tarjeta</option>
                            </select>
                        </div>
                        <div class="col-5">
                            <label for="observacion" class="form-label">Observaciones</label>
                            <textarea class="form-control" id="observacion" name="observacion" rows="2"></textarea>
                        </div>
                    </div>
                </div>
            </div>
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
    <script type="text/javascript">
        function EnableDisableTextBox(promo) {
            var selectedValue = promo.options[promo.selectedIndex].value;
            var importe = document.getElementById("importe");
            importe.disabled = false;
            if (!importe.disabled) {
                importe.focus();
            }
        }
    </script>
@stop