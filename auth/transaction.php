<?php

//Logica transbank

include('../vendor/autoload.php');

use Transbank\Webpay\WebpayPlus\Transaction;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    session_start();
     // Obtencion de las zona horarias para guardar fecha y hora
    date_default_timezone_set('America/Santiago');
    $_SESSION['compra'] = [
        'id_vehiculo' => $_POST['id_vehiculo'],
        'rut' => '216379020',
        'rut_compra' => $_POST['rut'],
        'nombre' => $_POST['nombre'],
        'correo' => $_POST['correo'],
        'telefono' => $_POST['telefono'],
        'color' => $_POST['color'],
        'sucursal' => $_POST['id_sucursal'],
        'precio' => $_POST['precio'],
        'compra' => 'NULL',
        'pago' => 'Credito',
        'fecha_actual' => date('Y-m-d'),
        'hora_actua' => date('H:i:s')
    ];

    $amount = $_SESSION['compra']['precio'];
        // Transbank
        $transaction = new Transaction();
        $amount = $_SESSION['compra']['precio'];

        $buyOrder = rand(100000, 999999);
        $sessionId = uniqid();

        $returnUrl = 'http:localhost/xampp/renzomotors/pages/reserva_completada.php';
        $response = $transaction->create($buyOrder, $sessionId, $amount, $returnUrl);


        $response->getUrl();
        $response->getToken();
        //PARA DEBUG: print_r($response);

        //Enviar a la url con el token sin que el usuario haga click
        $finalUrl = $response->getUrl().'?token_ws='.$response->getToken(); 

        echo "<script>window.location='$finalUrl';</script>";
    // Guardar el registro
    /*
    $query = "INSERT INTO reserva_vehiculo (id_vehiculo, rut, fecha_reserva, hora_reserva) 
            VALUES ('$id_vehiculo','$rut','$fecha_actual','$hora_actual')";
    $resultado = mysqli_query($conexion, $query);

    if ($resultado) {
        $num_reserva_vehiculo = mysqli_insert_id($conexion);

        $query = "INSERT INTO registro_reserva (rut_cliente, nombre_cliente, sucursal_reserva, correo_cliente, telefono_cliente,
                        metodo_pago, precio_reserva, color_reserva, compra_concretada, num_reserva_vehiculo) 
        VALUES ('$rut_compra', '$nombre', '$sucursal', '$correo', '$telefono', '$pago', '$precio', '$color', NULL, '$num_reserva_vehiculo')";
        $resultado = mysqli_query($conexion, $query);
        
    } else {
        echo "Error en la reserva" . mysqli_error($conexion);
    }
        */
}
?>