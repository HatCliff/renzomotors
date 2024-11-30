<?php

require('../config/conexion.php');

require './../vendor/autoload.php';

use Fpdf\Fpdf;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

// Función para contar ventas de accesorios
function ContadorVentaAccesorios() {
    global $conexion;
    $query = "SELECT COUNT(*) as count FROM registro_accesorio;";
    $result = mysqli_query($conexion, $query);
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        return $row['count'];
    } else {
        return "Error: " . mysqli_error($conexion);
    }
}

// Función para calcular el valor total de ventas
function ContadorVentaTotalAccesorios() {
    global $conexion;
    $query = "SELECT SUM(valor_compra) as total FROM registro_accesorio;";
    $result = mysqli_query($conexion, $query);
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        return $row['total'] ? $row['total'] : 0;
    } else {
        return "Error: " . mysqli_error($conexion);
    }
}

// Función para contar reservas concretadas y no concretadas
function ContadorReservasConcretadas() {
    global $conexion;
    $query = "
        SELECT 
            COUNT(CASE WHEN compra_concretada IS NOT NULL THEN 1 END) AS reservas_concretadas,
            COUNT(CASE WHEN compra_concretada IS NULL THEN 1 END) AS reservas_no_concretadas
        FROM registro_reserva";
    $result = mysqli_query($conexion, $query);
    if ($result) {
        return mysqli_fetch_assoc($result);
    } else {
        return "Error:" . mysqli_error($conexion);
    }
}

// Función para contar seguros contratados
function ContadorSegurosContratados() {
    global $conexion;
    $query = "SELECT COUNT(*) as count FROM usuario_seguro;";
    $result = mysqli_query($conexion, $query);
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        return $row['count'];
    } else {
        return "Error: " . mysqli_error($conexion);
    }
}

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

// Ventas por mes
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, '4. Historico de Ventas por Mes:', 0, 1);
$pdf->SetFont('Arial', '', 10);
$historico = HistoricoVentasPorMes();
foreach ($historico as $mes) {
    $pdf->Cell(0, 10, 'Mes ' . $mes['mes'] . ': ' . $mes['ventas'] . ' ventas', 0, 1);
}

// Salida del PDF
$pdf->Output('D', 'InformeVentas.pdf'); // Abre el PDF en el navegador
?>
