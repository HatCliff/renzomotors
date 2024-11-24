<?php
include '../../../config/conexion.php';

$id_servicio = $_GET['id'];

$query = "SELECT * FROM servicio WHERE id_servicio = $id_servicio";
$resultado = mysqli_query($conexion, $query);

if ($resultado) {
    $servicio = mysqli_fetch_assoc($resultado);
} else {
    die("Error en la consulta: " . mysqli_error($conexion));
}

$imagen_actual = $servicio['imagen_servicio'];
unlink($imagen_actual);
// eliminar relaciones de servicios
$delete_relaciones = "DELETE FROM sucursal_servicio WHERE id_servicio = $id_servicio";
            mysqli_query($conexion, $delete_relaciones);
            
$query = "DELETE FROM servicio WHERE id_servicio = $id_servicio";
$resultado = mysqli_query($conexion, $query);

if ($resultado) {
    echo "<script>alert('Servicio eliminado con éxito'); window.location='mantenedor_servicios.php';</script>";
} else {
    echo "Error al eliminar el servicio: " . mysqli_error($conexion);
}
?>