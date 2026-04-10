<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/admin_custom.css">

    <script src="https://kit.fontawesome.com/aef41c8d84.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <style>
        table {
            font-size: 12px;
        }

    </style>
</head>

<body>
    <div >
        <h5 class=" font-weight-bold">Reporte Inscriptas Esencia 2024</h5>
        <p class="text"><b>Filtros Aplicados:</b> Membresía: {{$membresia}}, Promo: {{$promo}}, Pagados: {{$completado}}, 
            Cantidad total en reporte: {{count($inscripciones)}}
        </p>
        <p class="text"><b>Fecha:</b> {{$fecha}}, <b>Pagos Completos:</b> {{$pago_completo}}, 
           <b>Total Inscriptas:</b> {{$inscriptas_total}}
        </p>
        <table id="inscripciones" class="table  table-hover table-bordered border-danger table-striped mt-4"
            style="width:100%">
            <thead class="bg-danger">
                <tr>
                    <th scope="col">Nro Entrada</th>
                    
                    <th scope="col">Nombre y Apellido</th>
                    <th scope="col">Celular</th>
                    <th scope="col">Talle</th>
                    <th scope="col">Membresía</th>
                    <th scope="col">Estado</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($inscripciones as $inscripcion)
                    <tr>
                        <td>{{ $inscripcion->nro_entrada }}</td>
                        <td>{{ $inscripcion->n_apellido }}</td>
                        <td>{{ $inscripcion->celular }}</td>
                        <td>{{ $inscripcion->lider }}</td>
                        <td>{{ $inscripcion->membresia }}</td>
                        <td>
                            @if ($inscripcion->completado == 1)
                                <span class="text-success">Pagado <i class="fas fa-check-circle fa-lg"></i></span>
                            @else
                                Pendiente
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</body>

</html>