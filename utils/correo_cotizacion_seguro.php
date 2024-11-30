<?php
session_start();
require('../config/conexion.php');
require('../vendor/autoload.php');

$carpetaMain = 'http://localhost/xampp/renzomotors/';
use Fpdf\Fpdf;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Verificar sesión del usuario
if (!isset($_SESSION['correo']) || !isset($_SESSION['nombre'])) {
    echo "<script>alert('Error: No se encontró la información del usuario.'); window.location.href = '../pages/login.php';</script>";
    exit();
}

if (!isset($_GET['verificado'])) {
    header("Location: ../pages/c_seguro/seguro.php");
    exit();
}

$correo = $_SESSION['correo'];
$nombre = $_SESSION['nombre'];
$rut = $_SESSION['rut'];

// Consulta para obtener los detalles del seguro
$query = "
    SELECT us.rut, us.id_seguro, us.telefono, us.marca_s, us.modelo_s, us.patente, us.numero_motor, us.numero_chasis, 
           us.anio_s, us.fecha_inicio_con, us.fecha_termino_cont, s.nombre_seguro, s.descripcion_seguro, s.precio_seguro 
    FROM usuario_seguro us
    JOIN seguro s ON us.id_seguro = s.id_seguro
    WHERE us.rut = '$rut' 
    ORDER BY us.id_contratacion_seguro DESC
    LIMIT 1
    
";

$resultado = mysqli_query($conexion, $query);

// Manejo de errores en la consulta recien agregago
if (!$resultado) {
    echo "Error en la consulta SQL: " . mysqli_error($conexion);
    exit();
}

