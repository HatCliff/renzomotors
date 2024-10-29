<?php
require './../vendor/autoload.php';
require './../config/conexion.php';
require './../components/validationUI.php';
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
 // Transacción Aprobada
    $query = "INSERT INTO reserva_vehiculo (id_vehiculo, rut, fecha_reserva, hora_reserva) 
    VALUES ('$array[id_vehiculo]','$array[rut]','$array[fecha_actual]','$array[hora_actua]')";
    $resultado = mysqli_query($conexion, $query);

    if ($resultado) {
    $num_reserva_vehiculo = mysqli_insert_id($conexion);

    $query = "INSERT INTO registro_reserva (rut_cliente, nombre_cliente, sucursal_reserva, correo_cliente, telefono_cliente,
                metodo_pago, precio_reserva, color_reserva, compra_concretada, num_reserva_vehiculo) 
    VALUES ('$array[rut_compra]', '$array[nombre]', '$array[sucursal]', '$array[correo]', '$array[telefono]', '$array[pago]', '$array[precio]', '$array[color]', NULL, '$num_reserva_vehiculo')";
    $resultado = mysqli_query($conexion, $query);

    } else {
    success(false, "Error en la reserva" . mysqli_error($conexion));
    }
    success(true, "Transacción aprobada");
} else {
 // Transacción rechazada
    success(false, "Transacción rechazada");
}
?>