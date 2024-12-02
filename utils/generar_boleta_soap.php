<?php
require '../../vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Fpdf\Fpdf;
$correo = $_SESSION['correo'];
$nombre = $_SESSION['nombre'];

// Logo de la web
$pdf = new FPDF();
$pdf->AddPage();
$pdf->Image('../../logo_tr.png', 10, 20, 30); // Posición x, y, y ancho del logo
$pdf->SetFont('Arial', 'B', 16);

// Título centrado con relleno
$pdf->SetFillColor(200, 220, 255);
$pdf->Cell(0, 10, 'Comprobante de Pago - SOAP', 0, 1, 'C', true);
$pdf->Ln(10);
// Configuración de fuente inicial
$pdf->SetFont('Arial', '', 12);

// Fecha y Hora
$pdf->SetFillColor(240, 240, 240);
$pdf->Cell(0, 10, utf8_decode('Fecha: ' . $_SESSION['compra']['fecha_actual']), 0, 1, 'R');
$pdf->Cell(0, 10, utf8_decode('Hora: ' . $_SESSION['compra']['hora_actual']), 0, 1, 'R');
$pdf->Ln(5);

// Información del Cliente
$pdf->SetFont('Arial', 'B', 14);
$pdf->SetFillColor(230, 230, 230);
$pdf->Cell(0, 10, 'Datos del Cliente', 0, 1, 'L', true);
$pdf->SetFont('Arial', '', 12);
$pdf->Ln(2);
$pdf->Cell(0, 8, utf8_decode('Nombre: ' . $_SESSION['compra']['nombre']), 0, 1);
$pdf->Cell(0, 8, utf8_decode('RUT: ' . $_SESSION['compra']['rut']), 0, 1);
$pdf->Cell(0, 8, utf8_decode('Correo: ' . $_SESSION['compra']['correo']), 0, 1);
$pdf->Ln(8);

// Detalle de la Transacción
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(0, 10, utf8_decode('Detalle de la Transacción'), 0, 1, 'L', true);
$pdf->SetFont('Arial', '', 12);
$pdf->Ln(2);

// Detalles en columnas
$pdf->Cell(70, 8, utf8_decode('Tipo de Vehículo:'), 0, 0);
$pdf->Cell(0, 8, utf8_decode($_SESSION['compra']['tipo']), 0, 1);
$pdf->Cell(70, 8, utf8_decode('Marca:'), 0, 0);
$pdf->Cell(0, 8, utf8_decode($_SESSION['compra']['marca']), 0, 1);
$pdf->Cell(70, 8, utf8_decode('Modelo:'), 0, 0);
$pdf->Cell(0, 8, utf8_decode($_SESSION['compra']['modelo']), 0, 1);
$pdf->Cell(70, 8, utf8_decode('Año:'), 0, 0);
$pdf->Cell(0, 8, utf8_decode($_SESSION['compra']['anio']), 0, 1);
$pdf->Cell(70, 8, utf8_decode('Número de Motor:'), 0, 0);
$pdf->Cell(0, 8, utf8_decode($_SESSION['compra']['num_motor']), 0, 1);
$pdf->Cell(70, 8, utf8_decode('Número de Chasis:'), 0, 0);
$pdf->Cell(0, 8, utf8_decode($_SESSION['compra']['num_chasis']), 0, 1);
$pdf->Cell(70, 8, utf8_decode('Monto Pagado:'), 0, 0);
$pdf->Cell(0, 8, '$' . number_format($_SESSION['compra']['precio'], 0, ',', '.'), 0, 1);
$pdf->Ln(10);
$buyOrder1=$_SESSION['compra']['orden_compra'];
// Número de Póliza SOAP (generado aleatoriamente)
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, utf8_decode('Número de Póliza: ' . $_SESSION['compra']['poliza']), 0, 1, 'L');
$pdf->Ln(8);

// Código de Orden
$pdf->SetFont('Arial', 'B', 14);
$pdf->SetFillColor(230, 230, 230);
$pdf->Cell(0, 10, utf8_decode('Código de Orden'), 0, 1, 'L', true);
$pdf->SetFont('Courier', '', 24);
$pdf->Cell(0, 12, utf8_decode("| {$_SESSION['compra']['orden_compra']} |"), 0, 1, 'C');
$pdf->Ln(5);
$pdf->SetY(-15);
$pdf->SetFont('Arial', 'I', 8);
$pdf->Cell(0, 10, utf8_decode('Página: ') . $pdf->PageNo(), 0, 0, 'C');


    // Guardar el PDF en un archivo temporal
    $pdfOutput = __DIR__ . '/data/soap' . time() . '.pdf';
    $pdf->Output('F', $pdfOutput);



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

    
    $mail->Subject = 'Confirmacion de Reserva';
    $mail->Body    = "Hola $nombre,\n\nTu soap ha sido pagado exitosamente. Gracias por confiar en RenzoMotors. Adjunto encontrarás el PDF con los detalles de tu SOAP.\n\nSaludos,\nRenzoMotors";

    
    $mail->addAttachment($pdfOutput);

    // Enviar el correo
    $mail->send();


} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}

