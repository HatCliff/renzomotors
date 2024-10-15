<?php 
include '../../../config/conexion.php';

$id_seguro = $_GET['id'];
$query = "DELETE FROM seguros WHERE id_seguro = $id_seguro";
$resultado = mysqli_query($conexion, $query);
//eliminar el elemento del mantedor
if ($resultado) {
    echo "<script>alert('Seguro eliminado con éxito'); window.location='mantenedor_seguros.php';</script>";
} else {
    echo "Error al eliminar el seguro: " . mysqli_error($conexion);
}
?>
