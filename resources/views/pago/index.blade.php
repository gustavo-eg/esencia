@extends('adminlte::page')

@section('title', 'Esencia' . env('APP_ANIO', '2026'))

@section('content_header')
    <h1>Pagos - {{ $inscripcion->n_apellido }}</h1>
@stop

@section('content')
    <div class="col-12 row">
        <div class="col-md-2">
            <label for="fecha" class="form-label">Fecha Inscripción</label>
            <p><?php setlocale(LC_TIME, 'es_ES.UTF-8', 'spanish');?>
            {{strftime("%d de %B de %Y", strtotime($inscripcion->fecha))
                }}</p>
            {{-- Dar formato a la fecha para mostrar --}}
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
            <p>{{ $inscripcion->recepcionistas->nombre }} {{ $inscripcion->recepcionistas->apellido }}</p>
        </div>
    </div>
{{-- Parte que muesro en el resumen --}}
    <div class="alert @if ($inscripcion->completado == 1) alert-success @else alert-danger @endif" role="alert">
        <div class="row">
            <div class="col">
                Total pagos: <b>$ {{ $total }}</b>
                (
                    @if ($inscripcion->financiacion == 1)
                        Cuotas
                    @else
                        Completo
                    @endif
                )
            </div>
            @if ($inscripcion->completado == 0)
                <div class="col">
                    Falta: <b>$ {{ $inscripcion->valorTotal - $total }} </b>
                </div>
            @endif
            <div class="col">
                Estado: <b>
                    @if ($inscripcion->completado == 1 )
                        Pagado
                    @else
                        Pendiente
                    @endif
                </b>
            </div>
        </div>
       
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
                    <td>{{ ucwords($unpago->modo) }}</td>
                    <td>{{ $unpago->recepcionistas->nombre}} {{$unpago->recepcionistas->apellido}}</td>
                    <td>{{ ucwords($unpago->observacion) }}</td>
                    <td>
                        
                        <form action="{{ route('pago.destroy', $unpago->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            {{-- <a href="pago/{{ $unpago->id }}/edit" class="btn btn-info">Editar</a> --}}
                            <button type="submit" class="btn btn-danger show_confirm"><i
                                    class="fa-solid fa-trash-can"></i> Borrar</button>
                        </form>
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
    <script src="https://kit.fontawesome.com/aef41c8d84.js" crossorigin="anonymous"></script>
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