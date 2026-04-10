@extends('adminlte::page')

@section('title', 'Esencia 2026')

@section('content_header')
    <h1>Inscriptas Esencia 2026</h1>
@stop

@section('content')
    <a href="recepcionista/create" class="btn btn-primary mb-3">Nueva Recepcionista</a>

    <table id="recepcionistas" class="table  table-hover table-bordered border-danger table-striped mt-4" style="width:100%">
        <thead class="bg-danger">
            <tr>
                <th scope="col">Nombre</th>
                <th scope="col">Apellido</th>
                <th scope="col">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($recepcionistas as $recepcionista)
                <tr>
                    <td>{{ $recepcionista->nombre }}</td>
                    <td>{{ $recepcionista->apellido }}</td>
                    
                    <td>
                        <form action="{{ route('recepcionista.destroy', $recepcionista->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <a href="recepcionista/{{ $recepcionista->id }}/edit" class="btn btn-info btn-sm">
                                <i class="fa-solid fa-pencil"></i></a>
                            <button type="submit" class="btn btn-danger btn-sm show_confirm"><i
                                    class="fa-solid fa-trash-can"></i></button>
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
            $('#inscripciones').DataTable({
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
                        title: `¿Está seguro de querer borrar esta recepcionista?`,
                        text: "Si se borra, se eliminará de forma permanente.",
                        icon: "warning",
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