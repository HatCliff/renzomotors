<?php 
include '../conexion.php'; 

$id_seguro = $_GET['id'];

// eliminar relaciones con tipos de accesorios
$query_elimiar_cobertura = "DELETE FROM seguro_cobertura WHERE id_seguro='$id_seguro'";
mysqli_query($conexion, $query_elimiar_cobertura);


$query = "DELETE FROM seguro WHERE id_seguro = $id_seguro";
$resultado = mysqli_query($conexion, $query);
//eliminar el elemento del mantedor
if ($resultado) {
    echo "<script>alert('Seguro eliminado con éxito'); window.location='mantenedor_seguros.php';</script>";
} else {
    echo "Error al eliminar el seguro: " . mysqli_error($conexion);
}
?>
