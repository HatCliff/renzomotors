<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include '../../../config/conexion.php';

$rut_user = $_SESSION['rut'];
$sku = $_POST['sku'];

// Eliminar el artículo del carrito
$query = "DELETE FROM carrito_accesorio 
          WHERE sku_accesorio='$sku' 
          AND id_carrito = (SELECT id_carrito FROM carrito_usuario WHERE '$rut_user' = rut_usuario)";
$resultado = mysqli_query($conexion, $query);

header('Content-Type: application/json');

// Código de eliminación del artículo...
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

        echo json_encode(['success' => true, 'valor_carrito' => number_format($precio_total, 0, ',', '.')]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al calcular el precio']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Error al eliminar el accesorio']);
}

?>
