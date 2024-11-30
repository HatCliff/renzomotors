<?php
// Archivo: getVentas.php
include './queries.php';  // Incluir tu archivo de conexión a la base de datos

// Obtener el parámetro 'local' enviado por AJAX (si existe)
$local = isset($_GET['local']) ? $_GET['local'] : null;
if ($local === 'all') {
    $local = null;
}

// Llamar a la función HistoricoVentasPorMes
HistoricoVentasPorMes($local);

?>