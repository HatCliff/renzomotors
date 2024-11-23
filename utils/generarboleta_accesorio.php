<?php
require './../vendor/autoload.php';

use Fpdf\Fpdf;

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

    function generarBoleta($data)
    {
        $this->SetFont('Arial', '', 12);

        // Información de la compra
        $this->Cell(0, 10, utf8_decode('Fecha: ' . $data['fecha_compra_a']), 0, 1, 'R');
        $this->Cell(0, 10, utf8_decode('Sucursal: ' . $data['sucursal_compra']), 0, 1, 'R');
        $this->Ln(5);

        // Detalles del cliente
        $this->Cell(0, 10, utf8_decode('Correo Cliente: ' . $data['correo_compra']), 0, 1);
        $this->Ln(5);

        // Detalles de los accesorios
        $this->Cell(0, 10, utf8_decode('Productos Comprados'), 0, 1);
        $this->SetFont('Arial', '', 10);
        
        // Aquí asumimos que el listado de accesorios está en el campo 'listado_accesorio'
        $accesorios = explode(', ', $data['listado_accesorio']);
        
        foreach ($accesorios as $accesorio) {
            // Aquí asumimos que cada accesorio tiene el formato 'SKU:CANTIDAD' para la concatenación
            list($sku, $cantidad) = explode(':', $accesorio);
            $this->Cell(0, 10, utf8_decode('SKU: ' . $sku . ' - Cantidad: ' . $cantidad), 0, 1);
        }

        $this->Ln(10);

        // Código de barras (Código verificador)
        $this->SetFont('Arial', '', 12);
        $codigoVerificador = 'n' . str_pad($data['sucursal_id'], 3, '0', STR_PAD_LEFT) . date('dmY', strtotime($data['fecha_compra_a'])) . str_pad($data['cantidad_compras'], 4, '0', STR_PAD_LEFT);
        $this->Cell(0, 10, utf8_decode('Código de Orden: ' . $data['cod_orden']), 0, 1, 'C');
        $this->SetFont('Courier', '', 24);
        $this->Cell(0, 10, "| $codigoVerificador |", 0, 1, 'C'); // Representación simple del código de barras

        $this->Ln(200);
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
    // Obtener los datos de la compra y cod_orden desde la sesión
    $compra = $_SESSION['compra_accesorio'];

    // Crear una nueva instancia del PDF
    $pdf = new PDF();
    $pdf->AddPage();

    // Generar la boleta usando los datos de la sesión
    $pdf->generarBoleta($compra);

    // Guardar el archivo PDF en la ruta indicada
    $pdf->Output('F', $savePath);

    // Ajustar la ruta para eliminar parte del directorio
    $savePath = trimPathToUtils($savePath);

    // Retornar el HTML para descargar la boleta
    return "<i>Transacción aprobada</i><a href='" . "/xampp" . htmlspecialchars($savePath) . "' class='btn btn-primary'>Descargar Boleta</a>";
}

?>
