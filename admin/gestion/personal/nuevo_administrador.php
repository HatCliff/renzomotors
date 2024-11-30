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
            // echo "{$permiso['nombre_permiso']}";
        }

        if (in_array('Personal', $lista_permisos)) {
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

$no_administradores = "SELECT ur.* FROM usuario_registrado ur WHERE ur.tipo_persona = 'usuario'";
$result_admin = $conexion->query($no_administradores);

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.css" />
    <title>Personal</title>
</head>

<body class="pt-5 mt-3">
    <div class="container mt-5">
        <div class="row">
            <div class="col-12">
                <h1 class="text-center mb-4">Agregar Personal Administrador</h1>
                <a href='../personal.php' class='btn btn-secondary' title='Volver al Panel de Personal'> ← Volver</a>
                <table id="miTabla" class="display" style="width:100%">
                    <thead>
                        <tr>
                            <th>RUT</th>
                            <th>Nombre</th>
                            <th>Correo</th>
                            <th style="max-width: 250px; width: 150px; white-space: nowrap;">Editar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($admin = mysqli_fetch_assoc($result_admin)) {
                            echo "
                        <tr>
                            <td>{$admin['rut']}</td>
                            <td>{$admin['nombre']} {$admin['apellido']}</td>
                            <td>{$admin['correo']}</td>
                            <td>
                            <a href='agregar_administrador.php?rut={$admin['rut']}' class='btn btn-success' title='Añadir como Administrador'>Contratar</a>
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
        $('#miTabla').DataTable();
    });
</script>