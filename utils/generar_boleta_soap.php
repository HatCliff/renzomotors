<?php
require '../../vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Fpdf\Fpdf;
$correo = $_SESSION['correo'];
$nombre = $_SESSION['nombre'];

   // Crear el PDF
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 12);

    // Añadir el contenido al PDF con utf8_decode
    $pdf->Cell(0, 10, utf8_decode("Tu soap ha sido pagado exitosamente. Gracias por confiar en RenzoMotors."), 0, 1);
    $pdf->Ln(10);
    $pdf->Cell(0, 10, utf8_decode("Aquí están los detalles:"), 0, 1);
    $pdf->Ln(5);

    $pdf->Cell(0, 10, utf8_decode(string: 'Fecha: ' . $_SESSION['compra']['fecha_actual']), 0, 1, 'R');
    $pdf->Cell(0, 10, utf8_decode('Hora: ' . $_SESSION['compra']['hora_actual']), 0, 1, 'R');
    $pdf->Ln(5);

        // Detalles del comprador
        $pdf->Cell(0, 10, utf8_decode('Datos del Cliente'), 0, 1);
        $pdf->Cell(0, 10, utf8_decode('Nombre: ' . $_SESSION['compra']['nombre']), 0, 1);
        $pdf->Cell(0, 10, utf8_decode('RUT: ' . $_SESSION['compra']['rut']), 0, 1);
        $pdf->Cell(0, 10, utf8_decode('Correo: ' . $_SESSION['compra']['correo']), 0, 1);
        $pdf->Ln(5);

        // Detalles de la transacción
        $pdf->Cell(0, 10, utf8_decode('Detalle de la Transacción'), 0, 1);
        $pdf->Cell(0, 10, utf8_decode('Tipo de Vehículo: ' . $_SESSION['compra']['tipo']), 0, 1);
        $pdf->Cell(0, 10, utf8_decode('Marca: ' . $_SESSION['compra']['marca']), 0, 1);
        $pdf->Cell(0, 10, utf8_decode('Modelo: ' . $_SESSION['compra']['modelo']), 0, 1);
        $pdf->Cell(0, 10, utf8_decode('Año: ' . $_SESSION['compra']['anio']), 0, 1);
        $pdf->Cell(0, 10, utf8_decode('Número de Motor: ' . $_SESSION['compra']['num_motor']), 0, 1);
        $pdf->Cell(0, 10, utf8_decode('Número de Chasis: ' . $_SESSION['compra']['num_chasis']), 0, 1);
        $pdf->Cell(0, 10, utf8_decode('Monto Pagado: $' . number_format($_SESSION['compra']['precio'], 0, ',', '.')), 0, 1);
        $pdf->Ln(10);
        $buyOrder1=$_SESSION['compra']['orden_compra'];
        
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(0, 10, utf8_decode('Código de Orden: ' . $buyOrder1), 0, 1, 'C');
        $pdf->SetFont('Courier', '', 24);
        $pdf->Cell(0, 10, "| $buyOrder1 |", 0, 1, 'C'); // Representación simple del código de barras

        $pdf->Ln(200);

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
        $this->SetFont('Arial', 'B', 16);
        $this->Cell(0, 10, 'Comprobante Pago SOAP', 0, 1, 'C');
        $this->Ln(5);
    }

    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, utf8_decode(string: 'Página: ' . $this->PageNo()), 0, 0, 'C');

    }

    function generarBoletaSOAP($data, $buyOrder)
    {
        $this->SetFont('Arial', '', 12);

        // Información del cliente
        $this->Cell(0, 10, utf8_decode(string: 'Fecha: ' . $data['fecha_actual']), 0, 1, 'R');
        $this->Cell(0, 10, utf8_decode('Hora: ' . $data['hora_actual']), 0, 1, 'R');
        $this->Ln(5);

        // Detalles del comprador
        $this->Cell(0, 10, utf8_decode('Datos del Cliente'), 0, 1);
        $this->Cell(0, 10, utf8_decode('Nombre: ' . $data['nombre']), 0, 1);
        $this->Cell(0, 10, utf8_decode('RUT: ' . $data['rut']), 0, 1);
        $this->Cell(0, 10, utf8_decode('Correo: ' . $data['correo']), 0, 1);
        $this->Ln(5);

        // Detalles de la transacción
        $this->Cell(0, 10, utf8_decode('Detalle de la Transacción'), 0, 1);
        $this->Cell(0, 10, utf8_decode('Tipo de Vehículo: ' . $data['tipo']), 0, 1);
        $this->Cell(0, 10, utf8_decode('Marca: ' . $data['marca']), 0, 1);
        $this->Cell(0, 10, utf8_decode('Modelo: ' . $data['modelo']), 0, 1);
        $this->Cell(0, 10, utf8_decode('Año: ' . $data['anio']), 0, 1);
        $this->Cell(0, 10, utf8_decode('Número de Motor: ' . $data['num_motor']), 0, 1);
        $this->Cell(0, 10, utf8_decode('Número de Chasis: ' . $data['num_chasis']), 0, 1);
        $this->Cell(0, 10, utf8_decode('Monto Pagado: $' . number_format($data['precio'], 0, ',', '.')), 0, 1);
        $this->Ln(10);

        // Generación del código de barras
        $this->SetFont('Arial', '', 12);
        $this->Cell(0, 10, utf8_decode('Código de Orden: ' . $buyOrder), 0, 1, 'C');
        $this->SetFont('Courier', '', 24);
        $this->Cell(0, 10, "| $buyOrder |", 0, 1, 'C'); 

        $this->Ln(200);

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