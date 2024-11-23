<?php
require '../../vendor/autoload.php';
require '../../config/conexion.php';
require '../../components/validationUI.php';
use Transbank\Webpay\WebpayPlus\Transaction;

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$rut_user = $_SESSION['rut'];

// SDK Versión 2.x
$token = $_GET['token_ws'] ?? $_POST['token_ws'] ?? null;
if (!$token) {
    // Revisa más detalles en Revisar más detalles más arriba en los distintos flujos y ejemplos de código de esto en https://github.com/TransbankDevelopers/transbank-sdk-php/examples/webpay-plus/index.php
    die('No es un flujo de pago normal.');
}

$response = (new Transaction)->commit($token);
if ($response->isApproved()) {
    $array = $_SESSION['compra_accesorio'];

    $query_cantidad_compras = "
    SELECT COUNT(*) AS cantidad
    FROM registro_accesorio
    WHERE DATE(fecha_compra_a) = '$array[fecha_compra_a]'";
    $result_compras = mysqli_query($conexion, $query_cantidad_compras);
    $cantidad = mysqli_fetch_assoc($result_compras);

    $codigo_verificador = '';
    $codigo_verificador =
        str_pad($array['sucursal_compra'], 3, '0', STR_PAD_LEFT) .
        date('dmY', strtotime($array['fecha_compra_a'])) .
        str_pad($cantidad['cantidad'], 4, '0', STR_PAD_LEFT);

    $cod_orden = [
        'cod_orden' => $codigo_verificador,
    ];
    $_SESSION['compra_accesorio'][] = $cod_orden;

    $query = "INSERT INTO registro_accesorio
    VALUES ('$cod_orden[cod_orden]', '$array[sucursal_compra]', '$array[correo_compra]', '$array[fecha_compra_a]', '$array[listado_accesorio]', '$array[valor_carrito]', '$array[id_carrito]')";
    $resultado = mysqli_query($conexion, $query);


    if ($resultado) {

        $delete_carro = "DELETE FROM carrito_accesorio WHERE id_carrito = (SELECT id_carrito FROM carrito_usuario WHERE rut_usuario = '$rut_user')";
        $result_delete = mysqli_query($conexion, $delete_carro);

        $update_carro = $conexion->query("UPDATE carrito_usuario SET valor_carrito= 0 WHERE rut_usuario = '$rut_user'");

        require '../../utils/generarboleta_accesorio.php';
        $path = '../../utils/data/boleta/vehiculo/boleta_accesorios_' . $codigo_verificador . '.pdf';
    }

    success(true, botonBoleta($path));
} else {
    $accesorios_array = explode(', ', $accesorios_concatenados);
    foreach ($accesorios_array as $accesorio) {
        list($sku, $cantidad) = explode(':', $accesorio);

        $cantidad = (int) $cantidad;
        $conexion->query("UPDATE accesorio SET stock_accesorio = stock_accesorio + $cantidad WHERE sku_accesorio = '$sku'");
    }
    success(false, "Transacción rechazada");
}
?>