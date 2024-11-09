<?php
session_start();
require('../config/conexion.php');
require('../vendor/autoload.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

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

        $mail->Subject = 'compra';
        $mail->Body = 'Hola';
        

        $mail->send();
    }catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }

?>