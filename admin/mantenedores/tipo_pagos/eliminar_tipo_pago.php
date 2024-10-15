<?php 
include '../../../config/conexion.php';


$id_tipo_pago = $_GET['id'];
//eliminar elemento del mantenedor
$query_eliminar_tipo_pago = "DELETE FROM tipos_pago WHERE id_tipo_pago = $id_tipo_pago";
$resultado = mysqli_query($conexion, $query_eliminar_tipo_pago);

if ($resultado) {
    echo "<script>alert('Tipo de pago eliminado con éxito'); window.location='mantenedor_tipo_pagos.php';</script>";
} else {
    echo "Error: " . mysqli_error($conexion);
}
?>
