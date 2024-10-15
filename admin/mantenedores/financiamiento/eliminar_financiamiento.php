<?php 
include '../../../config/conexion.php';

//eliminar elemento del mantendor

$id = $_GET['id'];
$query = "DELETE FROM financiamiento WHERE id_financiamiento = $id";
$resultado = mysqli_query($conexion, $query);

if ($resultado) {
    echo "<script>alert('Financiamiento eliminado con éxito'); window.location='mantenedor_financiamientos.php';</script>";
} else {
    echo "Error al eliminar el financiamiento: " . mysqli_error($conexion);
}
?>
