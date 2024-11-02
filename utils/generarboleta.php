<?php
require './../vendor/autoload.php';

use Fpdf\Fpdf;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

class PDF extends FPDF {
    function Header() {
        $this->SetFont('Arial', 'B', 16);
        $this->Cell(0, 10, 'Boleta de Compra', 0, 1, 'C');
        $this->Ln(5);
    }

    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Página ' . $this->PageNo(), 0, 0, 'C');
    }

    function generarBoleta($data, $buyOrder) {
        $this->SetFont('Arial', '', 12);

        // Información del cliente
        $this->Cell(0, 10, 'Fecha: ' . $data['fecha_actual'], 0, 1, 'R');
        $this->Cell(0, 10, 'Hora: ' . $data['hora_actua'], 0, 1, 'R');
        $this->Ln(5);

        // Detalles del comprador
        $this->Cell(0, 10, 'Datos del Cliente', 0, 1);
        $this->Cell(0, 10, 'RUT Cliente: ' . $data['rut'], 0, 1);
        $this->Cell(0, 10, 'Nombre: ' . $data['nombre'], 0, 1);
        $this->Cell(0, 10, 'Correo: ' . $data['correo'], 0, 1);
        $this->Cell(0, 10, 'Teléfono: ' . $data['telefono'], 0, 1);
        $this->Ln(5);

        // Detalles de la compra
        $this->Cell(0, 10, 'Detalle de la Compra', 0, 1);
        $this->Cell(0, 10, 'ID Vehículo: ' . $data['id_vehiculo'], 0, 1);
        $this->Cell(0, 10, 'Color: ' . $data['color'], 0, 1);
        $this->Cell(0, 10, 'Sucursal: ' . $data['sucursal'], 0, 1);
        $this->Cell(0, 10, 'Forma de Pago: ' . $data['pago'], 0, 1);
        $this->Cell(0, 10, 'Total: $' . number_format($data['precio'], 0, ',', '.'), 0, 1);
        $this->Ln(10);

        // Generación del código de barras
        $this->SetFont('Arial', '', 12);
        $this->Cell(0, 10, 'Código de Orden: ' . $buyOrder, 0, 1, 'C');
        $this->SetFont('Courier', '', 24);
        $this->Cell(0, 10, "| $buyOrder |", 0, 1, 'C'); // Representación simple del código de barras
        
        $this->Ln(10);

        // Generación del código QR
        $qrCode = new QrCode("https://renzomotors.cl/detalle-compra?id=" . $buyOrder);
        $qrCode->setSize(100);

        $writer = new PngWriter();
        $qrImage = $writer->write($qrCode);

        // Guardar el QR como archivo temporal
        $tempQR = tempnam(sys_get_temp_dir(), 'qr_') . '.png';
        $qrImage->saveToFile($tempQR);

        // Insertar el QR en la boleta
        $this->Image($tempQR, 10, 150, 50, 50, 'PNG');

        // Eliminar el archivo temporal después de usarlo
        unlink($tempQR);
    }
}

function trimPathToUtils($path) {
    // Normalizamos los separadores de directorio a "/"
    $path = str_replace('\\', '/', $path);
    
    // Encontramos la posición de "/utils" y retornamos el resto de la cadena desde allí
    $utilsPath = strstr($path, '/renzomotors');
    
    return $utilsPath ?: $path; // Si no encuentra "/utils", retorna el path completo
}

function botonBoleta($savePath) {
    $pdf = new PDF();
    $pdf->AddPage();
    $pdf->generarBoleta($_SESSION['compra'], $_SESSION['compra']['orden_compra']);
    $pdf->Output('F', $savePath);

    $savePath = trimPathToUtils($savePath);
    return "<i>Transacción aprobada</i><a href='" ."/xampp" . htmlspecialchars($savePath) . "' class='btn btn-primary'>Descargar Boleta</a>";
}

?>
