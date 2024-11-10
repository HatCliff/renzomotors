<?php
session_start();
require('../config/conexion.php');
require('../vendor/autoload.php');

$carpetaMain = 'http://localhost/xampp/renzomotors/';
use Fpdf\Fpdf;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (!isset($_SESSION['correo']) || !isset($_SESSION['nombre'])) {
    echo "<script>alert('Error: No se encontró la información del usuario.'); window.location.href = '../pages/login.php';</script>";
    exit();
}

$correo = $_SESSION['correo'];
$nombre = $_SESSION['nombre'];
$query = "SELECT * FROM registro_arriendo ORDER BY id_registro_arriendo DESC LIMIT 1";
$datos = mysqli_query($conexion, $query);

if ($datos && mysqli_num_rows($datos) > 0) {
    $datos_reserva = mysqli_fetch_assoc($datos);
    $fecha_inicio = $datos_reserva['fecha_inicio'];
    $fecha_termino = $datos_reserva['fecha_termino'];
    $valor = $datos_reserva['valor'];
    $garantia = $datos_reserva['garantia'];
    $auto = $datos_reserva['id_vehiculo'];

    // Convertir las fechas a objetos DateTime
    $fechaInicio = new DateTime($fecha_inicio);
    $fechaTermino = new DateTime($fecha_termino);

    // Calcular la diferencia entre las fechas
    $diferencia = $fechaInicio->diff($fechaTermino);

    // Obtener la cantidad de días de la diferencia
    $dias = $diferencia->days;

    $total = $valor * $dias;

    // Realiza la segunda consulta para obtener el nombre del modelo
    $query_consulta = "SELECT nombre_modelo FROM vehiculo WHERE id_vehiculo = $auto";
    $datos_auto = mysqli_query($conexion, $query_consulta);

    if ($datos_auto && mysqli_num_rows($datos_auto) > 0) {
        $auto_reserva = mysqli_fetch_assoc($datos_auto);
        $nombre_modelo = $auto_reserva['nombre_modelo'];
    } else {
        $nombre_modelo = "Modelo no encontrado";
    }

    // Crear el PDF
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 12);

    // Añadir el contenido al PDF
    $pdf->Cell(0, 10, "Hola $nombre, tu reserva ha sido completada exitosamente. Gracias por confiar en RenzoMotors.", 0, 1);
    $pdf->Ln(10);
    $pdf->Cell(0, 10, "Aquí están los detalles:", 0, 1);
    $pdf->Ln(5);
    $pdf->Cell(0, 10, "Fecha inicio: $fecha_inicio", 0, 1);
    $pdf->Cell(0, 10, "Fecha término: $fecha_termino", 0, 1);
    $pdf->Cell(0, 10, "Precio a pagar es de: $total (se paga en sucursal)", 0, 1);
    $pdf->Cell(0, 10, "Garantía: $garantia (debe ser pagada con tarjeta de crédito)", 0, 1);
    $pdf->Cell(0, 10, "Auto arrendado: $nombre_modelo", 0, 1);

    // Guardar el PDF en un archivo temporal
    $pdfOutput = 'reserva_' . time() . '.pdf';
    $pdf->Output('F', $pdfOutput);

} else {
    echo "Error: No se encontraron registros de reserva.";
    exit();
}

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

    // Definir el asunto y el cuerpo del mensaje
    $mail->Subject = 'Confirmación de Reserva';
    $mail->Body    = "Hola $nombre,\n\nTu reserva ha sido completada exitosamente. Gracias por confiar en RenzoMotors. Adjunto encontrarás el PDF con los detalles de tu reserva.\n\nSaludos,\nRenzoMotors";

    // Adjuntar el archivo PDF
    $mail->addAttachment($pdfOutput);

    // Enviar el correo
    $mail->send();

    // Eliminar el archivo PDF temporal después de enviarlo
    unlink($pdfOutput);

    // Mostrar mensaje de éxito en la página
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