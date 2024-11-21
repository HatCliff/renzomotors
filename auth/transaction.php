<?php

//Logica transbank

include('../vendor/autoload.php');

use Transbank\Webpay\WebpayPlus\Transaction;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    $user = $_SESSION['usuario'];
     // Obtencion de las zona horarias para guardar fecha y hora
    date_default_timezone_set('America/Santiago');
    
    $buyOrder = rand(100000, 999999);
    $_SESSION['compra'] = [
        'id_vehiculo' => $_POST['id_vehiculo'],
        'rut' => $user['rut'],
        'rut_compra' => $_POST['rut'],
        'nombre' => $_POST['nombre'],
        'correo' => $_POST['correo'],
        'telefono' => $_POST['telefono'],
        'color' => $_POST['color'],
        'sucursal' => $_POST['id_sucursal'],
        'precio' => $_POST['precio'],
        'compra' => 'NULL',
        'pago' => 'NULL',
        'orden_compra' => $buyOrder,
        'fecha_actual' => date('Y-m-d'),
        'hora_actua' => date('H:i:s')
    ];

    //$amount = $_SESSION['compra']['precio'];
        // Transbank
        $transaction = new Transaction();
        $amount = $_SESSION['compra']['precio'];

        $sessionId = uniqid();

        $returnUrl = 'http:localhost/xampp/renzomotors/pages/reserva_completada.php';
        $response = $transaction->create($buyOrder, $sessionId, $amount, $returnUrl);


        $response->getUrl();
        $response->getToken();
        //PARA DEBUG: print_r($response);

        //Enviar a la url con el token sin que el usuario haga click
        $finalUrl = $response->getUrl().'?token_ws='.$response->getToken(); 

        echo "<script>window.location='$finalUrl';</script>";
   
}
?>