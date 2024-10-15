<?php
include '../../../config/conexion.php';


$id_servicio = $_GET['id'];

// eliminar relaciones de servicios
$delete_relaciones = "DELETE FROM servicio_sucursal WHERE id_servicio = $id_servicio";
            mysqli_query($conexion, $delete_relaciones);
            
$query = "DELETE FROM servicios WHERE id_servicio = $id_servicio";
$resultado = mysqli_query($conexion, $query);

// eliminar elemento
$query = "DELETE FROM accesorios WHERE sku='$sku'";
$resultado = mysqli_query($conexion, $query);

if ($resultado) {
    echo "<script>alert('Servicio eliminado con éxito'); window.location='mantenedor_servicios.php';</script>";
} else {
    echo "Error al eliminar el servicio: " . mysqli_error($conexion);
}
?>