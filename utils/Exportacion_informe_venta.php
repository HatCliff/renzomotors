<?php

require_once("../config/conexion.php"); // Conexión a la base de datos

require('../admin/gestion/ventas/queries.php');

require './../vendor/autoload.php';
$carpetaMain = 'http://localhost/xampp/renzomotors/';
use Fpdf\Fpdf;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

/*
// Función para obtener el histórico de ventas por mes
function HistoricoVentasPorMes($local = null) {
    global $conexion;
    $query = "SELECT MONTH(fecha_compra_a) as mes, COUNT(*) as ventas FROM registro_accesorio";
    if ($local != null) {
        $query .= " WHERE sucursal_compra = '$local'";
    }
    $query .= " GROUP BY MONTH(fecha_compra_a);";
    $result = mysqli_query($conexion, $query);
    $data = [];
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }
    }
    return $data;
}
*/
// Crear el PDF
// Crear el PDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);

//  logo 
$logoPath = $carpetaMain . "logo.png";
$pdf->Image($logoPath, 5, 5, 10); // x, y, ancho (ajusta según necesites)

// Título del PDF
$pdf->Cell(0, 10, 'Informe de Ventas y Reservas', 0, 1, 'C');
$pdf->Ln(10);

// Función para crear encabezados de sección
function crearSeccion($pdf, $titulo, $datos, $encabezados)
{
    // Título de la sección
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(0, 10, $titulo, 0, 1, 'C');
    $pdf->Ln(5);

    // Calcular ancho total de la tabla
    $columnWidth = 60; // Ancho de cada columna
    $totalWidth = $columnWidth * count($encabezados);
    $startX = ($pdf->GetPageWidth() - $totalWidth) / 2; // Calcular posición inicial (centrado)

    // Encabezados de la tabla
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->SetX($startX); // Establecer posición X inicial
    foreach ($encabezados as $encabezado) {
        $pdf->Cell($columnWidth, 10, $encabezado, 1, 0, 'C');
    }
    $pdf->Ln();

    // Datos de la tabla
    $pdf->SetFont('Arial', '', 10);
    foreach ($datos as $fila) {
        $pdf->SetX($startX); // Restablecer posición X inicial para cada fila
        foreach ($fila as $valor) {
            $pdf->Cell($columnWidth, 10, $valor, 1, 0, 'C');
        }
        $pdf->Ln();
    }
    $pdf->Ln(10);
}

// Ventas de Accesorios
$datosAccesorios = [
    ['Total de ventas', ContadorVentaAccesorios()],
    ['Valor total de ventas', '$' . number_format(ContadorVentaTotalAccesorios(), 2)]
];
crearSeccion($pdf, 'Ventas de Accesorios', $datosAccesorios, [utf8_decode('Descripción'), 'Valor']);

// Reservas Concretadas
$reservas = ContadorReservasConcretadas();
$datosReservas = [
    ['Reservas concretadas', $reservas['reservas_concretadas']],
    ['Reservas no concretadas', $reservas['reservas_no_concretadas']]
];
crearSeccion($pdf, 'Reservas Concretadas', $datosReservas, [utf8_decode('Descripción'), 'Cantidad']);

// Seguros Contratados
$datosSeguros = [
    ['Total seguros contratados', ContadorSegurosContratados()]
];
crearSeccion($pdf, 'Seguros Contratados', $datosSeguros, [utf8_decode('Descripción'), 'Cantidad']);

/*
// Histórico de Ventas por Mes
$historico = HistoricoVentasPorMes('all');
if (!empty($historico)) {
    $datosHistorico = [];
    foreach ($historico as $mes) {
        $datosHistorico[] = ['Mes ' . $mes['mes'], $mes['ventas']];
    }
    crearSeccion($pdf, '4. Histórico de Ventas por Mes:', $datosHistorico, ['Mes', 'Ventas']);
} else {
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(0, 10, 'No hay datos disponibles.', 0, 1);
    $pdf->Ln(5);
}
*/
// Pie de página
date_default_timezone_set("America/Santiago");
$pdf->SetFont('Arial', 'I', 8);
$pdf->Cell(0, 10, utf8_decode('Documento generado automáticamente. Fecha: ' . date("d-m-Y")), 0, 0, 'C');

// Salida del PDF
$pdf->Output('D', 'InformeVentas.pdf'); // Abre el PDF en el navegador
?>