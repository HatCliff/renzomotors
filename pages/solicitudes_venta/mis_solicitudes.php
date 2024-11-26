<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include('../../config/conexion.php');

if (isset($_SESSION['usuario'])) {

    if (isset($_SESSION['tipo_persona']) && $_SESSION['tipo_persona'] === 'administrador') {
        include '../../admin/navbaradmin.php';
    } else {
        include '../../components/navbaruser.php';
    }

    $rut_user = $_SESSION['rut'];
    $solicitudes = "SELECT * FROM vehiculo_ofertado WHERE rut_usuario = '$rut_user'";
    $result_solicitudes = $conexion->query($solicitudes);
} else {
    header('Location: ../login.php');
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Detalles del Vehículo</title>
</head>

<body class="pt-5">
    <div class="container mt-5">
        <div class="row">
            <h1 class="mb-3">Mis solicitudes</h1>
            <hr class="mb-3">
            <div class="col-lg-12 mb-3">
            <?php
while ($solicitud = mysqli_fetch_assoc($result_solicitudes)) {
    // Determinar el estado y clase del botón
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

    echo "
    <div class='mb-3 border d-flex flex-row align-items-stretch shadow position-relative' 
         style='border-radius: 20px; overflow: hidden; max-height: 300px;'>
        <!-- Imagen del vehículo -->
        <div class='d-flex align-items-center'>
            <img src='{$solicitud['imagen_oferta']}' alt='Imagen del Vehículo' 
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
                    <li><strong>Precio Solicitado:</strong> $ {$solicitud['precio_solicitud']}</li>
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
                    <li><strong>Fecha de Solicitud:</strong> {$solicitud['fecha_solicitud']}</li>
                </ul>
            </div>
        </div>
        <!-- Botón de estado -->
        <button class='btn $claseBoton position-absolute' 
                style='bottom: 10px; right: 10px;'>
            $estado
        </button>
    </div>
    ";
}
?>


            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>