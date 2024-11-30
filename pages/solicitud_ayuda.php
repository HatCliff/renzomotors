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
        //echo "Respuesta enviada con éxito.";
    } else {
        //echo "Error al enviar la respuesta: " . mysqli_error($conexion);
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
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=chevron_left" />
</head>
<style>
        .estado-pendiente {
            color: #dc3545; /* Rojo para pendiente */
        }
        .estado-respondida {
            color: #28a745; /* Verde para respondida */
        }
    </style>
</head>
<body class="mt-5 pt-5 bg-light">
    <div class="container mt-5">
        <!-- Encabezado -->
        <div class="row align-items-center mb-4">
            <div class="col-auto">
                <a href="../index.php" class="btn btn-light">
                    <span class="material-symbols-outlined">chevron_left</span>
                </a>
            </div>
            <div class="col text-center">
                <h2 class="m-0">Solicitudes de Ayuda</h2>
            </div>
        </div>

        <!-- Iteración de solicitudes -->
        <?php while ($fila = mysqli_fetch_assoc($resultado)): ?>
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title mb-3">
                        <i class="bi bi-info-circle"></i> <?= htmlspecialchars($fila['asunto_solicitud']) ?>
                    </h5>
                    <p class="card-text"><strong>Descripción:</strong> <?= htmlspecialchars($fila['descripcion_solicitud']) ?></p>
                    <p><strong>Tipo:</strong> <?= ucfirst(htmlspecialchars($fila['tipo_solicitud'])) ?></p>
                    <p class="<?= empty($fila['respuesta_admin']) ? 'estado-pendiente' : 'estado-respondida' ?>">
                        <strong>Estado:</strong> <?= empty($fila['respuesta_admin']) ? 'Pendiente' : 'Respondida' ?>
                    </p>
                    <p><strong>Respuesta de Renzo Motors:</strong>
                        <?= htmlspecialchars($fila['respuesta_admin']) ?? 'Aún no hay respuesta' ?>
                    </p>
                    
                    <!-- Formulario para enviar respuesta -->
                    <?php if (empty($fila['respuesta_admin'])): ?>
                        <form method="POST" action="">
                            <input type="hidden" name="id_ayuda" value="<?= $fila['id_ayuda'] ?>">
                            <textarea name="respuesta_admin" class="form-control mb-3" placeholder="Escribe una respuesta" required></textarea>
                            <button type="submit" class="btn btn-primary">Enviar Respuesta</button>
                        </form>
                    <?php endif; ?>
                    
                </div>
            </div>
        <?php endwhile; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>