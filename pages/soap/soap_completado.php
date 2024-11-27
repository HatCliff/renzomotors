<?php
require '../../vendor/autoload.php';
require '../../config/conexion.php';
require '../../components/validationUI.php';
use Transbank\Webpay\WebpayPlus\Transaction;

session_start();


// SDK Versión 2.x
$token = $_GET['token_ws'] ?? $_POST['token_ws'] ?? null;
if (!$token) {
    // Revisa más detalles en Revisar más detalles más arriba en los distintos flujos y ejemplos de código de esto en https://github.com/TransbankDevelopers/transbank-sdk-php/examples/webpay-plus/index.php
    die ('No es un flujo de pago normal.');  
}

$response = (new Transaction)->commit($token); // ó cualquiera de los métodos detallados en el ejemplo anterior del método create.
if ($response->isApproved()) {
    $array = $_SESSION['compra'];
    require '../../utils/generar_boleta_soap.php';
    $path = 'C:\xampp\htdocs\xampp\renzomotors\utils\data\boleta\soap\boleta_'.$array['orden_compra'].'.pdf';
    //
    success(true, botonBoleta($path));
} else {
 // Transacción rechazada
    success(false, "Transacción rechazada");
}
session_abort();
?>