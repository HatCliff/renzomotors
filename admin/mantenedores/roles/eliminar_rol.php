<?php include '../conexion.php'; 

$id = $_GET['id_rol'];

// eliminar relaciones con permisos
$query_permisos = "DELETE FROM roles_permisos WHERE id_rol='$id'";
mysqli_query($conexion, $query_permisos);


$query = "DELETE FROM roles WHERE id_rol = '$id'";
$resultado = mysqli_query($conexion, $query);
//eliminar el elemento del mantenedor
if ($resultado) {
    echo "<script>alert('Rol eliminado con éxito'); window.location='mantenedor_roles.php';</script>";
} else {
    echo "Error al eliminar el seguro: " . mysqli_error($conexion);
}
?>
