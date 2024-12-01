<?php
require('../../config/conexion.php');
require('../../vendor/autoload.php');

$carpetaMain = 'http://localhost/xampp/renzomotors/';
use Fpdf\Fpdf;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function enviarCorreo($correo, $ruta_pdf) {
    $mail = new PHPMailer;
    $ruta_absoluta = 'C:/xampp/htdocs/xampp' . $ruta_pdf;
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
    
        // Definir el asunto y el cuerpo del mensaje
        $mail->Subject = 'Boleta de compra';
        $mail->Body    = 'Gracias por tu compra. Adjuntamos tu boleta.';
    
        // Verificar si el archivo existe antes de adjuntarlo
        if (!file_exists($ruta_absoluta)) {
            echo "El archivo PDF no se encuentra en la ruta especificada. 
                    $ruta_absoluta";
        } else {
            $mail->addAttachment($ruta_absoluta);  // Adjuntar el archivo PDF
        }
    
        // Enviar el correo
        $mail->send();
    
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}


?>