<?php
include('../../../config/conexion.php');
session_start();

$rut_user = $_SESSION['rut'];

// Consulta para obtener los productos en el carrito del usuario
$query_carrito = "
    SELECT ca.sku_accesorio, ca.cantidad_accesorio, a.stock_accesorio, a.nombre_accesorio
    FROM carrito_accesorio ca
    JOIN accesorio a ON ca.sku_accesorio = a.sku_accesorio
    WHERE ca.id_carrito = (SELECT id_carrito FROM carrito_usuario WHERE rut_usuario = '$rut_user')";

$result_carrito = mysqli_query($conexion, $query_carrito);

$errores = [];
while ($producto = mysqli_fetch_assoc($result_carrito)) {
    $sku = $producto['sku_accesorio'];
    $nombre = $producto['nombre_accesorio'];
    $cantidad_solicitada = $producto['cantidad_accesorio'];
    $stock_disponible = $producto['stock_accesorio'];

    if ($cantidad_solicitada > $stock_disponible) {
        if ($stock_disponible == 0) {
            $mensaje = "Lo sentimos, producto <strong>(SKU: {$sku}) {$nombre}</strong> agotado";
        } else {
            $mensaje = "<strong>(SKU: {$sku}) {$nombre}</strong>: Stock mayor al disponible.";
        }

        $errores[] = [
            'sku' => $sku,
            'nombre' => $nombre,
            'stock' => $stock_disponible,
            'cantidad' => $cantidad_solicitada,
            'mensaje' => $mensaje,
        ];
    }
}

if (!empty($errores)) {
    echo json_encode(['success' => false, 'errors' => $errores]);
    exit();
}

echo json_encode(['success' => true]);
exit();
?>