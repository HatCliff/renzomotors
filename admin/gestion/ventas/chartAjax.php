<?php
// Archivo: getVentas.php
include './queries.php';  // Incluir tu archivo de conexión a la base de datos

// Obtener el parámetro 'local' enviado por AJAX (si existe o es vacío, asignar 'all')
$local = isset($_GET['local']) && !empty($_GET['local']) ? $_GET['local'] : 'all';

// Llamar a la función HistoricoVentasPorMes
HistoricoVentasPorMes($local);

?>