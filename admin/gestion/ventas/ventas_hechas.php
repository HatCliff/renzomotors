<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include("../../../config/conexion.php");
if (isset($_SESSION['usuario'])) {
    if ($_SESSION['tipo_persona'] === 'administrador') {

        $rut_user = $_SESSION['rut'];
        $permisos = "SELECT p.* FROM permiso p
                                 JOIN rol_permiso rp ON rp.id_permiso = p.id_permiso
                                 JOIN rol r ON r.id_rol = rp.id_rol
                                 JOIN administrador a ON a.id_rol = r.id_rol
                                 WHERE a.rut_administrador = '$rut_user'";
        $result_permisos = $conexion->query($permisos);
        $lista_permisos = [];
        while ($permiso = $result_permisos->fetch_assoc()) {
            $lista_permisos[] = $permiso['nombre_permiso'];
        }

        if (in_array('Ventas', $lista_permisos)) {
            include("../../navbaradmin.php");
        } else {
            header('Location: ../dashboard.php');
        }
    } else {
        header('Location: ../../../index.php');
    }
} else {
    header('Location: ../../../pages/login.php');
}

$registro = "SELECT rr.*, rv.*, s.nombre_sucursal, c.*, v.nombre_modelo FROM registro_reserva rr
            JOIN reserva_vehiculo rv ON rv.num_reserva_vehiculo = rr.num_reserva_vehiculo
            JOIN sucursal s ON s.id_sucursal = rr.sucursal_reserva
            JOIN color c ON c.id_color = rr.color_reserva
            JOIN vehiculo v ON rv.id_vehiculo = v.id_vehiculo
            WHERE compra_concretada IS NOT NULL";
$result_registro = $conexion->query($registro);

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.css" />
    <script src="sweetalert2.all.min.js"></script>
    <title>Personal</title>
</head>

<body class="pt-5 mt-3">
    <div class="container mt-5">
        <div class="row">
            <div class="col-12">
                <h1 class="text-center mb-4">Analisis de Ventas</h1>
                <a href='confirmacion_ventas.php' class='btn btn-secondary' title=''> ← Volver</a>
                <table id="miTabla" class="display table table-striped table-bordered" style="width:100%">
                    <thead class="table table-dark">
                        <tr>
                            <th>Datos Cliente</th>
                            <th>Datos Vehículo</th>
                            <th>Sucursal</th>
                            <th>Resolución</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($reserva = mysqli_fetch_assoc($result_registro)) {
                            echo "
                                <tr>
                                    <!-- Cliente -->
                                    <td>
                                        <ul style='list-style: none; padding-left: 0; margin: 0;'>
                                            <li><strong>RUT</strong> - {$reserva['rut_cliente']}</li>
                                            <li><strong>Nombre</strong> - {$reserva['nombre_cliente']}</li>
                                            <li><strong>Correo</strong> - {$reserva['correo_cliente']}</li>
                                            <li><strong>Teléfono</strong> - {$reserva['telefono_cliente']}</li>
                                        </ul>
                                    </td>

                                    <!-- Vehículo -->
                                    <td>
                                        <ul style='list-style: none; padding-left: 0; margin: 0;'>
                                            <li>Modelo - {$reserva['nombre_modelo']}</li>
                                            <li style='color: {$reserva['codigo_color']};'>{$reserva['nombre_color']}</li>
                                            <li class='text-success'>\${$reserva['precio_reserva']}</li>
                                        </ul>
                                    </td>
                                    <td>
                                        <ul style='list-style: none; padding-left: 0; margin: 0;'>
                                            <li>{$reserva['nombre_sucursal']}</li>
                                            <li class = 'fw-bold'>{$reserva['fecha_reserva']}</li>
                                            <li class = 'fw-bold'>{$reserva['hora_reserva']}</li>
                                        </ul>
                                    </td>
                                    <td>";
                                if($reserva['compra_concretada'] === '0'){
                                    echo " <p class='text-danger'>Sin venta</p> ";
                                }
                                else{
                                    echo " <p class='text-success'>Vendida</p> ";
                                }
                            echo "
                                    </td>
                                </tr>
                                ";
                        }
                        ?>
                    </tbody>

                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

<script>
    $(document).ready(function () {
        $('#miTabla').DataTable({
            "language": {
                "sProcessing": "Procesando...",
                "sLengthMenu": "Mostrar _MENU_ registros",
                "sZeroRecords": "No se encontraron resultados",
                "sEmptyTable": "Ningún dato disponible en esta tabla",
                "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                "sInfoPostFix": "",
                "sSearch": "Buscar:",
                "sUrl": "",
                "sInfoThousands": ",",
                "sLoadingRecords": "Cargando...",
                "oPaginate": {
                    "sFirst": "Primero",
                    "sPrevious": "Anterior",
                    "sNext": "Siguiente",
                    "sLast": "Último"
                },
                "oAria": {
                    "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                    "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                }
            }
        });
    });
</script>