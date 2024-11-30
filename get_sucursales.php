<?php
include 'config/conexion.php'; // Conexión a la base de datos

if (isset($_GET['zona']) && !empty($_GET['zona'])) {
    $zona = mysqli_real_escape_string($conexion, $_GET['zona']);
    $query = "SELECT id_sucursal, nombre_sucursal FROM sucursal WHERE zona_sucursal = '$zona'";
    $result = mysqli_query($conexion, $query);

    $sucursales = [];
    if ($result->num_rows > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $sucursales[] = $row;
        }
    }

    echo json_encode($sucursales);
}
?>
