
<?php
session_start();
include("../../config/conexion.php");
// Datos de la solicitud
$id_sucursal = isset($_POST['sucursal']) ? $_POST['sucursal'] : null;
$rut_conductor = isset($_POST['rut']) ? $_POST['rut'] : null;
$rut_usuario = $_SESSION['rut'];
$nombre_conductor = isset($_POST['nombre']) && isset($_POST['apellido']) ? $_POST['nombre'] . ' ' . $_POST['apellido'] : null;
$correo_conductor = isset($_POST['correo']) ? $_POST['correo'] : null;
$telefono_conductor = isset($_POST['telefono']) ? $_POST['telefono'] : null;
$vehiculo_modelo_prueba = isset($_POST['modelo']) ? $_POST['modelo'] : null;
$fecha_prueba = isset($_POST['fecha']) ? $_POST['fecha'] : null;
$hora_prueba = isset($_POST['hora']) ? $_POST['hora'] : null;

if ($id_sucursal && $rut_usuario && $rut_conductor && $nombre_conductor &&
    $correo_conductor && $telefono_conductor && $vehiculo_modelo_prueba &&
    $fecha_prueba && $hora_prueba)  {
    // Asigna los valores POST a las variables
    $id_sucursal = $_POST['sucursal'];
    $rut_conductor = $_POST['rut'];
    $nombre_conductor = $_POST['nombre'] . ' ' . $_POST['apellido'];
    $correo_conductor = $_POST['correo'];
    $telefono_conductor = $_POST['telefono'];
    $vehiculo_modelo_prueba = $_POST['modelo'];
    $fecha_prueba = $_POST['fecha'];
    $hora_prueba = $_POST['hora'];
    var_dump(
        $id_sucursal,
        $rut_conductor,
        $nombre_conductor,
        $correo_conductor,
        $telefono_conductor,
        $vehiculo_modelo_prueba,
        $fecha_prueba,
        $hora_prueba
    );
    // Inserta en la base de datos
    $sql = "INSERT INTO agenda_prueba (id_sucursal, rut_usuario, rut_conductor, nombre_conductor, correo_conductor, telefono_conductor, vehiculo_modelo_prueba, fecha_prueba, hora_prueba) 
            VALUES ('$id_sucursal', '$rut_usuario', '$rut_conductor', '$nombre_conductor', '$correo_conductor', '$telefono_conductor', '$vehiculo_modelo_prueba', '$fecha_prueba', '$hora_prueba')";

    if (mysqli_query($conexion, $sql)) {
        // Mostrar mensaje de éxito
        echo "<script>
                alert('Solicitud de prueba de manejo enviada correctamente.');
                window.location.href='test_manejo.php';
            </script>";
    } else {
        echo "Error en la inserción: " . mysqli_error($conexion);
    }
} else {
    echo "Error: Algunos datos no fueron recibidos.";
    var_dump(
        $_POST['id_sucursal'],
        $_POST['rut_usuario'],
        $_POST['rut_conductor'],
        $_POST['nombre_conductor'],
        $_POST['correo_conductor'],
        $_POST['telefono_conductor'],
        $_POST['vehiculo_modelo_prueba'],
        $_POST['fecha_prueba'],
        $_POST['hora_prueba']
    );
}
?>