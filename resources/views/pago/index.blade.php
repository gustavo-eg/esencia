@extends('adminlte::page')

@section('title', 'Esencia 2024')

@section('content_header')
    <h1>Pagos</h1>
@stop

@section('content')
    <div class="col-12 row">
        <div class="col-md-2">
            <label for="fecha" class="form-label">Fecha Inscripción</label>
            <input type="date" readonly class="form-control-plaintext" id="fecha" name="fecha"
                value="{{ $inscripcion->fecha }}">
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
        <div class="col-md-2">
            <label for="valorTotal" class="form-label">Valor Total</label>
            <input type="text" readonly class="form-control-plaintext" id="valorTotal" name="valorTotal"
                value="{{ $inscripcion->valorTotal }}">
        </div>
        <div class="col-md-3 mb-3">
            <label for="inscribio" class="form-label">Incribió</label>
            <input type="text" readonly class="form-control-plaintext" id="inscribio" name="inscribio"
                value="{{ $inscripcion->inscribio }}">
        </div>
    </div>

    {{-- <div class="col-12 row">
    <span>Resumen de pagos</span>
    <label for="" class="">Total: {{$total}}</label>
    <label for="" class="">Falta: {{(80000 - $total)}}</label>
    <label for="" class="">Estado: </label>

</div> --}}

    <div class="alert @if ($inscripcion->completado == 1) alert-success @else alert-danger @endif" role="alert">
        <div class="row">
            <div class="col">
                Total: <b>$ {{ $total }}</b>
                (
                @switch($inscripcion->promo)
                    @case('almuerzo')
                        C/Almuerzo
                    @break

                    @case('adolescente')
                        Adolescente
                    @break

                    @case('sinpromo')
                        Normal
                    @break

                    @default
                        Cuotas
                @endswitch
                )
            </div>
            @if ($inscripcion->completado == 0)
                <div class="col">
                    Falta: <b>$ 
                        @if ($inscripcion->promo == "almuerzo")
                            {{ 8000 - $total }}
                        @else
                            {{ 80000 - $total }}
                        @endif
                    </b>
                </div>
            @endif
            <div class="col">
                Estado: <b>
                    @if ($inscripcion->completado == 1 or ($inscripcion->promo == "almuerzo" && $total >=80000) or ($inscripcion->promo != "almuerzo" && $total >=80000))
                        Pagado
                    @else
                        Pendiente
                    @endif
                </b>
            </div>
        </div>
        {{-- <p>Total: <b>{{$total}}</b>   Falta: <b>{{(80000 - $total)}}</b>   Estado: <b></b></p> --}}
    </div>

    @if ($inscripcion->completado == 0)
        <a href="/pago/{{ $inscripcion->id }}/create" class="btn btn-primary">Nuevo Pago</a>
    @endif

    <table id="pagos" class="table  table-hover table-bordered border-danger table-striped mt-4" style="width:100%">
        <thead class="bg-danger text-white">
            <tr>
                <th scope="col">Fecha</th>
                <th scope="col">Importe</th>
                <th scope="col">Modo</th>
                <th scope="col">Recibió</th>
                <th scope="col">Observación</th>
                <th scope="col">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pagos as $unpago)
                <tr>
                    <td>{{ date('d/m/Y', strtotime($unpago->fecha)) }}</td>
                    <td>{{ $unpago->importe }}</td>
                    <td>{{ $unpago->modo }}</td>
                    <td>{{ $unpago->recibio }}</td>
                    <td>{{ $unpago->observacion }}</td>
                    <td>
                        @if ($inscripcion->completado == 0)
                        <form action="{{ route('pago.destroy', $unpago->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <a href="pago/{{ $unpago->id }}/edit" class="btn btn-info">Editar</a>
                            <button type="submit" class="btn btn-danger show_confirm">Borrar</button>
                        </form>
                        @else
                        <i>Finalizado</i>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
@stop

@section('js')
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#pagos').DataTable({
                "lengthMenu": [
                    [5, 10, 50, -1],
                    [5, 10, 50, "all"]
                ], //la cantidad de elementos por paginación
                "language": {
                    url: '//cdn.datatables.net/plug-ins/1.12.0/i18n/es-AR.json'
                }
            });

            //alertas con estilos
            $('.show_confirm').click(function(event) {
                var form = $(this).closest("form");
                var name = $(this).data("name");
                event.preventDefault();
                swal({
                        title: `¿Está seguro de querer borrar este pago?`,
                        text: "Si se borra, se eliminará de forma permanente.",
                        icon: "warning",
                        //buttons: true,
                        buttons: ["Cancelar", "Confirmar"],
                        dangerMode: true,
                    })
                    .then((willDelete) => {
                        if (willDelete) {
                            form.submit();
                        }
                    });
            });
        });
    </script>
@stop