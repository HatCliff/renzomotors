<?php 
include '../../../config/conexion.php';

$id = $_GET['id_rol'];

// eliminar relaciones con permisos
$query_permisos = "DELETE FROM rol_permiso WHERE id_rol='$id'";
mysqli_query($conexion, $query_permisos);


$query = "DELETE FROM rol WHERE id_rol = '$id'";
$resultado = mysqli_query($conexion, $query);
//eliminar el elemento del mantenedor
if ($resultado) {
    echo "<script>alert('Rol eliminado con éxito'); window.location='mantenedor_roles.php';</script>";
} else {
    echo "Error al eliminar el seguro: " . mysqli_error($conexion);
}
?>
