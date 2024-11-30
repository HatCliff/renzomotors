<?php
session_start();
include('../config/conexion.php');

// Incluye el navbar correspondiente según el tipo de usuario
if (isset($_SESSION['tipo_persona']) && $_SESSION['tipo_persona'] === 'administrador') {
    // Usuario es administrador, incluye el navbar de administrador
    include '../admin/navbaradmin.php';
} else {
    // Usuario es normal, incluye el navbar de usuario
    include '../components/navbaruser.php';
}

// Verificación de usuario
if (!isset($_SESSION['tipo_persona']) || !in_array($_SESSION['tipo_persona'], ['administrador', 'usuario'])) {
    echo "<script>
        alert('Debe estar logueado para contratar un seguro.');
        window.location.href = '../pages/login.php';
    </script>";
    exit();
}

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


?>

<!DOCTYPE html>
<html lang="es">

<head>
    <title>Mis Solicitudes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=chevron_left" />
    <style>
        .card {
            margin-bottom: 1.5rem;
            /* Espacio entre tarjetas */
            transition: transform 0.2s ease-in-out;
        }

        .card:hover {
            transform: translateY(-5px);
            /* Efecto de levitación*/
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .estado-respondida {
            color: #28a745;
            /*sera para el estado resultado*/
            font-weight: bold;
        }

        .estado-pendiente {
            /*sera para el estado pendiente*/
            color: #ffc107;
            font-weight: bold;
        }
    </style>
</head>

<body class="mt-5 pt-5 bg-light">
    <div class="container mt-5">
        <div class="row align-items-center mb-4">
            <div class="col-auto">
                <a href="../index.php" class="btn btn-light">
                    <span class="material-symbols-outlined">
                        chevron_left
                    </span>
                </a>
            </div>
            <div class="col text-center">
                <h3 class="m-0">Mis Solicitudes de Ayuda</h3>
            </div>
        </div>
        <?php while ($fila = mysqli_fetch_assoc($resultado)): ?>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-3">
                        <i class="bi bi-info-circle"></i> <?= $fila['asunto_solicitud'] ?>
                    </h5>
                    <p class="card-text"><strong>Descripción:</strong> <?= $fila['descripcion_solicitud'] ?></p>
                    <p><strong>Tipo:</strong> <?= ucfirst($fila['tipo_solicitud']) ?></p>
                    <p class="<?= empty($fila['respuesta_admin']) ? 'estado-pendiente' : 'estado-respondida' ?>">
                        <strong>Estado:</strong> <?= empty($fila['respuesta_admin']) ? 'Pendiente' : 'Respondida' ?>
                    </p>
                    <p><strong>Respuesta de Renzo Motors:</strong>
                        <?= $fila['respuesta_admin'] ?? 'Aún no hay respuesta' ?>
                    </p>
                </div>
            </div>
        <?php endwhile; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>