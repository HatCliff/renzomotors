<?php
require __DIR__ . '/../vendor/autoload.php'; // modificado
include 'correo_accesorio.php';

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

        require __DIR__ .'/../config/conexion.php';
        $dato = [];
        $datos_s = $conexion->query("SELECT nombre_sucursal FROM sucursal WHERE id_sucursal = {$data['sucursal_compra']}");
        $dato['nombre_sucursal'] = $datos_s->fetch_assoc()['nombre_sucursal'];

        $this->SetFont('Arial', '', 12);

        // Información de la compra
        $this->Cell(0, 10, utf8_decode('Fecha: ' . $data['fecha_compra_a']), 0, 1, 'R');
        $this->Cell(0, 10, utf8_decode('Sucursal: ' . $dato['nombre_sucursal']), 0, 1, 'R');
        $this->Ln(5);

        // Detalles del cliente
        $this->Cell(0, 10, utf8_decode('Correo Cliente: ' . $data['correo_compra']), 0, 1);
        $this->Ln(5);

        // Detalles de los accesorios
        $this->Cell(0, 10, utf8_decode('Productos Comprados'), 0, 1);
        $this->SetFont('Arial', '', 10);

        // Aquí asumimos que el listado de accesorios está en el campo 'listado_accesorio'
        $accesorios = array_filter(explode(', ', $data['listado_accesorio']));

        foreach ($accesorios as $accesorio) {
            // Dividimos el accesorio en SKU y cantidad
            list($sku, $cantidad) = explode(':', $accesorio);

            // Consulta segura con sentencia preparada
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

            // Cerramos el statement
            $stmt->close();
        }


        $this->Ln(10);

        // Código de barras (Código verificador)
        $this->SetFont('Arial', '', 12);
        $codigoVerificador = $data['cod_compra'];
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