class PDF extends FPDF
{
    function Header()
    {
        // Logo de la web
        $this->Image('../../logo_tr.png', 10, 20, 30); // Posición x, y, y ancho del logo
        $this->SetFont('Arial', 'B', 16);

        // Título centrado con relleno
        $this->SetFillColor(200, 220, 255);
        $this->Cell(0, 10, 'Comprobante de Pago - SOAP', 0, 1, 'C', true);
        $this->Ln(10);
    }

    function Footer()
    {
        // Pie de página con número de página
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, utf8_decode('Página: ') . $this->PageNo(), 0, 0, 'C');
    }

    function generarBoletaSOAP($data, $buyOrder)
    {
        // Configuración de fuente inicial
        $this->SetFont('Arial', '', 12);

        // Fecha y Hora
        $this->SetFillColor(240, 240, 240);
        $this->Cell(0, 10, utf8_decode('Fecha: ' . $data['fecha_actual']), 0, 1, 'R');
        $this->Cell(0, 10, utf8_decode('Hora: ' . $data['hora_actual']), 0, 1, 'R');
        $this->Ln(5);

        // Información del Cliente
        $this->SetFont('Arial', 'B', 14);
        $this->SetFillColor(230, 230, 230);
        $this->Cell(0, 10, 'Datos del Cliente', 0, 1, 'L', true);
        $this->SetFont('Arial', '', 12);
        $this->Ln(2);
        $this->Cell(0, 8, utf8_decode('Nombre: ' . $data['nombre']), 0, 1);
        $this->Cell(0, 8, utf8_decode('RUT: ' . $data['rut']), 0, 1);
        $this->Cell(0, 8, utf8_decode('Correo: ' . $data['correo']), 0, 1);
        $this->Ln(8);

        // Detalle de la Transacción
        $this->SetFont('Arial', 'B', 14);
        $this->Cell(0, 10,  utf8_decode('Detalle de la Transacción'), 0, 1, 'L', true);
        $this->SetFont('Arial', '', 12);
        $this->Ln(2);

        // Detalles en columnas
        $this->Cell(70, 8, utf8_decode('Tipo de Vehículo:'), 0, 0);
        $this->Cell(0, 8, utf8_decode($data['tipo']), 0, 1);
        $this->Cell(70, 8, utf8_decode('Marca:'), 0, 0);
        $this->Cell(0, 8, utf8_decode($data['marca']), 0, 1);
        $this->Cell(70, 8, utf8_decode('Modelo:'), 0, 0);
        $this->Cell(0, 8, utf8_decode($data['modelo']), 0, 1);
        $this->Cell(70, 8, utf8_decode('Año:'), 0, 0);
        $this->Cell(0, 8, utf8_decode($data['anio']), 0, 1);
        $this->Cell(70, 8, utf8_decode('Número de Motor:'), 0, 0);
        $this->Cell(0, 8, utf8_decode($data['num_motor']), 0, 1);
        $this->Cell(70, 8, utf8_decode('Número de Chasis:'), 0, 0);
        $this->Cell(0, 8, utf8_decode($data['num_chasis']), 0, 1);
        $this->Cell(70, 8, utf8_decode('Monto Pagado:'), 0, 0);
        $this->Cell(0, 8, '$' . number_format($data['precio'], 0, ',', '.'), 0, 1);
        $this->Ln(10);

        // Número de Póliza SOAP (generado aleatoriamente)
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 10, utf8_decode('Número de Póliza: ' . $data['poliza']), 0, 1, 'L');
        $this->Ln(8);

        // Código de Orden
        $this->SetFont('Arial', 'B', 14);
        $this->SetFillColor(230, 230, 230);
        $this->Cell(0, 10, utf8_decode('Código de Orden'), 0, 1, 'L', true);
        $this->SetFont('Courier', '', 24);
        $this->Cell(0, 12, utf8_decode("| $buyOrder |"), 0, 1, 'C');
        $this->Ln(5);
    }
}

function trimPathToUtils($path)
{
    
    $path = str_replace('\\', '/', $path);

    
    $utilsPath = strstr($path, '/renzomotors');

    return $utilsPath ?: $path; 
}

function botonBoleta($savePath)
{
    $pdf = new PDF();
    $pdf->AddPage();
    $pdf->generarBoletaSoap($_SESSION['compra'], $_SESSION['compra']['orden_compra']);
    $pdf->Output('F', $savePath);

    $savePath = trimPathToUtils($savePath);
    return "<i>Transacción aprobada</i><a href='" . "/xampp" . htmlspecialchars($savePath) . "' class='btn btn-primary'>Descargar Boleta</a>";
}

?>