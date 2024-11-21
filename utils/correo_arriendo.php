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

if(!isset($_GET['verificado'])){
    header("Location: ../pages/arriendo.php");
    exit();
}

$correo = $_SESSION['correo'];
$nombre = $_SESSION['nombre'];
$query = "SELECT * FROM registro_arriendo ra
            JOIN arriendo_vehiculo av ON ra.cod_arriendo = av.cod_arriendo
            JOIN vehiculo v ON av.id_vehiculo = v.id_vehiculo
            JOIN vehiculo_sucursal vs ON av.id_vehiculo = vs.id_vehiculo
            JOIN sucursal s ON vs.id_sucursal = s.id_sucursal 
        ORDER BY id_registro_arriendo DESC LIMIT 1";

$datos = mysqli_query($conexion, $query);

if ($datos && mysqli_num_rows($datos) > 0) {
    $datos_reserva = mysqli_fetch_assoc($datos);
    $fecha_inicio = $datos_reserva['fecha_inicio'];
    $fecha_termino = $datos_reserva['fecha_termino'];
    $valor = (float) $datos_reserva['valor_arriendo'];
    $garantia = $datos_reserva['valor_garantia'];
    $auto = $datos_reserva['id_vehiculo'];
    $nombre_modelo = $datos_reserva['nombre_modelo'];
    $nombre_surcusal = $datos_reserva['nombre_sucursal'];
    $direcccion_sucursal = $datos_reserva['direccion_sucursal'];

    // Convertir las fechas a objetos DateTime
    $fechaInicio = new DateTime($fecha_inicio);
    $fechaTermino = new DateTime($fecha_termino);

    // Cambiar el formato de las fechas
    $fecha_inicio_formateada = $fechaInicio->format('d/m/Y'); // Día/Mes/Año
    $fecha_termino_formateada = $fechaTermino->format('d/m/Y'); // Día/Mes/Año

    // Calcular la diferencia entre las fechas
    $diferencia = $fechaInicio->diff($fechaTermino);

    // Obtener la cantidad de días de la diferencia
    $dias = $diferencia->days;

    $total = $valor * $dias;

   // Crear el PDF
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 12);

    // Añadir el contenido al PDF con utf8_decode
    $pdf->Cell(0, 10, utf8_decode("Hola $nombre, tu reserva ha sido completada exitosamente. Gracias por confiar en RenzoMotors."), 0, 1);
    $pdf->Ln(10);
    $pdf->Cell(0, 10, utf8_decode("Aquí están los detalles:"), 0, 1);
    $pdf->Ln(5);

    // Encabezados de la tabla
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(50, 10, utf8_decode('Detalle'), 1, 0, 'C');
    $pdf->Cell(100, 10, utf8_decode('Información'), 1, 1, 'C');

    // Volver a la fuente normal para el contenido de la tabla
    $pdf->SetFont('Arial', '', 12);

    // Fila 1
    $pdf->Cell(50, 10, utf8_decode('Fecha inicio:'), 1);
    $pdf->Cell(100, 10, utf8_decode($fecha_inicio_formateada), 1, 1);

    // Fila 2
    $pdf->Cell(50, 10, utf8_decode('Fecha término:'), 1);
    $pdf->Cell(100, 10, utf8_decode($fecha_termino_formateada), 1, 1);

    // Fila 3
    $pdf->Cell(50, 10, utf8_decode('Precio a pagar:'), 1);
    $pdf->Cell(100, 10, utf8_decode("$total (se paga en sucursal)"), 1, 1);

    // Fila 4
    $pdf->Cell(50, 10, utf8_decode('Garantía:'), 1);
    $pdf->Cell(100, 10, utf8_decode("$garantia (debe ser pagada con tarjeta de crédito)"), 1, 1);

    // Fila 5
    $pdf->Cell(50, 10, utf8_decode('Auto arrendado:'), 1);
    $pdf->Cell(100, 10, utf8_decode($nombre_modelo), 1, 1);

    $pdf->Ln(10); // Espacio adicional después de la tabla

    // Fila 6: Nombre de la sucursal
    $pdf->Cell(50, 10, utf8_decode('Sucursal:'), 1);
    $pdf->Cell(100, 10, utf8_decode($nombre_surcusal), 1, 1);

    // Fila 7: Dirección de la sucursal (usando MultiCell para manejar texto largo)
    $pdf->Cell(50, 10, utf8_decode('Dirección:'), 1);
    $pdf->MultiCell(100, 10, utf8_decode($direcccion_sucursal), 1, 'L');  // Usamos MultiCell para que el texto largo se ajuste

    $pdf->Ln(10); // Espacio adicional después de la tabla

    // Añadir el mensaje de retiro
    $pdf->SetFont('Arial', '', 12);
    $pdf->MultiCell(0, 10, utf8_decode(
        "Por favor, recuerda retirar el vehículo en la sucursal $nombre_surcusal ubicada en $direcccion_sucursal el día $fecha_inicio_formateada. ¡Gracias por elegir RenzoMotors!"
    ));

    // Guardar el PDF en un archivo temporal
    $pdfOutput = __DIR__ . '/data/reserva_' . time() . '.pdf';
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
    $mail->Subject = 'Confirmacion de Reserva';
    $mail->Body    = "Hola $nombre,\n\nTu reserva ha sido completada exitosamente. Gracias por confiar en RenzoMotors. Adjunto encontrarás el PDF con los detalles de tu reserva.\n\nSaludos,\nRenzoMotors";

    // Adjuntar el archivo PDF
    $mail->addAttachment($pdfOutput);

    // Enviar el correo
    $mail->send();

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