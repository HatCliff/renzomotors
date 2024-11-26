<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include("../../config/conexion.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo 'llego post';
}
else{
echo 'no llego post';
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Datos del propietario
    $nombre_sv = $_POST['nombre'];
    $rut_sv = $_POST['rut'];
    $correo_sv = $_POST['correo'];
    $telefono_sv = $_POST['telefono'];

    // Datos del vehículo
    $marca_sv = $_POST['marca'];
    $modelo_sv = $_POST['modelo'];
    $anio_sv = $_POST['anio'];
    $pais_sv = $_POST['pais'];
    $kilometraje_sv = $_POST['kilometraje'];

    // Datos de documentos
    $patente_sv = $_POST['patente'];
    $doc_propiedad_sv = $_FILES['doc_propiedad'];
    $doc_propiedad_ruta = "documentos_propiedad/". $patente_sv . "_" . basename($doc_propiedad_sv['name']);
    $imagen_sv = $_FILES['imagen'];
    $imagen_ruta = "imagenes_propiedad/". $patente_sv . "_" . basename($imagen_sv['name']);
    $precio_sv = $_POST['precio'];

    // Datos adicionales
    date_default_timezone_set('America/Santiago');
    $fecha_solicitud = date('Y-m-d');
    $rut_user = $_SESSION['rut'];

    try {
        $guardar = "INSERT INTO vehiculo_ofertado
                    VALUES ('$patente_sv', '$modelo_sv', '$marca_sv', '$pais_sv', '$imagen_ruta', '$kilometraje_sv',
                          '$anio_sv', '$nombre_sv', '$doc_propiedad_ruta', '$correo_sv', '$telefono_sv', '$precio_sv',
                          '$rut_sv', '$fecha_solicitud', '$rut_user', null, null)";
        $resultado_solicitud = $conexion->query($guardar);
        // Archivos
        if ($doc_propiedad_sv && $doc_propiedad_sv['error'] === UPLOAD_ERR_OK) {
            move_uploaded_file($doc_propiedad_sv['tmp_name'], $doc_propiedad_ruta);
        }

        if ($imagen_sv && $imagen_sv['error'] === UPLOAD_ERR_OK) {
            move_uploaded_file($imagen_sv['tmp_name'], $imagen_ruta);
        }

        echo "Solicitud guardada exitosamente.";
    } catch (Exception $e) {
        echo "Error al guardar la solicitud: " . $e->getMessage();
    }
} else {
    echo "Método no permitido.";
}

?>