<?php
require './../vendor/autoload.php';
require './../config/conexion.php';
require './../components/validationUI.php';
use Transbank\Webpay\WebpayPlus\Transaction;

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}


// SDK Versión 2.x
$token = $_GET['token_ws'] ?? $_POST['token_ws'] ?? null;
if (!$token) {
    // Revisa más detalles en Revisar más detalles más arriba en los distintos flujos y ejemplos de código de esto en https://github.com/TransbankDevelopers/transbank-sdk-php/examples/webpay-plus/index.php
    die('No es un flujo de pago normal.');
}

$response = (new Transaction)->commit($token); // ó cualquiera de los métodos detallados en el ejemplo anterior del método create.
if ($response->isApproved()) {
    if (isset($_SESSION['processed_token']) && $_SESSION['processed_token'] === $token) {

    } else {
        $_SESSION['processed_token'] = $token;

        $array = $_SESSION['compra'];
        // Transacción Aprobada
        $query_rv = "INSERT INTO reserva_vehiculo (id_vehiculo, rut, fecha_reserva, hora_reserva) 
        VALUES ('$array[id_vehiculo]','$array[rut]','$array[fecha_actual]','$array[hora_actua]')";
        $resultado_rv = mysqli_query($conexion, $query_rv);

        if ($resultado_rv) {
            $num_reserva_vehiculo = mysqli_insert_id($conexion);

            $query_rr = "INSERT INTO registro_reserva (rut_cliente, nombre_cliente, sucursal_reserva, correo_cliente, telefono_cliente,
                    metodo_pago, precio_reserva, color_reserva, compra_concretada, num_reserva_vehiculo) 
        VALUES ('$array[rut_compra]', '$array[nombre]', '$array[sucursal]', '$array[correo]', '$array[telefono]', '$array[pago]', '$array[precio]', '$array[color]', NULL, '$num_reserva_vehiculo')";
            $resultado_rr = mysqli_query($conexion, $query_rr);

            $cantidad = "UPDATE vehiculo SET cantidad_vehiculo = cantidad_vehiculo - 1 WHERE id_vehiculo = $array[id_vehiculo]";
            $result_cantidad = $conexion->query($cantidad);

        } else {
            success(false, "Error en la reserva" . mysqli_error($conexion));
        }
    }

    require './../utils/generarboleta.php';
    $path = 'C:\xampp\htdocs\xampp\renzomotors\utils\data\boleta\vehiculo\boleta_' . $array['orden_compra'] . '.pdf';
    //
    success(true, botonBoleta($path));
} else {
    // Transacción rechazada
    success(false, "Transacción rechazada");
}
?>
a