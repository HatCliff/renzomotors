<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include("../../config/conexion.php");
if (isset($_SESSION['usuario'])) {
    if ($_SESSION['tipo_persona'] === 'administrador') {
        include("../navbaradmin.php");
        $rut_user = $_SESSION['rut'];
    } else {
        header('Location: ../../index.php');
    }
} else {
    header('Location: ../../pages/login.php');
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>RenzoMotors</title>
</head>

<style>
    .custom-banner {
        background-color: rgba(255, 255, 255, 0.5);
        display: inline-block;
        padding: 10px 20px;
        border-radius: 8px;
        margin: auto;
        color: black;
    }

    .custom-box {
        height: 250px;
        background-color: #007bff;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        font-size: 1.5rem;
        font-weight: bold;
        border-radius: 10px;
        transition: transform 0.2s ease, background-color 0.2s ease;
    }

    .custom-box:hover {
        background-color: #0056b3;
        transform: scale(1.05);
    }
</style>

<body class="pt-5 mt-3">
    <div class="container my-5">
        <div class="row g-4 mb-5">
        <?php
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
        if (in_array('Mantenedores', $lista_permisos)) {
            echo '
            <div class="col-lg-6 col-md-5 col-12">
                <a href="mantenedores.php" class="custom-box"
                    style="background-image: url(\'../../src/images/mantenedores.jpg\'); background-size: cover; background-position: center; height: 250px; width: 100%;">
                    <p class="custom-banner">
                        Mantenedores
                    </p>
                </a>
            </div>
            ';
        }
        if (in_array('Ventas', $lista_permisos)) {
            echo '
            <div class="col-lg-6 col-md-5 col-12">
                <a href="ventas.php" class="custom-box"
                    style="background-image: url(\'../../src/images/analisis_ventas.png\'); background-size: cover; background-position: center; height: 250px; width: 100%;">
                    <p class="custom-banner">
                        Analisis de Ventas
                    </p>
                </a>
            </div>
            ';
        }
        if (in_array('Solicitudes', $lista_permisos)) {
            echo '
            <div class="col-lg-6 col-md-5 col-12">
                <a href="solicitudes.php" class="custom-box"
                    style="background-image: url(\'../../src/images/solicitudes.png\'); background-size: cover; background-position: center; height: 250px; width: 100%;">
                    <p class="custom-banner">
                        Control de Solicitudes
                    </p>
                </a>
            </div>
            ';
        }
        if (in_array('Personal', $lista_permisos)) {
            echo '
            <div class="col-lg-6 col-md-5 col-12">
                <a href="personal.php" class="custom-box"
                    style="background-image: url(\'../../src/images/gestion_personal.jpeg\'); background-size: cover; background-position: center; height: 250px; width: 100%;">
                    <p class="custom-banner">
                        Gestion de Personal
                    </p>
                </a>
            </div>
            ';
        }
        ?>
        </div>
    </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>