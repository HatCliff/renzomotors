<?php
require __DIR__ . '/../vendor/autoload.php'; // modificado
include 'correo_accesorio.php';

use Fpdf\Fpdf;

class PDF extends FPDF
{
    function Header()
    {
        // Encabezado con título
        $this->SetFont('Arial', 'B', 14);
        $this->SetFillColor(220, 220, 220);
        $this->Cell(0, 10, utf8_decode('Comprobante de Pago - Accesorios'), 0, 1, 'C', true);
        $this->Ln(5);
    }

    function Footer()
    {
        // Pie de página con número de página
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, utf8_decode('Página ') . $this->PageNo(), 0, 0, 'C');
    }

    function generarBoleta($data)
    {
        require __DIR__ . '/../config/conexion.php';
        $dato = [];
        $datos_s = $conexion->query("SELECT nombre_sucursal FROM sucursal WHERE id_sucursal = {$data['sucursal_compra']}");
        $dato['nombre_sucursal'] = $datos_s->fetch_assoc()['nombre_sucursal'];

        $this->SetFont('Arial', '', 12);

        // Fecha y hora
        $this->Cell(0, 10, utf8_decode('Fecha: ' . $data['fecha_compra_a']), 0, 1, 'R');
        $this->Cell(0, 10, utf8_decode('Sucursal: ' . $dato['nombre_sucursal']), 0, 1, 'R');
        $this->Ln(10);

        // Sección de cliente
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 10, utf8_decode('Datos del Cliente'), 0, 1, 'L');
        $this->SetFont('Arial', '', 12);
        $this->Cell(0, 10, utf8_decode('Correo Cliente: ' . $data['correo_compra']), 0, 1);
        $this->Ln(10);

        // Detalles de los productos comprados
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 10, utf8_decode('Productos Comprados'), 0, 1);
        $this->SetFont('Arial', '', 10);

        $accesorios = array_filter(explode(', ', $data['listado_accesorio']));
        foreach ($accesorios as $accesorio) {
            list($sku, $cantidad) = explode(':', $accesorio);
            $stmt = $conexion->prepare("SELECT nombre_accesorio FROM accesorio WHERE sku_accesorio = ?");
            $stmt->bind_param('s', $sku);
            $stmt->execute();
            $resultado = $stmt->get_result();

            if ($resultado->num_rows > 0) {
                $nombre_sku = $resultado->fetch_assoc()['nombre_accesorio'];
                $this->Cell(0, 10, utf8_decode('Producto: ' . $nombre_sku . ' - Cantidad: ' . $cantidad), 0, 1);
            } else {
                $this->Cell(0, 10, utf8_decode('Producto: ' . $sku . ' no encontrado - Cantidad: ' . $cantidad), 0, 1);
            }
            $stmt->close();
        }
        $this->Ln(10);

        // Código de barras (Código Verificador)
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 10, utf8_decode('Código de Orden'), 0, 1, 'L');
        $this->SetFont('Courier', '', 24);
        $codigoVerificador = $data['cod_compra'];
        $this->Cell(0, 10, "| $codigoVerificador |", 0, 1, 'C');
        $this->Ln(10);
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
    $correo = $_SESSION['compra_accesorio']['correo_compra'];

    // Crear una nueva instancia del PDF
    $pdf = new PDF();
    $pdf->AddPage();

    // Generar la boleta usando los datos de la sesión
    $pdf->generarBoleta($compra);

    // Guardar el archivo PDF en la ruta indicada
    $pdf->Output('F', $savePath);

    // Ajustar la ruta para eliminar parte del directorio
    $savePath = trimPathToUtils($savePath);

    enviarCorreo($correo, $savePath);

    // Retornar el HTML para descargar la boleta
    return "<i>Transacción aprobada</i><a href='" . "/xampp" . htmlspecialchars($savePath) . "' class='btn btn-primary'>Descargar Boleta</a>";
}

?>