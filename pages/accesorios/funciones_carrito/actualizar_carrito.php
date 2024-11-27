<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include('../../../config/conexion.php');

    $rut = $_SESSION['rut'];
    $sku = $_POST['sku'];
    $cantidad = $_POST['cantidad_accesorio'];

    // Consulta para actualizar la cantidad del accesorio en el carrito
    $query = "UPDATE carrito_accesorio SET cantidad_accesorio = ? WHERE sku_accesorio = ? AND id_carrito = (SELECT id_carrito FROM carrito_usuario WHERE rut_usuario = ?)";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param('iss', $cantidad, $sku, $rut);

    $response = [];
    if ($stmt->execute()) {
        $precio_query = "SELECT SUM(cantidad_accesorio * precio_accesorio) AS precio 
                         FROM accesorio a 
                         JOIN carrito_accesorio ca ON a.sku_accesorio = ca.sku_accesorio 
                         WHERE ca.id_carrito = (SELECT id_carrito FROM carrito_usuario WHERE rut_usuario = ?)";
        $precio_stmt = $conexion->prepare($precio_query);
        $precio_stmt->bind_param('s', $rut);
        $precio_stmt->execute();
        $precio_result = $precio_stmt->get_result();
        $precio_row = $precio_result->fetch_assoc();
        $nuevo_valor = $precio_row['precio'];

        // Actualiza el valor total del carrito
        $update_total_query = "UPDATE carrito_usuario SET valor_carrito = ? WHERE rut_usuario = ?";
        $update_total_stmt = $conexion->prepare($update_total_query);
        $update_total_stmt->bind_param('ds', $nuevo_valor, $rut);
        $update_total_stmt->execute();

        $response['success'] = true;
        $response['nuevo_valor'] = number_format($nuevo_valor, 0, ',', '.');
    } else {
        $response['success'] = false;
        $response['error'] = $stmt->error;
    }

    echo json_encode($response);
}
?>
