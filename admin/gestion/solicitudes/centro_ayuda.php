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

// Manejar la respuesta del administrador
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_ayuda'], $_POST['respuesta_admin'])) {
    $id_ayuda = $_POST['id_ayuda'];
    $respuesta_admin = $_POST['respuesta_admin'];

    // Actualizar la respuesta en la base de datos
    $query = "UPDATE solicitud_ayuda SET respuesta_admin = '$respuesta_admin' WHERE id_ayuda = $id_ayuda";
    $resultado = mysqli_query($conexion, $query);

    if ($resultado) {
        echo "Respuesta enviada con éxito.";
    } else {
        echo "Error al enviar la respuesta: " . mysqli_error($conexion);
    }
}
// Se obtiene todas las solicitudes de ayuda
$query = "SELECT * FROM solicitud_ayuda WHERE respuesta_admin IS NULL";
$resultado = mysqli_query($conexion, $query);

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
                <h1 class="text-center mb-4">Centro de ayuda</h1>
                <a href='../solicitudes.php' class='btn btn-secondary' title='Volver al Panel de Personal'> ← Volver</a>
                <a href='respuestas_cy.php' class='btn btn-info' title='Ver Respuestas'>Respuestas</a>
                <table id="miTabla" class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Asunto</th>
                            <th>Descripción</th>
                            <th>Tipo</th>
                            <th>Respuesta del Administrador</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($fila = mysqli_fetch_assoc($resultado)): ?>
                            <tr>
                                <td><?= $fila['id_ayuda'] ?></td>
                                <td><?= $fila['asunto_solicitud'] ?></td>
                                <td><?= $fila['descripcion_solicitud'] ?></td>
                                <td class="text-capitalize"><?= $fila['tipo_solicitud'] ?></td>
                                <td><?= $fila['respuesta_admin'] ?? 'Sin respuesta' ?></td>
                                <td>
                                    <?php if (empty($fila['respuesta_admin'])): ?>
                                        <form method="POST" action="">
                                            <input type="hidden" name="id_ayuda" value="<?= $fila['id_ayuda'] ?>">
                                            <textarea name="respuesta_admin" class="form-control mb-2"
                                                placeholder="Escribe una respuesta" required></textarea>
                                            <button type="submit" class="btn btn-primary btn-sm">Enviar Respuesta</button>
                                        </form>
                                    <?php else: ?>
                                        <button class="btn btn-secondary btn-sm" disabled>Respondida</button>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endwhile; ?>
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