<?php
require './../vendor/autoload.php';

use Fpdf\Fpdf;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

class PDF extends FPDF
{
    function Header()
    {
        $this->SetFont('Arial', 'B', 16);
        $this->Cell(0, 10, 'Boleta de Compra', 0, 1, 'C');
        $this->Ln(5);
    }

    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Página ' . $this->PageNo(), 0, 0, 'C');
    }

    function generarBoleta($data, $buyOrder)
    {
        include('../config/conexion.php');
        $dato = [];
        $datos_s = $conexion->query("SELECT nombre_sucursal FROM sucursal WHERE id_sucursal = {$data['sucursal']}");
        $dato['nombre_sucursal'] = $datos_s->fetch_assoc()['nombre_sucursal'];

        $datos_c = $conexion->query("SELECT nombre_color FROM color WHERE id_color = {$data['color']}");
        $dato['nombre_color'] = $datos_c->fetch_assoc()['nombre_color'];

        $datos_v = $conexion->query("SELECT nombre_modelo FROM vehiculo WHERE id_vehiculo = {$data['id_vehiculo']}");
        $dato['nombre_modelo'] = $datos_v->fetch_assoc()['nombre_modelo'];

        $this->SetFont('Arial', '', 12);

        // Información del cliente
        $this->Cell(0, 10, utf8_decode('Fecha: ' . $data['fecha_actual']), 0, 1, 'R');
        $this->Cell(0, 10, utf8_decode('Hora: ' . $data['hora_actua']), 0, 1, 'R');
        $this->Ln(5);

        // Detalles del comprador
        $this->Cell(0, 10, utf8_decode('Datos del Cliente'), 0, 1);
        $this->Cell(0, 10, utf8_decode('RUT Cliente: ' . $data['rut']), 0, 1);
        $this->Cell(0, 10, utf8_decode('Nombre: ' . $data['nombre']), 0, 1);
        $this->Cell(0, 10, utf8_decode('Correo: ' . $data['correo']), 0, 1);
        $this->Cell(0, 10, utf8_decode('Teléfono: ' . $data['telefono']), 0, 1);
        $this->Ln(5);

        // Detalles de la compra
        $this->Cell(0, 10, utf8_decode('Detalle de la Compra'), 0, 1);
        $this->Cell(0, 10, utf8_decode('ID Vehículo: ' . $dato['nombre_modelo']), 0, 1);
        $this->Cell(0, 10, utf8_decode('Color: ' . $dato['nombre_color']), 0, 1);
        $this->Cell(0, 10, utf8_decode('Sucursal: ' . $dato['nombre_sucursal']), 0, 1);
        // $this->Cell(0, 10, utf8_decode('Forma de Pago: ' . $data['pago']), 0, 1);
        $this->Cell(0, 10, utf8_decode('Total: $' . number_format($data['precio'], 0, ',', '.')), 0, 1);
        $this->Ln(10);

        // Generación del código de barras
        $this->SetFont('Arial', '', 12);
        $this->Cell(0, 10, utf8_decode('Código de Orden: ' . $buyOrder), 0, 1, 'C');
        $this->SetFont('Courier', '', 24);
        $this->Cell(0, 10, "| $buyOrder |", 0, 1, 'C'); // Representación simple del código de barras

        $this->Ln(200);

        //// Generación del código QR
        $qrCode = new QrCode("https://renzomotors.cl/detalle-compra?id=" . $buyOrder);
        $qrCode->setSize(100);
        //
        $writer = new PngWriter();
        $qrImage = $writer->write($qrCode);
        //
        //// Guardar el QR como archivo temporal
        $tempQR = tempnam(sys_get_temp_dir(), 'qr_') . '.png';
        $qrImage->saveToFile($tempQR);
        //
        //// Insertar el QR en la boleta
        $this->Image($tempQR, 10, 200, 50, 50, 'PNG');
        //
        //// Eliminar el archivo temporal después de usarlo
        unlink($tempQR);

        //TODO: Contraseña
    }
}

function trimPathToUtils($path)
{
    // Normalizamos los separadores de directorio a "/"
    $path = str_replace('\\', '/', $path);

    // Encontramos la posición de "/utils" y retornamos el resto de la cadena desde allí
    $utilsPath = strstr($path, '/renzomotors');

    return $utilsPath ?: $path; // Si no encuentra "/utils", retorna el path completo
}

function botonBoleta($savePath)
{
    $pdf = new PDF();
    $pdf->AddPage();
    $pdf->generarBoleta($_SESSION['compra'], $_SESSION['compra']['orden_compra']);
    $pdf->Output('F', $savePath);

    $savePath = trimPathToUtils($savePath);
    return "<i>Transacción aprobada</i><a href='" . "/xampp" . htmlspecialchars($savePath) . "' class='btn btn-primary'>Descargar Boleta</a>";
}

?>