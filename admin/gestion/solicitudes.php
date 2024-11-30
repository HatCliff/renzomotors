<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include("../../config/conexion.php");
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
            include("../navbaradmin.php");
        } else {
            header('Location: dashboard.php');
        }
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.css" />
    <script src="sweetalert2.all.min.js"></script>
    <title>Personal</title>
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
        max-height: 100px;
        background-color: #333333;
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
        background-color: #444444;
        transform: scale(1.05);
    }

    .tabs-container {
        display: flex;
        justify-content: space-between;
        gap: 15px;
        margin-top: 20px;
    }
</style>

<body class="pt-5 mt-3">
    <div class="container mt-5">
        <div class="row">
            <div class="col-12"></div>
            <h1 class="text-center mb-4">Gestión de Solicitudes</h1>
            <div class="tabs-container mb-4">
                <!-- Centro de ayuda -->
                <div class="col-lg-6 col-md-6 col-12">
                    <a href="solicitudes/centro_ayuda.php" class="custom-box"
                        style="background-image: url('ruta_de_imagen_centro_ayuda.jpg'); background-size: cover; background-position: center; height: 250px; width: 100%;">
                        <p class="custom-banner">
                            Centro de ayuda
                        </p>
                    </a>
                </div>

                <!-- Solicitudes de Autos -->
                <div class="col-lg-6 col-md-6 col-12">
                    <a href="solicitudes/solicitudes_autos.php" class="custom-box"
                        style="background-image: url('ruta_de_imagen_solicitudes_autos.jpg'); background-size: cover; background-position: center; height: 250px; width: 100%;">
                        <p class="custom-banner">
                            Solicitudes de Autos
                        </p>
                    </a>
                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>