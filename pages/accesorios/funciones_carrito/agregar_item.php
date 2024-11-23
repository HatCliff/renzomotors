<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include '../../../config/conexion.php';

$rut_user = $_SESSION['rut'];
$sku = $_GET['sku'];

$query = "INSERT INTO carrito_accesorio VALUES (
            (SELECT id_carrito FROM carrito_usuario WHERE rut_usuario = '$rut_user'), '$sku', 1
            )";
$resultado = mysqli_query($conexion, $query);

if ($resultado) {
    $precio_query = "SELECT SUM(cantidad_accesorio * precio_accesorio) AS precio 
                     FROM accesorio a 
                     JOIN carrito_accesorio ca ON a.sku_accesorio = ca.sku_accesorio 
                     WHERE ca.id_carrito = (SELECT id_carrito FROM carrito_usuario WHERE rut_usuario = '$rut_user')";

    $resultado_precio = $conexion->query($precio_query);

    if ($resultado_precio) {
        $fila = $resultado_precio->fetch_assoc();
        $precio_total = $fila['precio'] ?? 0;

        // Actualizar en la tabla carrito_usuario
        $conexion->query("UPDATE carrito_usuario SET valor_carrito = $precio_total WHERE rut_usuario = '$rut_user'");
        header('location: ../buscador_accesorio.php');
    }
    
}

?>