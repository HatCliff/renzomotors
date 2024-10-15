<?php 
include '../../../config/conexion.php';

$id_tipo_rueda = $_GET['id'];
//eliminar elemento del mantenedor
$query_eliminar_tipo_rueda = "DELETE FROM tipo_rueda WHERE id_tipo_rueda = $id_tipo_rueda";
$resultado = mysqli_query($conexion, $query_eliminar_tipo_rueda);

if ($resultado) {
    echo "<script>alert('Tipo de rueda eliminado con éxito'); window.location='mantenedor_ruedas.php';</script>";
} else {
    echo "Error: " . mysqli_error($conexion);
}
?>
