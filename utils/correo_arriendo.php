<?php
session_start();
require('../config/conexion.php');
require('../vendor/autoload.php');

$carpetaMain = 'http://localhost/xampp/renzomotors/';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (!isset($_SESSION['correo']) || !isset($_SESSION['nombre'])) {
    echo "<script>alert('Error: No se encontró la información del usuario.'); window.location.href = '../pages/login.php';</script>";
    exit();
}

$correo = $_SESSION['correo'];
$nombre = $_SESSION['nombre'];

$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'renzomotors08@gmail.com';
    $mail->Password = 'lhkxtvloaecotvea';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    $mail->setFrom('renzomotors08@gmail.com', 'RenzoMotors');
    $mail->addAddress($correo);

    $mail->Subject = 'Confirmación de Reserva';
    $mail->Body = "Hola $nombre, tu reserva ha sido completada exitosamente. Gracias por confiar en RenzoMotors.";

    $mail->send();

    // Muestra la estructura completa de la página con Bootstrap
    echo "<!DOCTYPE html>
    <html lang='es'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Confirmación de Reserva</title>
        <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css' rel='stylesheet'>
    </head>
    <body class='d-flex justify-content-center align-items-center vh-100 bg-light'>
        <div class='alert alert-success text-center' style='max-width: 600px;'>
            <h4 class='alert-heading'>Reserva Completada!</h4>
            <p>Hola $nombre, tu reserva ha sido completada exitosamente. Recibirás un correo de confirmación.</p>
            <hr>
            <p class='mb-0'>Gracias por confiar en RenzoMotors.</p>
            <a class='btn btn-primary mt-3' href='{$carpetaMain}index.php' role='button'>Volver a Inicio</a>
        </div>
    </body>
    </html>";
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
?>