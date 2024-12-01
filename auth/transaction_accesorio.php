<?php
include('../config/conexion.php');
include('../vendor/autoload.php');
use Transbank\Webpay\WebpayPlus\Transaction;


if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$user = $_SESSION['usuario'];
$rut_user = $_SESSION['rut'];
// Obtención de la zona horaria para guardar la fecha y hora
date_default_timezone_set('America/Santiago');

$listado = "SELECT ca.sku_accesorio, ca.cantidad_accesorio
                FROM carrito_accesorio ca
                JOIN carrito_usuario cu ON ca.id_carrito = cu.id_carrito
                WHERE cu.rut_usuario = '$rut_user'";
$result_listado = $conexion->query($listado);

$accesorios_concatenados = '';
while ($producto = mysqli_fetch_assoc($result_listado)) {
    $sku = $producto['sku_accesorio'];
    $cantidad = $producto['cantidad_accesorio'];
    $accesorios_concatenados .= $sku . ':' . $cantidad . ', ';

    $conexion->query("UPDATE accesorio SET stock_accesorio = stock_accesorio - $cantidad WHERE sku_accesorio = '$sku'");
}
$cadena_concatenada = rtrim($accesorios_concatenados, ', '); // Usar la variable correcta

$result_compra_a = $conexion->query("SELECT id_carrito, valor_carrito FROM carrito_usuario WHERE rut_usuario = '$rut_user'");
$datos_compra_a = mysqli_fetch_array($result_compra_a);

$buyOrder = rand(100000, 999999);

$fecha = date('Y-m-d');
$query_cantidad_compras = "
    SELECT COUNT(*) AS cantidad
    FROM registro_accesorio
    WHERE DATE(fecha_compra_a) = '$fecha'";
$result_compras = mysqli_query($conexion, $query_cantidad_compras);
$cantidad_compra = mysqli_fetch_assoc($result_compras);

$codigo_verificador = '';
$codigo_verificador =
    str_pad($_GET['suc'], 3, '0', STR_PAD_LEFT) .
    date('dmY', strtotime($fecha)) .
    str_pad($cantidad_compra['cantidad'], 4, '0', STR_PAD_LEFT);

$_SESSION['compra_accesorio'] = [
    'sucursal_compra' => $_GET['suc'],
    'id_carrito' => $datos_compra_a['id_carrito'],
    'valor_carrito' => $datos_compra_a['valor_carrito'],
    'listado_accesorio' => $accesorios_concatenados,
    'fecha_compra_a' => $fecha,
    'correo_compra' => $user['correo'],
    'cantidad_compras' => $cantidad,
    'cod_compra' => $codigo_verificador,
];

$transaction = new Transaction();
$amount = $_SESSION['compra_accesorio']['valor_carrito'];

$sessionId = uniqid();
$returnUrl = 'http:localhost/xampp/renzomotors/pages/accesorios/compra_accesorio.php';
$response = $transaction->create($buyOrder, $sessionId, $amount, $returnUrl);

// Obtener URL y Token
$url = $response->getUrl();
$token = $response->getToken();

$finalUrl = $response->getUrl() . '?token_ws=' . $response->getToken();
echo "<script>window.location='$finalUrl';</script>";

