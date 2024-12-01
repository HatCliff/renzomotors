<?php

require_once("../config/conexion.php"); // Conexión a la base de datos

require('../admin/gestion/ventas/queries.php');

require './../vendor/autoload.php';

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
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);

// Título del PDF
$pdf->Cell(0, 10, 'Informe de Ventas y Reservas', 0, 1, 'C');
$pdf->Ln(10);

// Información de ventas de accesorios
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, '1. Ventas de Accesorios:', 0, 1);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(0, 10, 'Total de ventas: ' . ContadorVentaAccesorios(), 0, 1);
$pdf->Cell(0, 10, 'Valor total de ventas: $' . number_format(ContadorVentaTotalAccesorios(), 2), 0, 1);
$pdf->Ln(5);

// Información de reservas
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, '2. Reservas Concretadas:', 0, 1);
$pdf->SetFont('Arial', '', 10);
$reservas = ContadorReservasConcretadas();
$pdf->Cell(0, 10, 'Reservas concretadas: ' . $reservas['reservas_concretadas'], 0, 1);
$pdf->Cell(0, 10, 'Reservas no concretadas: ' . $reservas['reservas_no_concretadas'], 0, 1);
$pdf->Ln(5);

// Información de seguros contratados
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, '3. Seguros Contratados:', 0, 1);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(0, 10, 'Total seguros contratados: ' . ContadorSegurosContratados(), 0, 1);
$pdf->Ln(5);
/*
// Ventas por mes
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, '4. Historico de Ventas por Mes:', 0, 1);
$pdf->SetFont('Arial', '', 10);
$historico = HistoricoVentasPorMes('all');
if (!empty($historico)) {
    foreach ($historico as $mes) {
        $pdf->Cell(0, 10, 'Mes: ' . $mes['mes'] . ' - Ventas: ' . $mes['ventas'], 0, 1);
    }
} else {
    $pdf->Cell(0, 10, 'No hay datos disponibles.', 0, 1);
}
*/

// Salida del PDF
$pdf->Output('D', 'InformeVentas.pdf'); // Abre el PDF en el navegador
?>
