<?php
session_start();
include('../config/conexion.php');
// Verificar si es administrador


// Verificar si el usuario está logueado
if (!isset($_SESSION['rut'])) {
    //echo "Acceso denegado. Inicia sesión para ver tus solicitudes.";

    exit;
}

// Obtener el ID del usuario logueado
$rut = $_SESSION['rut'];


// Obtener las solicitudes del usuario
$query = "SELECT * FROM solicitud_ayuda WHERE rut = '$rut'";
$resultado = mysqli_query($conexion, $query);

// Incluye el navbar correspondiente según el tipo de usuario
if (isset($_SESSION['tipo_persona']) && $_SESSION['tipo_persona'] === 'administrador') {
    // Usuario es administrador, incluye el navbar de administrador
    include '../admin/navbaradmin.php';
} else {
    // Usuario es normal, incluye el navbar de usuario
    include '../components/navbaruser.php';
}
?>

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <title>Mis Solicitudes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="mt-5 pt-5">
    <div class="container mt-5">
        <h3>Mis Solicitudes de Ayuda</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>rut</th>
                    <th>Asunto</th>
                    <th>Descripción</th>
                    <th>Tipo</th>
                    <th>Estado</th>
                    <th>Respuesta del Administrador</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($fila = mysqli_fetch_assoc($resultado)): ?>
                    <tr>
                        <td><?= $fila['id_ayuda'] ?></td>
                        <td><?= $fila['rut'] ?></td>
                        <td><?= $fila['asunto_solicitud'] ?></td>
                        <td><?= $fila['descripcion_solicitud'] ?></td>
                        <td><?= $fila['tipo_solicitud'] ?></td>
                        <td>
                            <?= empty($fila['respuesta_admin']) ? 'Pendiente' : 'Respondida' ?>
                        </td>
                        <td>
                            <?= $fila['respuesta_admin'] ?? 'Aún no hay respuesta' ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>

        </table>

        <div class="d-flex justify-content-center  mt-4">
            <a class="btn btn-secondarY" href='<?php echo $carpetaMain; ?>index.php'>
                Volver
            </a>
        </div>
    </div>
</body>

</html>