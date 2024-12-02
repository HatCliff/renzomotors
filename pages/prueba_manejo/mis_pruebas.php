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
    $solicitudes = "SELECT * FROM agenda_prueba WHERE rut_usuario = '$rut_user'";
    $result_solicitudes = $conexion->query($solicitudes);
} else {
    header('Location: ../login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900&display=swap"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Detalles del Vehículo</title>
</head>

<body class="pt-5">
    <div class="container mt-5">
        <div class="row">
            <h1 class="mb-3">Mis reservas prueba de manejo</h1>
            <hr class="mb-3">
            <div class="col-lg-12 mb-3">
                <?php
                while ($prueba = $result_solicitudes->fetch_assoc()) {
                    // Verificar que vehiculo_modelo_prueba tiene valor
                    if (empty($prueba['vehiculo_modelo_prueba'])) {
                        echo "<div>Error: vehiculo_modelo_prueba está vacío para este registro.</div>";
                        continue;
                    }

                    // Consulta para obtener los datos del vehículo
                    $vehiculo_query = "SELECT * FROM vehiculo WHERE id_vehiculo = '" . $prueba['vehiculo_modelo_prueba'] . "'";
                    $result_vehiculo = $conexion->query($vehiculo_query);

                    // Manejar caso donde no hay resultados
                    if (!$result_vehiculo || $result_vehiculo->num_rows == 0) {
                        echo "<div>No se encontraron datos del vehículo para el modelo: " . $prueba['vehiculo_modelo_prueba'] . "</div>";
                        continue;
                    }

                    $vehiculo = $result_vehiculo->fetch_assoc();

                    // Consulta para obtener la foto del vehículo desde fotos_vehiculo
                    $foto_query = "SELECT ruta_foto FROM fotos_vehiculo WHERE id_vehiculo = '" . $vehiculo['id_vehiculo'] . "' LIMIT 1";
                    $result_foto = $conexion->query($foto_query);
                    $foto_vehiculo = '';
                    if ($result_foto && $result_foto->num_rows > 0) {
                        $foto = $result_foto->fetch_assoc();
                        $foto_vehiculo = $foto['ruta_foto']; // Asignamos la ruta de la foto
                    }

                    // Consulta para obtener el nombre de la sucursal
                    $sucursal_query = "SELECT nombre_sucursal FROM sucursal WHERE id_sucursal = '" . $prueba['id_sucursal'] . "'";
                    $result_sucursal = $conexion->query($sucursal_query);

                    // Obtener el nombre de la sucursal
                    $nombre_sucursal = '';
                    if ($result_sucursal && $result_sucursal->num_rows > 0) {
                        $sucursal = $result_sucursal->fetch_assoc();
                        $nombre_sucursal = $sucursal['nombre_sucursal'];
                    } else {
                        $nombre_sucursal = 'Sucursal no encontrada';
                    }

                    // Renderizar los datos
                    echo "
    <div class='mb-3 border d-flex flex-row align-items-stretch shadow position-relative' 
         style='border-radius: 20px; overflow: hidden; max-height: 300px;'>
        <!-- Imagen del vehículo -->
        <div class='d-flex align-items-center'>
            <img src='/../xampp/renzomotors/admin/mantenedores/vehiculo/{$foto_vehiculo}' alt='Imagen del Vehículo' 
                 class='img-thumbnail' 
                 style='width: 100%; max-width: 400px; height: auto; max-height: 300px; object-fit: cover; border-radius: 20px 0 0 20px;'>
        </div>
        <!-- Información de la prueba y del vehículo -->
        <div class='p-3 d-flex justify-content-between'>
            <div class='me-3'>
                <h5 class='mb-3'><strong>Información General</strong></h5>
                <ul style='list-style: none; padding-left: 20px;'>
                    <li><strong>Nombre Sucursal:</strong> {$nombre_sucursal}</li>
                    <li><strong>RUT Conductor:</strong> {$prueba['rut_conductor']}</li>
                    <li><strong>Nombre Conductor:</strong> {$prueba['nombre_conductor']}</li>
                    <li><strong>Correo Conductor:</strong> {$prueba['correo_conductor']}</li>
                    <li><strong>Teléfono Conductor:</strong> {$prueba['telefono_conductor']}</li>
                    <li><strong>Fecha de Prueba:</strong> {$prueba['fecha_prueba']}</li>
                    <li><strong>Hora de Prueba:</strong> {$prueba['hora_prueba']}</li>
                </ul>
            </div>
            <div>
                <h5 class='mb-3'><strong>Detalles del Vehículo</strong></h5>
                <ul style='list-style: none; padding-left: 20px;'>
                    <li><strong>Modelo:</strong> {$vehiculo['nombre_modelo']}</li>
                    <li><strong>Precio:</strong> $ {$vehiculo['precio_modelo']}</li>
                    <li><strong>Cantidad de Puertas:</strong> {$vehiculo['cantidad_puertas']}</li>
                    <li><strong>Caballos de Fuerza:</strong> {$vehiculo['caballos_fuerza']}</li>
                    <li><strong>Kilometraje:</strong> {$vehiculo['kilometraje']} km</li>
                </ul>
            </div>
            <div class='mx-auto my-auto'>
                <!-- Botón de estado -->
                            <ul class='mb-1'>
                                    <a href='perfil.php?accion=1' class='btn btn-sm btn-secondary' >Reagendar prueba de manejo.</a>
                            </ul>
                            <ul class='mb-1'>
                                    <a href='perfil.php?accion=1' class='btn btn-sm btn-danger'>Eliminar prueba de manejo.</a>
                            </ul>
                            </fieldset>
            </div>
        </div>
        
                            
    </div>";
                }
                ?>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
