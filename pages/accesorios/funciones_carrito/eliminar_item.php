<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include '../../../config/conexion.php';


$rut_user = $_SESSION['rut'];
$sku = $_GET['sku'];

$query = "DELETE FROM carrito_accesorio 
                WHERE sku_accesorio='$sku' 
                AND id_carrito = (SELECT id_carrito FROM carrito_usuario WHERE '$rut_user' = rut_usuario)";
$resultado = mysqli_query($conexion, $query);

if ($resultado) {
    header('location: ../carrito_accesorio.php');
} else {
    echo "Error al eliminar el accesorio: " . mysqli_error($conexion);
}
?>
