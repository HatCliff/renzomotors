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

        if (in_array('Solicitudes', $lista_permisos)) {
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

$solicitudes = "SELECT * FROM vehiculo_ofertado WHERE aprobacion IS NOT NULL";
$result_solicitudes = $conexion->query($solicitudes);

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
                <h1 class="text-center mb-4">Solicitudes de venta</h1>
                <a href='solicitudes_autos.php' class='btn btn-secondary' title='Volver a Solicitudes'> ← Volver</a>
                <table id="miTabla" class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Solicitud</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($solicitud = mysqli_fetch_assoc($result_solicitudes)) {
                            if (is_null($solicitud['aprobacion'])) {
                                $estado = "En Proceso";
                                $claseBoton = "btn-warning";
                            } elseif ($solicitud['aprobacion'] == 1) {
                                $estado = "Aprobado";
                                $claseBoton = "btn-success";
                            } else {
                                $estado = "Rechazado";
                                $claseBoton = "btn-danger";
                            }
                            echo "<tr>
                                <td>
                                    <div class='border d-flex flex-row align-items-stretch position-relative'
                                        style='border-radius: 20px; overflow: hidden; max-height: 300px;'>
                                        <!-- Imagen del vehículo -->
                                        <div class='d-flex align-items-center'>
                                            <img src='../../../pages/solicitudes_venta/{$solicitud['imagen_oferta']}' alt='Imagen del Vehículo'
                                                class='img-thumbnail'
                                                style='width: 100%; max-width: 400px; height: auto; max-height: 300px; object-fit: cover; border-radius: 20px 0 0 20px;'>
                                        </div>
                                        <!-- Resumen de datos -->
                                        <div class='p-3 d-flex justify-content-between'>
                                            <!-- Vehículo -->
                                            <div class='me-3'>
                                                <h5 class='mb-3'><strong>Datos del Vehículo</strong></h5>
                                                <ul style='list-style: none; padding-left: 20px;'>
                                                    <li><strong>Modelo:</strong> {$solicitud['modelo_oferta']}</li>
                                                    <li><strong>Marca:</strong> {$solicitud['marca_oferta']}</li>
                                                    <li><strong>País de Origen:</strong> {$solicitud['pais_oferta']}</li>
                                                    <li><strong>Año:</strong> {$solicitud['anio_oferta']}</li>
                                                    <li><strong>Kilometraje:</strong> {$solicitud['kilometraje']} km</li>
                                                    <li><strong>Precio Solicitado:</strong> $
                                                        {$solicitud['precio_solicitud']}</li>
                                                    <li><strong>Patente:</strong> {$solicitud['patente']}</li>
                                                </ul>
                                            </div>

                                            <!-- Propietario -->
                                            <div class=''>
                                                <h5 class='mb-3'><strong>Datos del Propietario</strong></h5>
                                                <ul style='list-style: none; padding-left: 20px;'>
                                                    <li><strong>Nombre:</strong> {$solicitud['nombre_duenio']}</li>
                                                    <li><strong>RUT:</strong> {$solicitud['rut_duenio']}</li>
                                                    <li><strong>Correo:</strong> {$solicitud['correo_duenio']}</li>
                                                    <li><strong>Teléfono:</strong> {$solicitud['telefono_duenio']}</li>
                                                    <li><strong>Fecha de Solicitud:</strong> {$solicitud['fecha_solicitud']}
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <!-- Botón de estado -->
                                        <button class='btn $claseBoton position-absolute'
                                            style='bottom: 10px; right: 10px;'>
                                            $estado
                                        </button>
                                    </div>
                                </td>
                            </tr>";
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