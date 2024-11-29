<?php
session_start();
include('../config/conexion.php');


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
$query = "SELECT * FROM solicitud_ayuda";
$resultado = mysqli_query($conexion, $query);

if (isset($_SESSION['tipo_persona']) && $_SESSION['tipo_persona'] === 'administrador') {
    // Usuario es administrador, incluye el navbar de administrador
    include '../admin/navbaradmin.php';
} else {
    // Usuario es normal, incluye el navbar de usuario
    include '../components/navbaruser.php';
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Solicitudes de Ayuda</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body  class="mt-5 pt-5">
    <div class="container mt-5">
        <h3>Solicitudes de Ayuda</h3>
        <table class="table table-bordered">
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
                        <td><?= $fila['tipo_solicitud'] ?></td>
                        <td><?= $fila['respuesta_admin'] ?? 'Sin respuesta' ?></td>
                        <td>
                            <?php if (empty($fila['respuesta_admin'])): ?>
                                <form method="POST" action="">
                                    <input type="hidden" name="id_ayuda" value="<?= $fila['id_ayuda'] ?>">
                                    <textarea name="respuesta_admin" class="form-control mb-2" placeholder="Escribe una respuesta" required></textarea>
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
</body>
</html>