if ($resultado && mysqli_num_rows($resultado) > 0) {
    $detalle_seguro = mysqli_fetch_assoc($resultado);

    $nombre_seguro = $detalle_seguro['nombre_seguro'];
    $descripcion_seguro = $detalle_seguro['descripcion_seguro'];
    $precio_seguro = number_format($detalle_seguro['precio_seguro'], 0, ',', '.') . ' CLP';
    $fecha_inicio = date('d/m/Y', strtotime($detalle_seguro['fecha_inicio_con']));
    $fecha_termino = date('d/m/Y', strtotime($detalle_seguro['fecha_termino_cont']));
    $marca = $detalle_seguro['marca_s'];
    $modelo = $detalle_seguro['modelo_s'];
    $patente = $detalle_seguro['patente'];
    $numero_motor = $detalle_seguro['numero_motor'];
    $numero_chasis = $detalle_seguro['numero_chasis'];
    // Crear el PDF
    $pdf = new FPDF();
    $pdf->AddPage();

    // Crear el PDF
    $pdf = new FPDF();
    $pdf->AddPage();

    //  logo 
    $logoPath = $carpetaMain . "logo.png";
    $pdf->Image($logoPath, 5, 5, 10); // x, y, ancho (ajusta según necesites)

    // Espaciado después del logo
    //$pdf->Ln(10);
    $pdf->Ln(10);
    $pdf->SetFont('Arial', 'B', 12);

    // Obtener el ancho del texto
    $text = 'Cotización de Seguro';
    $textWidth = $pdf->GetStringWidth($text);

    // Calcular la posición X para centrar el texto
    $pageWidth = $pdf->GetPageWidth();
    $x = ($pageWidth - $textWidth) / 2; // Centrado

    // Colocar el texto en el centro de la página
    $pdf->SetX($x);
    $pdf->Cell($textWidth, 10, $text, 0, 1, 'C');
    $pdf->Ln(10);


    //Detalle cotizacion
$pdf->SetFont('Arial', 'B', 12);

// Anchos de las celdas de la tabla
$cellWidth1 = 50; // Detalle
$cellWidth2 = 100; // Información

// Calcular el ancho total de la tabla
$tableWidth = $cellWidth1 + $cellWidth2;

// Calcular la posición X para centrar la tabla
$pageWidth = $pdf->GetPageWidth();
$x = ($pageWidth - $tableWidth) / 2; // Centrado

// Colocar la tabla en la página
$pdf->SetX($x);
$pdf->Cell($cellWidth1, 10, utf8_decode('Detalle'), 1, 0, 'C');
$pdf->Cell($cellWidth2, 10, utf8_decode('Información'), 1, 1, 'C');

$pdf->SetFont('Arial', '', 12);
$pdf->SetX($x);
$pdf->Cell($cellWidth1, 10, utf8_decode('Seguro:'), 1);
$pdf->Cell($cellWidth2, 10, utf8_decode($nombre_seguro), 1, 1);

$descripcion_altura = $pdf->GetStringWidth($descripcion_seguro) > $cellWidth2
    ? $pdf->NbLines($cellWidth2, utf8_decode($descripcion_seguro)) * 10
    : 10;

$pdf->SetX($x);
$pdf->Cell($cellWidth1, $descripcion_altura, utf8_decode('Descripción:'), 1, 0, 'L');
$pdf->MultiCell($cellWidth2, 10, utf8_decode($descripcion_seguro), 1, 'L');

$pdf->SetX($x);
$pdf->Cell($cellWidth1, 10, utf8_decode('Precio desde:'), 1);
$pdf->Cell($cellWidth2, 10, utf8_decode($precio_seguro), 1, 1);

$pdf->SetX($x);
$pdf->Cell($cellWidth1, 10, utf8_decode('Fecha consulta:'), 1);
$pdf->Cell($cellWidth2, 10, utf8_decode($fecha_inicio), 1, 1);

$pdf->SetX($x);
$pdf->Cell($cellWidth1, 10, utf8_decode('Vehículo:'), 1);
$pdf->Cell($cellWidth2, 10, utf8_decode("$marca $modelo"), 1, 1);

$pdf->SetX($x);
$pdf->Cell($cellWidth1, 10, utf8_decode('Patente:'), 1);
$pdf->Cell($cellWidth2, 10, utf8_decode($patente), 1, 1);

$pdf->SetX($x);
$pdf->Cell($cellWidth1, 10, utf8_decode('Número motor:'), 1);
$pdf->Cell($cellWidth2, 10, utf8_decode($numero_motor), 1, 1);

$pdf->SetX($x);
$pdf->Cell($cellWidth1, 10, utf8_decode('Número chasis:'), 1);
$pdf->Cell($cellWidth2, 10, utf8_decode($numero_chasis), 1, 1);

// Pie de página
date_default_timezone_set("America/Santiago");
$pdf->SetFont('Arial', 'I', 8);
$pdf->Cell(0, 10, utf8_decode('Documento generado automáticamente. Fecha: ' . date("d-m-Y")), 0, 0, 'C');

    //

    $pdf->Ln(10);
    #guardar el PDF con un nombre
    $pdfOutput = __DIR__ . '/data/cotizacion_' . time() . '.pdf';
    $pdf->Output('F', $pdfOutput);

    // Enviar el correo
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

        $mail->Subject = 'Cotización de Seguro';
        $mail->Body = "Hola $nombre,\n\nAdjunto encontrarás los detalles de tu cotización de seguro.\n\nSaludos,\nRenzoMotors";
        $mail->addAttachment($pdfOutput);
        $mail->send();

        echo "<!DOCTYPE html>
        <html lang='es'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>Confirmación de cotización de seguro</title>
            <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css' rel='stylesheet'>
        </head>
        <body class='d-flex justify-content-center align-items-center vh-100 bg-light'>
            <div class='alert alert-success text-center shadow-lg rounded' style='max-width: 600px;'>
                <h4 class='alert-heading mb-4'>¡Cotizacion de seguro Completada!</h4>
                <p class='fs-5'>Hola $nombre, tu cotización ha sido completada exitosamente. Recibirás un correo con los detalles de la cotización</p>
                <hr class='my-4'>
                <p class='text-muted'>Gracias por confiar en RenzoMotors.</p>
                <a class='btn btn-success mt-3' href='{$carpetaMain}index.php' role='button'>Volver a Inicio</a>
            </div>
        </body>
        </html>";
    } catch (Exception $e) {
        echo "Error al enviar el correo: {$mail->ErrorInfo}";
    }
} else {
    echo "No se encontraron datos de cotización.";
    exit();
}
